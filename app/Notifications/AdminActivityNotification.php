<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminActivityNotification extends Notification
{
    use Queueable;

    public $modelType;
    public $action;
    public $modelName;
    public $modelId;

    public function __construct(string $modelType, string $action, string $modelName, ?int $modelId = null)
    {
        $this->modelType = $modelType;
        $this->action = $action;
        $this->modelName = $modelName;
        $this->modelId = $modelId;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'model_type' => $this->modelType,
            'action'     => $this->action,
            'model_name' => $this->modelName,
            'model_id'   => $this->modelId,
            'message'    => "{$this->modelType} '{$this->modelName}' was {$this->action}.",
        ];
    }
}
