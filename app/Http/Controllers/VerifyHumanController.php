<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyHumanController extends Controller
{
     /** Show the verification gate page */
    public function show()
    {
        // Already verified — go home
        if (session('human_verified') === true) {
            return redirect(session('intended_url', '/'));
        }

        return view('verify-human');
    }

    /** Handle Turnstile token submission */
    public function submit(Request $request)
    {
        $request->validate([
            'cf-turnstile-response' => 'required|string',
        ]);

        $response = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret'   => config('services.turnstile.secret_key'),
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if ($response->successful() && $response->json('success') === true) {
            // Mark verified in session
            session(['human_verified' => true]);

            $redirectTo = $request->input('redirect_to', '/');

            // Safety check — only redirect to same origin
            $safe = $this->isSameOrigin($redirectTo) ? $redirectTo : '/';

            return redirect($safe);
        }

        // Failed — back to gate with error
        return redirect()->route('verify.human')
            ->with('turnstile_error', 'Verification failed. Please try again.');
    }

    private function isSameOrigin(string $url): bool
    {
        $appHost = parse_url(config('app.url'), PHP_URL_HOST);
        $urlHost = parse_url($url, PHP_URL_HOST);

        // Allow relative URLs (no host)
        if ($urlHost === null) return true;

        return $appHost === $urlHost;
    }
}
