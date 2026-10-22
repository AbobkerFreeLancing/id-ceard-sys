<?php

namespace App\Livewire\Auth;

use Packages\Enum\Profile\UserAccountStatusEnum;
use Filament\Auth\Pages\Login;
use Filament\Forms\Components\TextInput;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use Filament\Schemas\Components\Component;

class AdminPanelCustomLogin extends Login
{
    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'email' => dev()->on_demo_mode ? config('bedaya.login_form_email') : '',
            'password' => dev()->on_demo_mode ? config('bedaya.login_form_password') : '',
        ]);
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::auth/pages/login.form.email.label'))
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1, 'class' => 'login-email-input']);
    }

    public function authenticate(): ?LoginResponse
    {
        $response = parent::authenticate();

        $user = auth()->user();

        if ($user->account_status == UserAccountStatusEnum::Inactive->value) {
            auth()->logout();
            throw ValidationException::withMessages([
                'data.email' => __('backend.account_inactive'), // Ensure you add this translation key
            ]);
        }
        if ($user->account_status == UserAccountStatusEnum::Banned->value) {
            auth()->logout();
            throw ValidationException::withMessages([
                'data.email' => __('backend.account_banned'), // Ensure you add this translation key
            ]);
        }

        return $response;
    }
}
