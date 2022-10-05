<?php


namespace Ostah\LaravelCompo\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Dto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compo:dto {class}';

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
        $this->info('Creating DTo...');


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
