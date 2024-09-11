<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository and interface';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        // Generate paths for the interface and implementation.
        $interfacePath = app_path("Repositories/{$name}RepositoryInterface.php");
        $classPath = app_path("Repositories/{$name}Repository.php");

        // Create Repositories directory if it doesn't exist
        if (!File::exists(app_path('Repositories'))) {
            File::makeDirectory(app_path('Repositories'), 0755, true);
        }

        // Create interface file
        $interfaceStub = $this->getInterfaceStub($name);
        File::put($interfacePath, $interfaceStub);

        // Create repository file
        $repositoryStub = $this->getRepositoryStub($name);
        File::put($classPath, $repositoryStub);

        $this->info("Repository Interface [$interfacePath] created successfully.");
        $this->info("Repository [$classPath] created successfully.");
    }

    // Return the stub for the interface
    protected function getInterfaceStub($name)
    {
        return <<<EOT
<?php

namespace App\Repositories;

interface {$name}RepositoryInterface
{
    public function all();

    public function find(\$id);

    public function create(array \$data);

    public function update(\$id, array \$data);

    public function delete(\$id);
}
EOT;
    }

    // Return the stub for the repository
    protected function getRepositoryStub($name)
    {
        return <<<EOT
<?php

namespace App\Repositories;

use App\Models\\{$name};

class {$name}Repository implements {$name}RepositoryInterface
{
    public function all()
    {
        return {$name}::all();
    }

    public function find(\$id)
    {
        return {$name}::find(\$id);
    }

    public function create(array \$data)
    {
        return {$name}::create(\$data);
    }

    public function update(\$id, array \$data)
    {
        \$item = {$name}::find(\$id);
        return \$item ? \$item->update(\$data) : null;
    }

    public function delete(\$id)
    {
        \$item = {$name}::find(\$id);
        return \$item ? \$item->delete() : null;
    }
}
EOT;
    }
}
