<?php

namespace Axterisko\Inspinia\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;

class InspiniaMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:inspinia {--views : Only scaffold the views} {--models : Only scaffold the models} {--controllers : Only scaffold the controllers} {--assets : Only scaffold the assets} {--no-webpack : Bypass webpack scaffold}  {--no-auth : Bypass auth scaffold} {--no-dependencies : Bypass dependencies scaffold} {--no-seeder : Bypass seeder scaffold}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold with Inspinia Template';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'auth/login.stub' => 'auth/login.blade.php',
        'auth/register.stub' => 'auth/register.blade.php',
        'auth/verify.stub' => 'auth/verify.blade.php',
        'auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
        'auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
        'auth/passwords/confirm.stub' => 'auth/passwords/confirm.blade.php',
        'auth/passwords/renew.stub' => 'auth/passwords/renew.blade.php',
        'errors/403.stub' => 'errors/403.blade.php',
        'errors/404.stub' => 'errors/404.blade.php',
        'errors/419.stub' => 'errors/419.blade.php',
        'layouts/app.stub' => 'layouts/app.blade.php',
        'layouts/sheet.stub' => 'layouts/sheet.blade.php',
        'home.stub' => 'home.blade.php',
    ];


    /**
     * The controllers that need to be exported.
     *
     * @var array
     */
    protected $controllers = [
        'LoginController.stub' => 'Http/Controllers/Auth/LoginController.php',
        'RenewPasswordController.stub' => 'Http/Controllers/Auth/RenewPasswordController.php',
    ];

    /**
     * The models that need to be exported.
     *
     * @var array
     */
    protected $models = [
        'User.stub' => 'User.php'
    ];

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start Inspinia scaffolding');

        if ($this->option('assets')) {
            $this->info('Copying assets...');
            $this->xcopy(__DIR__ . '/../../../resources/js', resource_path('js'));
            $this->xcopy(__DIR__ . '/../../../resources/sass', resource_path('sass'));
            $this->info('Copying public...');
            $this->xcopy(__DIR__ . '/../../../public', public_path());

        } else {

            if (!$this->option('views') && !$this->option('models') && !$this->option('controllers')) {
                if (!$this->option('no-dependencies')) {
                    $this->info('Publish dependencies');
                    $this->call('vendor:publish', ['--tag' => 'laravel-noty']);
                    $this->call('vendor:publish', ['--tag' => 'datatables-buttons']);
                    $this->call('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider']);
                }
                if (!$this->option('no-auth')) {
                    $this->info('Execute make:auth');
                    $this->call('ui:auth', ['--force' => true, '--views' => $this->option('views')]);
                }
            }
            if (!$this->option('models') && !$this->option('controllers')) {
                $this->info('Copying views...');
                $this->createDirectories();
                foreach ($this->views as $key => $value) {
                    copy(
                        __DIR__ . '/stubs/make/views/' . $key,
                        resource_path('views/' . $value)
                    );
                }
            }

            if (!$this->option('models') && !$this->option('views')) {
                $this->info('Copying controllers...');

                foreach ($this->controllers as $key => $value) {
                    copy(
                        __DIR__ . '/stubs/make/controllers/' . $key,
                        app_path($value)
                    );
                }
            }

            if (!$this->option('controllers') && !$this->option('views')) {
                $this->info('Copying models...');

                foreach ($this->models as $key => $value) {
                    copy(
                        __DIR__ . '/stubs/make/models/' . $key,
                        app_path($value)
                    );
                }
            }

            if (!$this->option('views') && !$this->option('models') && !$this->option('controllers')) {
                $this->info('Copying assets...');
                $this->xcopy(__DIR__ . '/../../../resources/js', resource_path('js'));
                $this->xcopy(__DIR__ . '/../../../resources/sass', resource_path('sass'));
                $this->info('Copying public...');
                $this->xcopy(__DIR__ . '/../../../public', public_path());
                if (!$this->option('no-seeder')) {
                    $this->info('Copying seeder...');
                    $this->xcopy(__DIR__ . '/../../../database/seeds', database_path('seeds'));
                    $this->info('Dump autoload...');
                    $this->composer->dumpAutoloads();
                }

                if (!$this->option('no-webpack')) {

                    file_put_contents(
                        base_path('webpack.mix.js'),
                        file_get_contents(__DIR__ . '/stubs/make/webpack.mix.stub'),
                        FILE_APPEND
                    );

                    file_put_contents(
                        base_path('package.json'),
                        file_get_contents(__DIR__ . '/stubs/make/package.stub')
                    );
                }
            }
        }
        $this->info('Inspinia scaffolding generated successfully.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        if (!is_dir(resource_path('views/errors'))) {
            mkdir(resource_path('views/errors'), 0755, true);
        }
    }

    /**
     * Copy a file, or recursively copy a folder and its contents
     * @param string $source Source path
     * @param string $dest Destination path
     * @param int $permissions New folder creation permissions
     * @return      bool     Returns true on success, false on failure
     * @version     1.0.1
     * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
     * @author      Aidan Lister <aidan@php.net>
     */
    private function xcopy($source, $dest, $permissions = 0755)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }
        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }
        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }
        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            // Deep copy directories
            $this->xcopy("$source/$entry", "$dest/$entry", $permissions);
        }
        // Clean up
        $dir->close();
        return true;
    }
}
