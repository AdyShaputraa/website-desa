<?php

return [
    'app' => [
        'name' => 'Portal Desa Digital',
    ],

    'nav' => [
        'dashboard' => 'Dashboard',
        'language' => 'Language',
        'theme' => 'Theme',
        'theme_light' => 'Light',
        'theme_dark' => 'Dark',
        'theme_system' => 'System',
        'logout' => 'Log out',
        'open_menu' => 'Open navigation menu',
        'close_menu' => 'Close navigation menu',
        'main_navigation' => 'Main navigation',
        'skip' => 'Skip to main content',
        'expand_sidebar' => 'Expand sidebar',
        'collapse_sidebar' => 'Collapse sidebar',
    ],

    'footer' => [
        'credit' => 'Ady Shaputra - 17241002 - TI.5B',
    ],

    'common' => [
        'cancel' => 'Cancel',
    ],

    'auth' => [
        'page_title' => 'Sign in',
        'brand_subtitle' => 'Village service portal',
        'title' => 'Sign in to your account',
        'subtitle' => 'Use your email and password, or continue with a Google account.',
        'email' => 'Email',
        'email_placeholder' => 'name@email.com',
        'password' => 'Password',
        'password_placeholder' => 'Enter your password',
        'remember' => 'Remember me',
        'submit' => 'Sign in',
        'or' => 'or',
        'google' => 'Sign in with Google',
        'failed' => 'The email or password is incorrect.',
        'google_failed' => 'Google sign-in failed. Please try again.',
        'secure_note' => 'By signing in, you agree to the use of your data for village services.',
    ],

    'account' => [
        'menu' => 'User menu',
        'settings' => 'Settings',
        'change_password' => 'Change Password',
        'logout' => 'Logout',
    ],

    'settings' => [
        'title' => 'Settings',
        'eyebrow' => 'Account',
        'description' => 'Manage your account information and display preferences.',
        'account_info' => 'Account information',
        'account_info_desc' => 'The name and email used to sign in.',
        'name' => 'Name',
        'email' => 'Email',
        'role' => 'Role',
        'preferences' => 'Preferences',
        'preferences_desc' => 'Interface language and theme.',
        'save' => 'Save changes',
        'saved' => 'Account information updated.',
    ],

    'password' => [
        'title' => 'Change Password',
        'eyebrow' => 'Security',
        'description' => 'Update your account password regularly.',
        'current' => 'Current password',
        'new' => 'New password',
        'confirm' => 'Confirm new password',
        'save' => 'Save password',
        'saved' => 'Password updated.',
        'min_hint' => 'At least 8 characters.',
        'google_hint' => 'This account is linked to Google. Enter the current password if you have set one; otherwise you can keep signing in with Google.',
    ],

    'dashboard' => [
        'title' => 'Dashboard',
        'eyebrow' => 'Overview',
        'welcome' => 'Welcome, :name',
        'subtitle' => 'A summary of village service activity.',
    ],

    'stats' => [
        'population' => 'Total residents',
        'surat_total' => 'Total requests',
        'pengaduan_total' => 'Total complaints',
        'berita_published' => 'Published news',
        'surat_pending' => 'Pending requests',
        'surat_processing' => 'Requests in progress',
        'pengaduan_pending' => 'New complaints',
        'pengaduan_processing' => 'Complaints in progress',
        'surat_mine' => 'My requests',
        'surat_done' => 'Completed requests',
        'pengaduan_mine' => 'My complaints',
        'pengaduan_done' => 'Resolved complaints',
    ],

    'table' => [
        'surat_latest' => 'Latest requests',
        'surat_latest_desc' => 'The most recent letter requests from all residents.',
        'pengaduan_latest' => 'Latest complaints',
        'pengaduan_latest_desc' => 'The most recent reports submitted to the portal.',
        'surat_queue' => 'Request queue',
        'surat_queue_desc' => 'Requests waiting to be processed.',
        'pengaduan_queue' => 'Complaint queue',
        'pengaduan_queue_desc' => 'Complaints that have not been resolved.',
        'surat_mine' => 'My requests',
        'surat_mine_desc' => 'Your letter request history.',
        'pengaduan_mine' => 'My complaints',
        'pengaduan_mine_desc' => 'Reports you have submitted.',
        'rows' => 'records',
    ],

    'fields' => [
        'ticket' => 'Ticket number',
        'applicant' => 'Applicant',
        'type' => 'Request type',
        'status' => 'Status',
        'date' => 'Date',
        'code' => 'Code',
        'title' => 'Title',
        'category' => 'Category',
        'reporter' => 'Reporter',
    ],

    'empty' => [
        'surat' => 'No letter requests yet',
        'pengaduan' => 'No complaints yet',
        'desc' => 'Data will appear here once a new request or report is submitted.',
    ],

    'status' => [
        'pending' => 'Pending',
        'diproses' => 'Processing',
        'proses' => 'In progress',
        'selesai' => 'Completed',
        'ditolak' => 'Rejected',
    ],
];
