<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class TurnstileRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(empty($value)){
            $fail('Please complete the human verification.');
            return;
        }


        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify',[
            'secret'   => config('services.turnstile.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

         if (! $response->successful() || ! $response->json('success')) {
            $fail('Human verification failed. Please try again.');
        }
    }
}
