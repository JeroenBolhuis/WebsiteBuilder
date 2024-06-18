<?php

namespace App\Helpers;

class SoftDeletedHelper
{
    public static function getSoftDeletedControllers()
    {
        $controllers = array_map(function ($file) {
            return basename($file, '.php');
        }, glob(app_path('Http/Controllers/*.php')));

        $softDeletes = array_filter($controllers, function ($controller) {
            $class = 'App\Http\Controllers\\' . $controller;
            return is_subclass_of($class, 'App\Http\Controllers\SoftDeletesController');
        });

        $objects = collect([]);
        foreach ($softDeletes as $controller) {
            $controllerPath = 'App\Http\Controllers\\' . $controller;
            $class = new $controllerPath();
            $controllerName = strtolower(substr($controller, 0, -10));

            $objects->push((object) [
                'class' => $class,
                'path' => $controllerPath,
                'name' => $controllerName,
                'modelPath' => $class->model,
                'modelName' => class_basename($class->model),
            ]);
        }
        return $objects;
    }

    public static function hasPermission(): bool
    {
        /** @var User $user */
        $user = auth()->user();

        $permissions = $user->getAllPermissions()->map(function ($permission) {
            return $permission->name;
        });

        foreach (SoftDeletedHelper::getSoftDeletedControllers() as $controller) {
            if ($permissions->contains('edit ' . strtolower($controller->modelName))) {
                return true;
            }
        }

        return false;
    }
}
