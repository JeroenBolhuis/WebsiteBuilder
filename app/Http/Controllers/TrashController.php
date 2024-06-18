<?php

namespace App\Http\Controllers;

use App\Helpers\SoftDeletedHelper;

class TrashController extends Controller
{
    public function index()
    {
        $trashedModels = [];
        foreach (SoftDeletedHelper::getSoftDeletedControllers() as $controller) {
            $trashed = new $controller->modelPath();
            $trashedModels[$controller->modelName] = $trashed::onlyTrashed()->latest('deleted_at')->get();
        }

        return view('trash.index', compact('trashedModels'));
    }
}
