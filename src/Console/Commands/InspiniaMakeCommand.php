<?php

namespace Axterisko\Inspinia\Console\Commands;

use Illuminate\Console\Command;

class InspiniaMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:inspinia {--views : Only scaffold the views}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold basic make:auth with Inspinia Template';

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
        'errors/403.stub' => 'errors/403.blade.php',
        'errors/404.stub' => 'errors/404.blade.php',
        'errors/419.stub' => 'errors/419.blade.php',
        'layouts/app.stub' => 'layouts/app.blade.php',
        'layouts/sheet.stub' => 'layouts/sheet.blade.php',
        'home.stub' => 'home.blade.php',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->option('views')) {
            $this->info('Publish dependencies');
            $this->call('vendor:publish', ['--tag' => 'laravel-noty']);
            $this->call('vendor:publish', ['--tag' => 'datatables-buttons']);
            $this->info('Execute make:auth');
            $this->call('ui:auth', ['--force' => true, '--views' => $this->option('views')]);
        }
        $this->info('Start Inspinia scaffolding');
        $this->info('Copying views...');
        $this->createDirectories();
        foreach ($this->views as $key => $value) {
            copy(
                __DIR__ . '/stubs/make/views/' . $key,
                resource_path('views/' . $value)
            );
        }
        if (!$this->option('views')) {
            $this->info('Copying assets...');
            $this->xcopy(__DIR__ . '/../../../resources/js', resource_path('js'));
            $this->xcopy(__DIR__ . '/../../../resources/sass', resource_path('sass'));
            $this->info('Copying public...');
            $this->xcopy(__DIR__ . '/../../../public', public_path());

            file_put_contents(
                base_path('webpack.mix.js'),
                file_get_contents(__DIR__ . '/stubs/make/webpack.mix.stub'),
                FILE_APPEND
            );
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