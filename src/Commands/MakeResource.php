<?php

namespace JoeCianflone\InertiaResource\Commands;


class MakeResource extends GeneratorCommand
{

    protected $signature = 'make:resource {name}';

    protected $description = 'Stub out an InertiaResource';

    public function __construct()
    {
        parent::__construct();
        $this->path = config('inertia-resource.path');
    }

    public function handle()
    {
        $stub = $this->replaceStubParts($this->getStub('Resource'), collect([
            "{{name}}" => $this->argument('name'),
        ]));

        $file = "/".$this->argument('name').".php";

        $this->toDisk($file, $stub);
        $this->info("Resource created");
    }
}
