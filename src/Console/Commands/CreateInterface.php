<?php

namespace Rez1pro\RepositoryPattern\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

use function Laravel\Prompts\search;


class CreateInterface extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Interface';


    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'Which interface name should be created?',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->info("Creating interface: $name");

        // Extract class name from the full path
        $pathParts = explode('/', $name);
        $className = end($pathParts);

        // Calculate namespace based on folder structure
        $namespaceParts = array_slice($pathParts, 0, -1);
        $namespace = 'App\\Interfaces';
        if (!empty($namespaceParts)) {
            $namespace .= '\\' . implode('\\', $namespaceParts);
        }

        $stub = file_get_contents(base_path('RepositoryPattern/stubs/InterfaceStub.stub'));
        $stub = str_replace('{{ class }}', $className, $stub);
        $stub = str_replace('{{ namespace }}', $namespace, $stub);

        // Construct the full file path with proper nested structure
        $filePath = app_path("Interfaces/{$name}Interface.php");

        if (file_exists($filePath)) {
            $this->error("Interface {$className} already exists!");
            return;
        }

        // create directory if not exists
        if (!file_exists(app_path('Interfaces'))) {
            mkdir(app_path('Interfaces'), 0755, true);
        }

        // Create nested folders if needed
        $directoryPath = dirname($filePath);
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
            $this->info("Created directory: " . str_replace(app_path(), 'app', $directoryPath));
        }

        // create file and write stub content
        file_put_contents($filePath, $stub);
        $this->info("Interface {$className} created successfully at: " . str_replace(app_path(), 'app', $filePath));
    }
}
