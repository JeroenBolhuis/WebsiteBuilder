<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\Template;

class MakeTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:template {name} {input_names?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new template';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $input_names = $this->argument('input_names') ?? [];

        Artisan::call('make:component Templates/' . $name . '/Admin');
        Artisan::call('make:component Templates/' . $name . '/Page');

        $adminComponentPath = app_path('View/Components/Templates/' . $name . '/Admin.php');
        $adminComponentContent = file_get_contents($adminComponentPath);
        $adminComponentContent = str_replace(
            "/**\n     * Create a new component instance.\n     */",
            "public \$input_names = " . $this->exportArray($input_names) . ";\n\n    /**\n     * Create a new component instance.\n     */",
            $adminComponentContent
        );

        file_put_contents($adminComponentPath, $adminComponentContent);

        Template::create([
            'name' => $name,
            'description' => 'Description for ' . $name,
        ]);

        $this->info('Template created successfully.');
    }

    private function exportArray($array)
    {
        $result = "[\n";
        foreach ($array as $item) {
            $result .= "    '" . addcslashes($item, "'") . "',\n";
        }
        $result .= "]";
        return $result;
    }
}
