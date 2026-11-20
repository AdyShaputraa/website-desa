<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = (int) $request->query('per_page', 10);

        if (! in_array($perPage, [10, 25, 50], true)) {
            $perPage = 10;
        }

        $users = $this->filteredQuery($request)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('users.index', [
            'users' => $users,
            'roles' => Role::orderBy('name')->pluck('name'),
            'filters' => [
                'search' => trim((string) $request->query('q', '')),
                'role' => (string) $request->query('role', ''),
                'status' => (string) $request->query('status', 'active'),
                'perPage' => $perPage,
            ],
            'activities' => Activity::with(['causer', 'subject'])->latest()->take(8)->get(),
        ]);
    }

    public function create(): View
    {
        return view('users.create', [
            'roles' => Role::orderBy('name')->pluck('name'),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $roles = $data['roles'];
        unset($data['roles']);

        $user = User::create([
            ...$data,
            'is_active' => $request->boolean('is_active'),
        ]);

        $user->syncRoles($roles);

        activity()
            ->causedBy($request->user())
            ->performedOn($user)
            ->withProperties(['roles' => $roles])
            ->log('roles_updated');

        return redirect()
            ->route('users.index')
            ->with('status', __('ui.users.created'));
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::orderBy('name')->pluck('name'),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $roles = $data['roles'];
        $isActive = $request->boolean('is_active');

        $this->guardRoleAndStatusChanges($request->user(), $user, $roles, $isActive);

        unset($data['roles']);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $data['is_active'] = $isActive;

        $user->update($data);
        $user->syncRoles($roles);

        activity()
            ->causedBy($request->user())
            ->performedOn($user)
            ->withProperties(['roles' => $roles])
            ->log('roles_updated');

        return redirect()
            ->route('users.index')
            ->with('status', __('ui.users.updated'));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => __('ui.users.guard_self')]);
        }

        if ($this->isLastActiveAdmin($user)) {
            return back()->withErrors(['user' => __('ui.users.guard_last_admin')]);
        }

        $user->delete();

        return back()->with('status', __('ui.users.deleted'));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        activity()
            ->causedBy($request->user())
            ->performedOn($user)
            ->log('restored');

        return back()->with('status', __('ui.users.restored'));
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->is($request->user())) {
            return back()->withErrors(['user' => __('ui.users.guard_self')]);
        }

        $user->forceDelete();

        return back()->with('status', __('ui.users.force_deleted'));
    }

    public function bulk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
            'action' => ['required', Rule::in(['activate', 'deactivate', 'delete'])],
        ]);

        $targets = User::whereIn('id', $data['ids'])->get();
        $updated = 0;
        $skipped = 0;

        foreach ($targets as $target) {
            $destructive = in_array($data['action'], ['deactivate', 'delete'], true);

            if ($destructive && ($target->is($request->user()) || $this->isLastActiveAdmin($target))) {
                $skipped++;

                continue;
            }

            match ($data['action']) {
                'activate' => $target->update(['is_active' => true]),
                'deactivate' => $target->update(['is_active' => false]),
                'delete' => $target->delete(),
            };

            $updated++;
        }

        $response = back()->with('status', __('ui.users.bulk_done', ['count' => $updated]));

        if ($skipped > 0) {
            $response->with('warning', __('ui.users.bulk_skipped', ['count' => $skipped]));
        }

        return $response;
    }

    public function export(Request $request): StreamedResponse
    {
        $users = $this->filteredQuery($request)->orderBy('name')->get();

        return response()->streamDownload(function () use ($users): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Name', 'Email', 'Roles', 'NIK', 'Phone', 'Status', 'Created At']);

            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->name,
                    $user->email,
                    $user->roles->pluck('name')->implode('|'),
                    $user->nik,
                    $user->phone,
                    $user->is_active ? 'active' : 'inactive',
                    $user->created_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, 'users-'.now()->format('Ymd-His').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function filteredQuery(Request $request): Builder
    {
        $search = trim((string) $request->query('q', ''));
        $role = (string) $request->query('role', '');
        $status = (string) $request->query('status', 'active');

        return User::query()
            ->with('roles')
            ->when($status === 'trashed', fn (Builder $query) => $query->onlyTrashed())
            ->when($status === 'inactive', fn (Builder $query) => $query->where('is_active', false))
            ->when($status === 'active', fn (Builder $query) => $query->where('is_active', true))
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                });
            })
            ->when($role !== '' && $role !== 'all', fn (Builder $query) => $query->role($role));
    }

    /**
     * @param  array<int, string>  $roles
     */
    private function guardRoleAndStatusChanges(User $actor, User $target, array $roles, bool $isActive): void
    {
        $removesOwnAdmin = $target->is($actor) && $target->hasRole('admin') && ! in_array('admin', $roles, true);
        $removesLastAdmin = $target->hasRole('admin')
            && (! in_array('admin', $roles, true) || ! $isActive)
            && $this->activeAdminCount($target) === 0;

        if ($target->is($actor) && ! $isActive) {
            throw ValidationException::withMessages(['is_active' => __('ui.users.guard_self')]);
        }

        if ($removesOwnAdmin) {
            throw ValidationException::withMessages(['roles' => __('ui.users.guard_self_role')]);
        }

        if ($removesLastAdmin) {
            throw ValidationException::withMessages(['roles' => __('ui.users.guard_last_admin')]);
        }
    }

    private function isLastActiveAdmin(User $user): bool
    {
        return $user->hasRole('admin')
            && $user->is_active
            && $this->activeAdminCount($user) === 0;
    }

    private function activeAdminCount(?User $exclude = null): int
    {
        return User::role('admin')
            ->where('is_active', true)
            ->when($exclude, fn (Builder $query) => $query->whereKeyNot($exclude->getKey()))
            ->count();
    }
}
