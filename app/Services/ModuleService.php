<?php
// app/Services/ModuleService.php
namespace App\Services;

use App\Models\Module;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class ModuleService
{
    public function install($moduleName)
    {
        $modulePath = base_path("Modules/$moduleName");
        
        if (!File::exists($modulePath)) {
            throw new \Exception("Module $moduleName not found");
        }

        // Run migrations
        $migrationsPath = "$modulePath/Database/Migrations";
        if (File::exists($migrationsPath)) {
            Artisan::call('migrate', [
                '--path' => "Modules/$moduleName/Database/Migrations"
            ]);
        }

        // Publish assets
        $this->publishAssets($moduleName);

        // Create/update module record
        return Module::updateOrCreate(
            ['slug' => strtolower($moduleName)],
            [
                'name' => $moduleName,
                'is_active' => true,
                'version' => $this->getModuleVersion($moduleName),
            ]
        );
    }

    public function uninstall($moduleName)
    {
        $module = Module::where('slug', strtolower($moduleName))->first();
        
        if (!$module) {
            throw new \Exception("Module $moduleName not installed");
        }

        if ($module->is_core) {
            throw new \Exception("Cannot uninstall core module");
        }

        // Rollback migrations
        $this->rollbackMigrations($moduleName);

        $module->delete();

        return true;
    }

    public function activate($moduleName)
    {
        $module = Module::where('slug', strtolower($moduleName))->first();
        
        if (!$module) {
            throw new \Exception("Module $moduleName not found");
        }

        // Check dependencies
        $this->checkDependencies($module);

        $module->update(['is_active' => true]);

        return $module;
    }

    public function deactivate($moduleName)
    {
        $module = Module::where('slug', strtolower($moduleName))->first();
        
        if (!$module) {
            throw new \Exception("Module $moduleName not found");
        }

        if ($module->is_core) {
            throw new \Exception("Cannot deactivate core module");
        }

        $module->update(['is_active' => false]);

        return $module;
    }

    protected function checkDependencies($module)
    {
        if (!$module->dependencies) {
            return true;
        }

        foreach ($module->dependencies as $dependency) {
            $dependencyModule = Module::where('slug', $dependency)
                ->where('is_active', true)
                ->first();

            if (!$dependencyModule) {
                throw new \Exception("Required dependency $dependency is not active");
            }
        }

        return true;
    }

    protected function publishAssets($moduleName)
    {
        $assetsPath = base_path("Modules/$moduleName/Resources/assets");
        $publicPath = public_path("modules/$moduleName");

        if (File::exists($assetsPath)) {
            File::copyDirectory($assetsPath, $publicPath);
        }
    }

    protected function getModuleVersion($moduleName)
    {
        $composerPath = base_path("Modules/$moduleName/composer.json");
        
        if (File::exists($composerPath)) {
            $composer = json_decode(File::get($composerPath), true);
            return $composer['version'] ?? '1.0.0';
        }

        return '1.0.0';
    }

    protected function rollbackMigrations($moduleName)
    {
        // Implementation depends on your migration strategy
        // This is a simplified version
    }
}