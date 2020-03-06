<?php

namespace JoeCianflone\InertiaResource\Commands;

use JoeCianflone\InertiaResource\Commands\GeneratorCommand;


class MakeResource extends GeneratorCommand
{

    protected $signature = 'make:inertia-resource 
                                {name : What you\'d like to name the resource file}
                                {path? : Path is configured in inertia-resource config file, but if you wan to override it you need to provide the full path}';
                                    

    protected $description = 'Stub out an InertiaResource';

    public function __construct()
    {
        parent::__construct();
        $this->path = $this->argument('path') ?: config('inertia-resource.path');
    }

    public function handle()
    {
        $stub = $this->replaceStubParts($this->getStub('Resource'), collect([
            "{{name}}" => $this->argument('name'),
        ]));

        $file = "/";
        $file .= config('inertia-resource.name_prefix');
        $file .= $this->argument('name');
        $file .= config('inertia-resource.name_suffix');
        $file .= ".php";
                     
        $this->toDisk($file, $stub);
        $this->info("Inertia resource file created");
    }
}
