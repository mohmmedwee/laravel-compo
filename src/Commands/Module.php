<?php


namespace Ostah\LaravelCompo\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Module extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compo:module
                { name : Module name} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To create A default Directories';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating Directories Based Directory On laravel-compo configuration...');
        $dirs = config('laravel-compo.module');

        if (!$this->directoryModuleExists('Modules',)) {
            $this->createModuleDir('Modules');
            $this->info('Created Modules Directories');
        }

        $name = $this->argument('name');
        foreach ($dirs as $dir) {
            if (!$this->directoryExists($dir, $name)) {
                $this->createDir($dir, $name);
                $this->info('Created' . $dir . ' Directories');
            } else {
                if ($this->shouldOverwriteConfig()) {
                    $this->info('Overwriting Directories ');
                    $this->createDir($dir, $this->argument('name'));
                } else {
                    $this->info('Directories is already exists.');
                }
            }

//            switch($dir) {
//                case 'Models':
//                case 'Controllers':
//
//            }


        }
        $this->makeModel($this->argument('name'));
        $this->makeContoller($this->argument('name'));

        $this->info('finished');
    }

    private function directoryExists($fileName, $name)
    {
        return File::exists(app_path('Modules/' . $name . '/' . $fileName));
//        return File::ensureDirectoryExists(app_path($fileName);
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            ' Directories already exists. Do you want to overwrite it?',
            false
        );
    }

    private function createDir($fileName, $name)
    {
        return File::makeDirectory(app_path('Modules/' . $name . '/' . $fileName), 0755, true, true);
    }

    private function createModuleDir($fileName)
    {
        return File::makeDirectory(app_path($fileName), 0755, true, true);
    }

    private function directoryModuleExists($fileName)
    {
        return File::exists(app_path('Modules/' . $fileName));
//        return File::ensureDirectoryExists(app_path($fileName);
    }


    private function makeModel($name)
    {
        //todo: make model
        $this->call('make:model', [
            'name' => '/App/' . 'Modules/' . $name . '/Models/' . $name,
            '--controller'=>'/App/' . 'Modules/' . $name . '/Controllers/' . $name.'Controller',
            '--migration'
        ]);
    }


    private function makeContoller($name)
    {
//        $this->call('make:controller', [
//            'name' => '/App/' . 'Modules/' . $name . '/Controllers/' . $name,
//            '--resource', '--model' => '/App/' . 'Modules/' . $name . '/Models/' . $name,
//        ]);
    }


}
