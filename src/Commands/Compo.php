<?php


namespace Ostah\LaravelCompo\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Compo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comp:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Compo Package';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Installing Compo Package...');
        $this->info('Publishing configuration...');

        if (! $this->configExists('laravel-compo.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }

        $this->info('Installed Compo Package');
    }
    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "Ostah\LaravelCompo\LaravelCompoServiceProvider",
            '--tag' => "config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }

}
