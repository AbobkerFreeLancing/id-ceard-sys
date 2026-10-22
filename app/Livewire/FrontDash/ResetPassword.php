<?php

namespace App\Livewire\FrontDash;

use Packages\Common\Models\Customer;
use Packages\Helpers\BedayaHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component
{
    public $email;

    public function resetPassword()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $cust = Customer::where('email', $this->email)->first();

        if ($cust != null) {
            $cust->token_key = BedayaHelper::uniqueToken();
            $cust->save();
            // return redirect()->route('front_reset_password_update', $cust->token_key);
            return redirect()->route('reset_password_sent');
        } else {
            $this->addError('no_customer_found', __('backend.user_with_email_not_exists'));
        }
    }

    public function render()
    {
        return view('livewire.front-dash.reset-password')->layout('layouts.frontend');
    }
}
