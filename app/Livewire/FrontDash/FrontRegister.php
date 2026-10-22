<?php

namespace App\Livewire\FrontDash;

use Packages\Common\Models\Customer;
use Packages\Helpers\BedayaHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class FrontRegister extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $success = false;

    public function register()
    {
        $this->validate([
            'name' => ['string', 'required', 'min:5', 'max:45'],
            'email' => ['email', 'required', 'unique:customers,email'],
            'password' => ['string', 'required', 'min:6', 'max:40'],
        ]);

        $customer = Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'token_key' => BedayaHelper::uniqueToken(),
        ]);

        $this->reset();
        $this->success = true;
        Auth::guard('customers')->login($customer);

        return redirect()->route('front_dashboard');
    }

    public function render()
    {
        return view('livewire.front-dash.front-register')->layout('layouts.frontend');
    }
}
