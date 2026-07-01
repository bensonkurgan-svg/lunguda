<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Sign in · Lunguda Heritage Archive')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login()
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            // Generic message — never reveal whether the email exists.
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        session()->regenerate();

        $user = Auth::user();

        return redirect()->intended($user->isAdmin() ? route('admin.dashboard') : route('home'));
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            event(new Lockout(request()));
            $seconds = RateLimiter::availableIn($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => "Too many attempts. Please try again in {$seconds} seconds.",
            ]);
        }
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
