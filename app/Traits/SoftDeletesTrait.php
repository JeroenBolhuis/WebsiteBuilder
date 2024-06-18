<?php

namespace App\Traits;

trait SoftDeletesTrait
{
    public function restore($id)
    {
        $model = $this->model::withTrashed()->find($id);
        if ($model) {
            $model->restore();
        }

        return redirect()->route('trash.index');
    }

    public function destroyPermanently($id)
    {
        $model = $this->model::withTrashed()->find($id);
        if ($model) {
            $model->forceDelete();
        }

        return redirect()->route('trash.index')->with('success', 'Je hebt de gegevens permanent verwijderd!');
    }
}
