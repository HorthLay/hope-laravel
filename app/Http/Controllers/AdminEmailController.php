<?php

namespace App\Http\Controllers;

use App\Mail\SponsorPasswordReset;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Mail;
use SponsorAccountCreated;

class AdminEmailController extends Controller
{
       /**
     * Email management page.
     */
    public function index()
    {
        return view('admin.emails.index');
    }
 
    /**
     * Live preview — renders the email HTML for the iframe.
     * Accepts both POST (JSON from fetch) and GET (for full-screen open).
     */
    public function preview(Request $request)
    {
        $type     = $request->input('type', 'created');
        $lang     = in_array($request->input('lang'), ['fr','en','km']) ? $request->input('lang') : 'fr';
        $settings = $this->settings();
 
        /* Logo: JS sends the full asset() URL already resolved.
           Fall back to settings path via asset() if not provided. */
        $logoUrl  = $request->input('logo')
            ?: (!empty($settings['logo']) ? asset($settings['logo']) : null);
        $siteName = $request->input('site_name')
            ?: ($settings['site_name'] ?? 'Des Ailes pour Grandir');
 
        $shared = [
            'siteName' => $siteName,
            'siteLogo' => $logoUrl,   // full URL, used directly in <img src>
            'loginUrl' => route('sponsor.login'),
            'lang'     => $lang,
        ];
 
        $fullName = trim($request->input('first_name','Jean') . ' ' . $request->input('last_name','Dupont'));
 
        if ($type === 'reset') {
            $html = view('emails.sponsor.password_reset', array_merge($shared, [
                'sponsor'     => $fullName,
                'email'       => $request->input('email',    'jean@example.com'),
                'username'    => $request->input('username', 'jean.dupont'),
                'newPassword' => $request->input('password', 'New@Pass456'),
                'contactEmail'=> $settings['contact_email'] ?? null,
            ]))->render();
        } else {
            $html = view('emails.sponsor.account_created', array_merge($shared, [
                'sponsor'  => $fullName,
                'email'    => $request->input('email',    'jean@example.com'),
                'username' => $request->input('username', 'jean.dupont'),
                'password' => $request->input('password', 'Temp@Pass123'),
            ]))->render();
        }
 
        return response($html)->header('Content-Type', 'text/html');
    }
 
    /**
     * Send email — called via fetch() from the JS form.
     */
    public function send(Request $request)
    {
        $request->validate([
            'type'       => 'required|in:created,reset',
            'lang'       => 'nullable|in:fr,en,km',
            'first_name' => 'required|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'name'       => 'nullable|string|max:255',
            'email'      => 'required|email',
            'username'   => 'nullable|string|max:255',
            'password'   => 'required|string|min:6',
        ]);
 
        $fullName = trim($request->first_name . ' ' . $request->last_name);
        $lang     = in_array($request->lang, ['fr','en','km']) ? $request->lang : 'fr';
        $settings = $this->settings();
        $loginUrl = route('sponsor.login');
 
        try {
            if ($request->type === 'reset') {
                $sponsor = Sponsor::where('email', $request->email)->first();
                if ($sponsor) {
                    $sponsor->update(['password' => bcrypt($request->password)]);
                }
                Mail::to($request->email)->send(new SponsorPasswordReset(
                    sponsor:     $fullName,
                    email:       $request->email,
                    username:    $request->username ?? '',
                    newPassword: $request->password,
                    loginUrl:    $loginUrl,
                    lang:        $lang,
                ));
            } else {
                Mail::to($request->email)->send(new SponsorAccountCreated(
                    sponsor:  $fullName,
                    email:    $request->email,
                    username: $request->username ?? '',
                    password: $request->password,
                    loginUrl: $loginUrl,
                    lang:     $lang,
                ));
            }
 
            return response()->json(['success' => true, 'message' => 'Email sent to ' . $request->email]);
 
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
 
    private function settings(): array
    {
        $file = storage_path('app/settings.json');
        return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    }
}
