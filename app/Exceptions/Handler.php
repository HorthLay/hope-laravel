<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            try {
                $settingsFile = storage_path('app/settings.json');
                if (file_exists($settingsFile)) {
                    $settings = json_decode(file_get_contents($settingsFile), true);
                    $botToken = $settings['telegram_bot_token'] ?? null;
                    $chatId = $settings['telegram_chat_id'] ?? null;

                    if (!empty($botToken) && !empty($chatId)) {
                        $message = "🚨 *Application Error*\n";
                        $message .= "Environment: " . env('APP_ENV', 'production') . "\n";
                        $message .= "Message: `" . $e->getMessage() . "`\n";
                        $message .= "File: `" . $e->getFile() . "`\n";
                        $message .= "Line: " . $e->getLine() . "\n";

                        \Illuminate\Support\Facades\Http::timeout(5)->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                            'chat_id' => $chatId,
                            'text' => substr($message, 0, 4000), // Telegram max length is 4096
                            'parse_mode' => 'Markdown',
                        ]);
                    }
                }
            } catch (\Throwable $loggingException) {
                // Prevent infinite loop if logging itself fails
            }
        });
    }


    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }

        // Check which guard failed and redirect accordingly
        $guards = $exception->guards();
        if (in_array('sponsor', $guards)) {
            return redirect()->guest(route('sponsor.login'));
        }

        return redirect()->guest(route('login'));
    }


    
}
