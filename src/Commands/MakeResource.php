<?php

namespace JoeCianflone\InertiaResource\Commands;

use Illuminate\Support\Str;
use JoeCianflone\InertiaResource\Commands\GeneratorCommand;


class MakeResource extends GeneratorCommand
{

    protected $signature = 'make:inertia-resource
                                {name : What you\'d like to name the resource file}
                                {pathing? : Path is configured in inertia-resource config file, but if you wan to override it you need to provide the full path}';


    protected $description = 'Stub out an InertiaResource';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->path = $this->argument('pathing') ?? config('inertia-resource.path');

        $name = config('inertia-resource.name_prefix');
        $name .= $this->argument('name');
        $name .= config('inertia-resource.name_suffix');

        $stub = $this->replaceStubParts($this->getStub('Resource'), collect([
            "{{namespace}}" => Str::ucfirst(Str::replaceFirst("\\", "", str_replace("/", "\\", $this->path))) . "\\" . $name,
            "{{name}}" => $name,
        ]));

        $this->toDisk("/{$name}.php", $stub);
        $this->info("Inertia resource file created");
    }
}
