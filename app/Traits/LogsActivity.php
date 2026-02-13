<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            static::logActivity('create', $model);
        });

        static::updated(function ($model) {
            static::logActivity('update', $model);
        });

        static::deleted(function ($model) {
            static::logActivity('delete', $model);
        });
    }

    protected static function logActivity($action, $model)
    {
        if (!auth()->check()) {
            return;
        }

        $oldValues = $action === 'update' ? $model->getOriginal() : null;
        $newValues = $action !== 'delete' ? $model->getAttributes() : null;

        // Remove sensitive data
        if ($oldValues && isset($oldValues['password'])) {
            unset($oldValues['password']);
        }
        if ($newValues && isset($newValues['password'])) {
            unset($newValues['password']);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model' => get_class($model),
            'model_id' => $model->id,
            'description' => static::getActivityDescription($action, $model),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'url' => Request::fullUrl(),
            'method' => Request::method()
        ]);
    }

    protected static function getActivityDescription($action, $model)
    {
        $modelName = class_basename($model);
        $userName = auth()->user()->name ?? 'System';
        
        return match($action) {
            'create' => "{$userName} created a new {$modelName} with ID: {$model->id}",
            'update' => "{$userName} updated {$modelName} with ID: {$model->id}",
            'delete' => "{$userName} deleted {$modelName} with ID: {$model->id}",
            default => "{$userName} performed {$action} on {$modelName} with ID: {$model->id}"
        };
    }
}