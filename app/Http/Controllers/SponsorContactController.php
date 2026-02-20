<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
class SponsorContactController extends Controller
{
  public function show()
    {
        return view('sponsor.contact');
    }

    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'interest' => 'required|in:sponsor,donate',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|max:100',
            'message' => 'nullable|string|max:1000',
        ]);

        try {
            // Send email to admin
            $adminEmail = env('SPONSOR_CONTACT_EMAIL', 'meysoung@gmail.com');
            
            Mail::send([], [], function ($message) use ($validated, $adminEmail) {
                $interestLabel = $validated['interest'] === 'sponsor' 
                    ? 'Devenir Parrain' 
                    : 'Faire un Don';
                
                $body = "Nouvelle demande de contact : {$interestLabel}\n\n";
                $body .= "Nom : {$validated['name']}\n";
                $body .= "Email : {$validated['email']}\n";
                $body .= "Pays : {$validated['country']}\n\n";
                $body .= "Message :\n" . ($validated['message'] ?? 'Aucun message') . "\n";
                
                $message->to($adminEmail)
                    ->subject("Demande de Contact : {$interestLabel} - {$validated['name']}")
                    ->text($body);
            });

            // Log the submission
            Log::info('Sponsor contact form submitted', [
                'interest' => $validated['interest'],
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            return back()->with('contact_success', true);
            
        } catch (\Exception $e) {
            Log::error('Failed to send sponsor contact email', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            return back()
                ->withInput()
                ->withErrors(['email' => 'Une erreur est survenue. Veuillez réessayer ou nous contacter directement.']);
        }
    }
}
