<?php

namespace App\Observers;

use App\Models\Admin;
use App\Notifications\AdminActivityNotification;
use Illuminate\Support\Facades\Notification;

class AdminActivityObserver
{
    public function created($model): void
    {
        $this->notifyAdmins('created', $model);
    }

    public function updated($model): void
    {
        // Ignore silent background updates if needed, e.g. last_login_at
        if ($model->isDirty('last_login_at') && count($model->getChanges()) === 1) {
            return;
        }

        $this->notifyAdmins('updated', $model);
    }

    public function deleted($model): void
    {
        $this->notifyAdmins('deleted', $model);
    }

    private function notifyAdmins(string $action, $model): void
    {
        $modelType = class_basename($model);
        
        // Resolve the best identifying name for the model
        $modelName = $model->name 
            ?? $model->title 
            ?? $model->full_name 
            ?? $model->first_name 
            ?? "ID: {$model->id}";

        $admins = Admin::where('is_active', true)->get();
        Notification::send($admins, new AdminActivityNotification($modelType, $action, $modelName, $model->id));
    }
}
