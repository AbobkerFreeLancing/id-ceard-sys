<?php

namespace App\Livewire\FrontDash;

use Packages\Common\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ResetPasswordUpdate extends Component
{
    public $password;
    public $password_confirmation;
    public $the_key;
    public $link_expired = false;
    public $password_updated = false;

    public function mount($key)
    {
        $this->the_key = $key;

        $customer_exists = Customer::where('token_key', $this->the_key)->count();

        if ($customer_exists == 0) {
            $this->link_expired = true;
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => ['required', 'min:6', 'max:45', 'confirmed'],
            'password_confirmation' => 'required_with:password|same:password|min:6',
        ]);

        $customer = Customer::where('token_key', $this->the_key)->first();
        $customer->password = Hash::make($this->password);
        $customer->save();
        $this->reset(['password', 'password_confirmation']);
        $this->password_updated = true;
        $customer->update([
            'token_key' => null,
        ]);
    }

    public function render()
    {
        return view('livewire.front-dash.reset-password-update')->layout('layouts.frontend');
    }
}
