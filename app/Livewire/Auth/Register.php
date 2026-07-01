<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Create an account · Lunguda Heritage Archive')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        // New sign-ups are always learners. Elevation to contributor/admin
        // is done by a superadmin from the admin area — never self-assigned.
        $validated['role'] = User::ROLE_LEARNER;

        $user = User::create($validated); // password auto-hashed via cast

        event(new Registered($user));
        Auth::login($user);
        session()->regenerate();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
