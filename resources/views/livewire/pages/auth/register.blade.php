<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

use App\Services\ReferralService;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $referral_code = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(ReferralService $referralService): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'referral_code' => ['nullable', 'string', 'exists:users,referral_code'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ];

        if (!empty($this->referral_code)) {
            $referrer = User::where('referral_code', $this->referral_code)->first();
            
            if ($referrer) {
                if ($referrer->referral_code_expires_at && $referrer->referral_code_expires_at->isPast()) {
                    $this->addError('referral_code', 'Este código de referido ha expirado.');
                    return;
                }
                $data['referred_by_id'] = $referrer->id;
            }
        }

        $user = User::create($data);

        event(new Registered($user));

        if ($user->referred_by_id) {
            $referralService->issueReferralCoupons($user);
        }

        Auth::login($user);

        $this->redirect(route('polijub.home', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-mary-input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" label="Nombre" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-mary-input wire:model="email" id="email" type="email" name="email" required autocomplete="username" label="Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-mary-input wire:model="password" id="password"
                            type="password"
                            name="password"
                            required autocomplete="new-password" label="Contraseña" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-mary-input wire:model="password_confirmation" id="password_confirmation"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" label="Confirmar Contraseña" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Referral Code -->
        <div class="mt-4">
            <x-mary-input wire:model="referral_code" id="referral_code" type="text" name="referral_code" label="Código de Referido (Opcional)" icon="o-gift" />
            <x-input-error :messages="$errors->get('referral_code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-mary-button class="ms-4" type="submit">
                {{ __('Register') }}
            </x-mary-button>
        </div>
    </form>
</div>