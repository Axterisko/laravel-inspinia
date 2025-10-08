# Laravel Inspinia

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

Laravel package for integrating the **Inspinia Admin Theme** with Laravel. This package is Laravel Mix friendly and provides a complete scaffolding solution for building modern admin panels.

## Features

- 🎨 Complete Inspinia template integration
- 🔐 Pre-configured authentication views
- 🔑 Password expiration system
- 📊 DataTables integration with Yajra
- 🎛️ Dynamic menu system with Spatie Menu
- 👥 Role & Permission management with Spatie Permission
- 🍞 Breadcrumbs with Diglactic Laravel Breadcrumbs
- 🔔 Notifications with Laravel Noty
- 🌍 Multi-language support with Laravel JS Localization
- 🎯 Reusable Blade components (panels, tabs, forms)
- 📦 Laravel Mix ready assets

## Requirements

- PHP 7.4 or higher
- Laravel 6.x, 7.x, 8.x, 9.x, 10.x, 11.x, or 12.x

## Installation

### 1. Install via Composer

```bash
composer require axterisko/laravel-inspinia
```

### 2. Publish Configuration and Assets

Publish the configuration file:

```bash
php artisan vendor:publish --tag=laravel-inspinia-config
```

Publish all assets (config, views, translations):

```bash
php artisan vendor:publish --tag=laravel-inspinia
```

### 3. Scaffold Your Application

Run the scaffolding command to set up Inspinia in your project:

```bash
php artisan make:inspinia
```

This command will:
- Install authentication views
- Copy Inspinia views and layouts
- Set up controllers and models
- Copy assets (JS, SASS, images)
- Publish seeders for roles and permissions
- Configure webpack.mix.js

#### Scaffolding Options

```bash
# Only scaffold views
php artisan make:inspinia --views

# Only scaffold models
php artisan make:inspinia --models

# Only scaffold controllers
php artisan make:inspinia --controllers

# Only scaffold assets
php artisan make:inspinia --assets

# Skip specific parts
php artisan make:inspinia --no-webpack
php artisan make:inspinia --no-auth
php artisan make:inspinia --no-dependencies
php artisan make:inspinia --no-seeder
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Seed Database (Optional)

If you want to seed roles and permissions:

```bash
php artisan db:seed --class=InspiniaSeeder
```

### 6. Compile Assets

```bash
npm install && npm run dev
```

## Configuration

The configuration file is located at `config/inspinia.php`:

```php
return [
    // Theme skin: md-skin | light-skin | skin-1
    'skin' => '',

    // Navbar skin: navbar-static-top | navbar-fixed-top
    'navbar-skin' => 'navbar-static-top',

    // Footer skin: fixed
    'footer-skin' => 'fixed',

    // Password expiration (days)
    'password_life' => 90,

    // Force password change for users with no history
    'force_password_change' => true,

    // User model
    'user' => '\App\Models\User',

    // Default admin credentials
    'admin' => [
        'username' => 'admin',
        'email' => 'admin@example.it',
    ],

    // Roles configuration
    'roles' => [],

    // Permissions configuration
    'permissions' => [
        // 'permission' => ['role']
    ],
];
```

## Usage

### Layouts

The package provides three main layouts:

#### Main Layout (`layouts.app`)

```blade
@extends('inspinia::layouts.main')

@section('content')
    <!-- Your content here -->
@endsection
```

#### Sheet Layout (`layouts.sheet`)

For printing or simplified views:

```blade
@extends('inspinia::layouts.sheet')

@section('content')
    <!-- Your content here -->
@endsection
```

#### Auth Layout (`layouts.auth`)

For authentication pages (login, register, etc.):

```blade
@extends('inspinia::layouts.auth')

@section('content')
    <!-- Your auth form here -->
@endsection
```

### Components

#### Panel Component

```blade
<x-inspinia::panel title="My Panel" subtitle="Panel subtitle">
    <p>Panel content</p>
</x-inspinia::panel>
```

#### Tabs Component

```blade
<x-inspinia::tabs :tabs="['Tab 1', 'Tab 2', 'Tab 3']">
    <x-slot name="tab1">Content for tab 1</x-slot>
    <x-slot name="tab2">Content for tab 2</x-slot>
    <x-slot name="tab3">Content for tab 3</x-slot>
</x-inspinia::tabs>
```

#### Form Fields

```blade
{{-- Input field --}}
<x-inspinia::fields.input
    name="email"
    label="Email Address"
    :value="old('email')"
    required
/>

{{-- Textarea --}}
<x-inspinia::fields.textarea
    name="description"
    label="Description"
    rows="5"
/>

{{-- Select --}}
<x-inspinia::fields.select
    name="status"
    label="Status"
    :options="['active' => 'Active', 'inactive' => 'Inactive']"
/>

{{-- Select2 --}}
<x-inspinia::fields.select2
    name="category_id"
    label="Category"
    :options="$categories"
/>

{{-- Datepicker --}}
<x-inspinia::fields.datepicker
    name="date"
    label="Date"
/>

{{-- Clockpicker --}}
<x-inspinia::fields.clockpicker
    name="time"
    label="Time"
/>

{{-- Button --}}
<x-inspinia::fields.button
    type="submit"
    label="Save"
    color="primary"
/>
```

### Password Expiration

The package includes a password expiration system:

#### Middleware

Add the middleware to your routes:

```php
Route::middleware(['auth', 'password.not-expired'])->group(function () {
    // Protected routes
});
```

#### Traits

Add the traits to your User model:

```php
use Axterisko\Inspinia\Traits\PasswordExpire;
use Axterisko\Inspinia\Traits\RenewPassword;

class User extends Authenticatable
{
    use PasswordExpire, RenewPassword;

    // ...
}
```

The `PasswordExpire` trait provides:
- `passwordExpired()` - Check if password is expired
- `passwordExpiresAt()` - Get password expiration date

### Menu System

The package uses Spatie Menu for dynamic menus. Configure your menu in your service provider or controller:

```php
use Spatie\Menu\Laravel\Menu;

Menu::macro('main', function () {
    return Menu::new()
        ->addClass('nav navbar-nav')
        ->link(route('dashboard'), 'Dashboard')
        ->link(route('users.index'), 'Users')
        ->link(route('settings.index'), 'Settings');
});
```

### Roles & Permissions

The package integrates Spatie Permission. Configure roles and permissions in `config/inspinia.php`:

```php
'roles' => ['admin', 'editor', 'user'],

'permissions' => [
    'view-users' => ['admin', 'editor'],
    'edit-users' => ['admin'],
    'delete-users' => ['admin'],
],
```

Then seed them:

```bash
php artisan db:seed --class=InspiniaSeeder
```

## Customization

### Publish Views

To customize views, publish them to your application:

```bash
php artisan vendor:publish --tag=laravel-inspinia
```

Views will be published to `resources/views/vendor/inspinia`.

### Publish Translations

Translations are published automatically with the above command to `resources/lang/vendor/inspinia`.

### Skins

Available skins (set in `config/inspinia.php`):

- `md-skin` - Material Design skin
- `light-skin` - Light skin
- `skin-1` - Alternative skin

Additional body classes:
- `mini-navbar` - Minimized sidebar
- `fixed-sidebar` - Fixed sidebar
- `fixed-nav` - Fixed navigation
- `fixed-nav-basic` - Basic fixed navigation
- `boxed-layout` - Boxed layout

## Included Dependencies

This package includes and configures:

- [Laravel UI](https://github.com/laravel/ui) - Authentication scaffolding
- [Yajra DataTables](https://github.com/yajra/laravel-datatables) - Server-side DataTables
- [Spatie Laravel Permission](https://github.com/spatie/laravel-permission) - Role and permission management
- [Spatie Laravel Menu](https://github.com/spatie/laravel-menu) - Menu builder
- [Diglactic Laravel Breadcrumbs](https://github.com/diglactic/laravel-breadcrumbs) - Breadcrumbs
- [Laravel Noty](https://github.com/rsmalc/laravel-noty) - Notification system
- [Laravel JS Localization](https://github.com/mariuzzo/laravel-js-localization) - Use Laravel translations in JavaScript

## Change Log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details.

## Security

If you discover any security related issues, please email alex.pettiti@axterisko.it instead of using the issue tracker.

## Credits

- [Alex Pettiti](https://github.com/axterisko)
- [All Contributors][link-contributors]

## License

MIT License. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/axterisko/laravel-inspinia.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/axterisko/laravel-inspinia.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/axterisko/laravel-inspinia
[link-downloads]: https://packagist.org/packages/axterisko/laravel-inspinia
[link-contributors]: ../../contributors
