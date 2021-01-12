<?php
return [
    //md-skin | light-skin | skin-1
    //mini-navbar fixed-sidebar fixed-nav fixed-nav-basic boxed-layout
    'skin' => 'fixed-sidebar skin-1',
    //navbar-static-top | navbar-fixed-top
    'navbar-skin' => 'navbar-static-top',
    //fixed
    'footer-skin' => 'fixed',

    /**
     * Amount of days before a user's password must be changed
     */
    'password_life' => 90,  // Days

    /**
     * Force password change for users that have no history
     */
    'force_password_change' => true,

    'user' => version_compare(app()->version(), '8.0.0', '>=') ? '\App\Models\User' : '\App\User',

    'admin' => [
        'username' => 'admin',
        'email' => 'admin@example.it',
    ],
    'roles' => [],
    'permissions' => [
//        'permission' => ['role']
    ],
];
