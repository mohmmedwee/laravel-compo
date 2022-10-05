<?php


namespace Ostah\LaravelCompo\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Dirs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compo:dirs';

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
        $dirs = config('laravel-compo.dir');
        foreach ($dirs as $dir) {
            if (!$this->directoryExists($dir)) {
                $this->createDir($dir);
                $this->info('Created'.$dir.' Directories');
            } else {
                if ($this->shouldOverwriteConfig()) {
                    $this->info('Overwriting configuration file...');
                    $this->createDir($force = true);
                } else {
                    $this->info('Directories is already exists.');
                }
            }
        }

        $this->info('finished');
    }

    private function directoryExists($fileName)
    {
        return File::exists(app_path($fileName));
//        return File::ensureDirectoryExists(app_path($fileName);
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            ' Directories already exists. Do you want to overwrite it?',
            false
        );
    }

    private function createDir($fileName)
    {
        return File::makeDirectory(app_path($fileName),0755, true, true);
    }

}
