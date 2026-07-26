<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public static function log(string $action, string $model, $modelId = null, $oldValues = null, $newValues = null, ?string $description = null): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'model' => $model,
            'model_id' => $modelId,
            'ip_address' => Request::ip(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }

    public static function created(string $model, $modelId = null, $newValues = null, ?string $description = null): void
    {
        self::log('created', $model, $modelId, null, $newValues, $description);
    }

    public static function updated(string $model, $modelId = null, $oldValues = null, $newValues = null, ?string $description = null): void
    {
        self::log('updated', $model, $modelId, $oldValues, $newValues, $description);
    }

    public static function deleted(string $model, $modelId = null, $oldValues = null, ?string $description = null): void
    {
        self::log('deleted', $model, $modelId, $oldValues, null, $description);
    }
}
