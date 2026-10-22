<?php

namespace App\Livewire\FrontDash;

use App\Models\User;
use Packages\Common\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FrontLogin extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $cust = Customer::where('email', $this->email)->first();

        if ($cust != null && password_verify($this->password, $cust->password)) {
            Auth::guard('customers')->login($cust);
            return redirect()->route('front_dashboard');
        } else {
            $this->addError('invalid_login', __('backend.invalid_login_details'));
        }
    }

    public function render()
    {
        return view('livewire.front-dash.front-login')->layout('layouts.frontend');
    }
}
