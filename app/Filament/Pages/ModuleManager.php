<?php
// app/Filament/Pages/ModuleManager.php
namespace App\Filament\Pages;

use App\Models\Module;
use App\Services\ModuleService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\File;

class ModuleManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';
    protected static ?string $navigationGroup = 'System';
    protected static string $view = 'filament.pages.module-manager';
    protected static ?int $navigationSort = 98;

    public $modules = [];
    public $availableModules = [];

    public function mount(): void
    {
        $this->loadModules();
    }

    protected function loadModules(): void
    {
        $this->modules = Module::orderBy('sort_order')->get()->toArray();
        $this->availableModules = $this->getAvailableModules();
    }

    protected function getAvailableModules(): array
    {
        $modulesPath = base_path('Modules');
        
        if (!File::exists($modulesPath)) {
            return [];
        }

        $directories = File::directories($modulesPath);
        $available = [];

        foreach ($directories as $directory) {
            $name = basename($directory);
            $installed = Module::where('slug', strtolower($name))->exists();

            if (!$installed) {
                $available[] = [
                    'name' => $name,
                    'path' => $directory,
                    'version' => $this->getModuleVersion($name),
                ];
            }
        }

        return $available;
    }

    protected function getModuleVersion($name): string
    {
        $composerPath = base_path("Modules/$name/composer.json");
        
        if (File::exists($composerPath)) {
            $composer = json_decode(File::get($composerPath), true);
            return $composer['version'] ?? '1.0.0';
        }

        return '1.0.0';
    }

    public function toggleModule($moduleId): void
    {
        $module = Module::find($moduleId);
        
        if (!$module) {
            Notification::make()
                ->title('Module not found')
                ->danger()
                ->send();
            return;
        }

        if ($module->is_core) {
            Notification::make()
                ->title('Cannot disable core module')
                ->warning()
                ->send();
            return;
        }

        $moduleService = app(ModuleService::class);

        try {
            if ($module->is_active) {
                $moduleService->deactivate($module->name);
                $message = 'Module deactivated successfully';
            } else {
                $moduleService->activate($module->name);
                $message = 'Module activated successfully';
            }

            Notification::make()
                ->title($message)
                ->success()
                ->send();

            $this->loadModules();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function installModule($moduleName): void
    {
        $moduleService = app(ModuleService::class);

        try {
            $moduleService->install($moduleName);

            Notification::make()
                ->title('Module installed successfully')
                ->success()
                ->send();

            $this->loadModules();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function uninstallModule($moduleId): void
    {
        $module = Module::find($moduleId);
        
        if (!$module) {
            Notification::make()
                ->title('Module not found')
                ->danger()
                ->send();
            return;
        }

        if ($module->is_core) {
            Notification::make()
                ->title('Cannot uninstall core module')
                ->warning()
                ->send();
            return;
        }

        $moduleService = app(ModuleService::class);

        try {
            $moduleService->uninstall($module->name);

            Notification::make()
                ->title('Module uninstalled successfully')
                ->success()
                ->send();

            $this->loadModules();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}