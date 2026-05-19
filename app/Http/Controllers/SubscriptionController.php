<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    public function create(): View
    {
        return view('subscribe');
    }

    public function store(StoreSubscriptionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::firstOrCreate(
            ['email' => $data['email']],
            [
                'verification_token' => Str::random(32),
            ]
        );

        $exists = Subscription::where('user_id', $user->id)
            ->where('url', $data['url'])
            ->exists();

        if ($exists) {
            return back()
                ->with('warning', 'You are already subscribed to this URL.')
                ->withInput();
        }

        Subscription::create([
            'user_id' => $user->id,
            'url' => $data['url'],
        ]);

        if ($user->email_verified_at === null) {

            $verificationUrl = route('verify.email', $user->verification_token);

            $message = "Please verify your email by clicking the link below:\n" . $verificationUrl;

            Mail::raw($message, function ($mail) use ($user) {
                $mail->to($user->email)
                    ->subject('Verify your subscription');
            });
        }

        return back()->with('success', 'Subscription created. Check your email.');
    }

    public function verify(string $token): View
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);

        return view('verified');
    }
}
