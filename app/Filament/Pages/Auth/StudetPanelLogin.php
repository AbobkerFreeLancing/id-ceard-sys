<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Packages\University\Models\Student;
use SensitiveParameter;

class StudetPanelLogin extends Login
{
    public function getHeading(): string|Htmlable
    {
        return __('backend.student_account');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getLoginFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent(),
        ]);
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('university_no')
            ->label(__('backend.university_no'))
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        return [
            'university_no' => $data['university_no'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.university_no' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        $student = Student::query()->where('university_no', $data['university_no'])->first();

        if (!$student) {
            $this->throwFailureValidationException();
        }

        if (!Hash::check($data['password'], $student->password)) {
            $this->throwFailureValidationException();
        }

        Auth::guard('student')->login($student, $data['remember'] ?? false);

        // Make sure the student has an admission.
        // if ($student->academicRecord()->doesntExist()) {
        // Auth::guard('student')->logout()

        //     throw ValidationException::withMessages([
        //         'data.university_no' => __('backend.no_admission_record'),
        //     ]);
        // }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
