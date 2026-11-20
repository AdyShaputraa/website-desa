<?php

/*
 * Builds the Blade Icons manifest for Heroicons.
 *
 * On Docker Desktop for Windows, PHP's DirectoryIterator can skip files inside
 * bind-mounted directories. `php artisan icons:cache` relies on that iterator,
 * so the manifest it writes may miss most icons. This script scans the icon
 * directory with scandir() instead and writes the same manifest format.
 */

$basePath = dirname(__DIR__);
$iconPath = $basePath.'/vendor/blade-ui-kit/blade-heroicons/src/../resources/svg';
$manifestPath = $basePath.'/bootstrap/cache/blade-icons.php';

if (! is_dir($iconPath)) {
    fwrite(STDERR, "Heroicons directory not found: {$iconPath}\n");

    exit(1);
}

$icons = [];

foreach (scandir($iconPath) ?: [] as $entry) {
    if (str_ends_with($entry, '.svg')) {
        $icons[] = substr($entry, 0, -4);
    }
}

sort($icons);

$manifest = ['heroicons' => [$iconPath => $icons]];

if (! is_dir(dirname($manifestPath))) {
    mkdir(dirname($manifestPath), 0777, true);
}

file_put_contents(
    $manifestPath,
    '<?php return '.var_export($manifest, true).';'.PHP_EOL,
);

echo 'Blade icons manifest written: '.count($icons)." icons\n";
