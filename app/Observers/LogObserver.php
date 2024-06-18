<?php

namespace App\Observers;

use App\Models\Log;

class LogObserver
{
    public function created($model)
    {
        $this->logAction($model, 'created');
    }

    public function updated($model)
    {
        $this->logAction($model, 'updated');
    }

    public function deleted($model)
    {
        $this->logAction($model, 'deleted');
    }

    private function logAction($model, $action)
    {
        $user_id = auth()->id();

        $oldValues = json_encode($model->getOriginal());
        $newValues = json_encode($model->getAttributes());

        Log::create([
            'table_name' => $model->getTable(),
            'record_id' => $model->id,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'user_id' => $user_id,
        ]);
    }
    
    public static function logPivotAction($tableName, $rowId, $action, $oldValues = [], $newValues = [])
    {
        $user_id = auth()->id();

        Log::create([
            'table_name' => $tableName,
            'record_id' => $rowId,
            'action' => $action,
            'old_values' => json_encode($oldValues),
            'new_values' => json_encode($newValues),
            'user_id' => $user_id,
        ]);
    }
}
