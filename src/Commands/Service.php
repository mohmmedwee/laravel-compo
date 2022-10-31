<?php


namespace Ostah\LaravelCompo\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Service extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compo:service {controller : Create services based on controller actions}
     {--name : service class name}  ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To create a service class per each action';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info('Creating Directories Based Directory On laravel-compo configuration...');
        $input = $this->argument('controller');

        $functions = $this->removeParentClassFunction($input);
        $className = $this->getClassName($input);

        foreach ($functions as  $function){
           $serviceName=$this->getServiceName($function,$className);
           $this->createFile($serviceName);
        }

        $this->info('finished');
    }


    private function directoryExists($fileName)
    {
        return File::exists(app_path($fileName));
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            ' Directories already exists. Do you want to overwrite it?',
            false
        );
    }

    private function removeParentClassFunction($class) : array{

        $parentClassFunctios = get_class_methods(get_parent_class($class)) ?? [];
        $classFunctions = get_class_methods($class);
        $functionsName = array_diff(array_unique(array_merge($parentClassFunctios,$classFunctions)),$parentClassFunctios);
        return $functionsName;
    }

    private function getClassName($class) : string{
        $class= class_basename($class);
        return strstr($class, 'Controller', true);
    }

    private function getServiceName($action,$class) : string{
        return ''.$action.$class.'Service';
    }
    
    private function createFile($fileName){
       return File::put(app_path('Services').'/'.$fileName.'.php',"This is simple content");
    }


}
