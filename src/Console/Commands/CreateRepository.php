<?php

namespace Rez1pro\RepositoryPattern\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class CreateRepository extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {name : The name of the repository (e.g., User, Order/OrderItem)} {interface : a corresponding interface}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository.';

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'Which Repository name should be created?',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $createInterface = $this->argument('interface');

        $this->info("Creating Repository: $name");

        // Extract class name from the full path
        $pathParts = explode('/', $name);
        $className = end($pathParts);

        // Calculate namespace based on folder structure
        $namespaceParts = array_slice($pathParts, 0, -1);
        $namespace = 'App\\Repositories';
        if (!empty($namespaceParts)) {
            $namespace .= '\\' . implode('\\', $namespaceParts);
        }

        $stub = file_get_contents(__DIR__ . '/../../../stubs/RepositoryStub.stub');

        $stub = str_replace('{{ class }}', $className, $stub);
        $stub = str_replace('{{ namespace }}', $namespace, $stub);
        $stub = str_replace('{{ interface }}', $createInterface, $stub);

        // Construct the full file path with proper nested structure
        $filePath = app_path("Repositories/{$name}Repository.php");

        if (file_exists($filePath)) {
            $this->error("Repository {$className} already exists!");
            return;
        }

        // create directory if not exists
        if (!file_exists(app_path('Repositories'))) {
            mkdir(app_path('Repositories'), 0755, true);
        }

        // Create nested folders if needed
        $directoryPath = dirname($filePath);
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
            $this->info("Created directory: " . str_replace(app_path(), 'app', $directoryPath));
        }

        // create file and write stub content
        file_put_contents($filePath, $stub);
        $this->info("Repository {$className} created successfully at: " . str_replace(app_path(), 'app', $filePath));

        // If interface creation is requested
        if ($createInterface) {
            $this->call('make:interface', ['name' => $className]);
        }
    }
}
