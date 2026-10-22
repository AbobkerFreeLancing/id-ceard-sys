<?php

namespace App\Livewire\FrontDash;

use Packages\Common\Models\Customer;
use Packages\Helpers\BedayaHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class ActivateAccount extends Component
{
    public $token_key;
    public $msg;

    public function mount($token_key)
    {
        $student = Customer::where('token_key', $this->token_key)->first();

        if ($student != null) {
            $student->update([
                'email_verified_at' => now(),
                'token_key' => null,
            ]);

            $this->msg = __('backend.account_has_been_activated');
        } else {
            $this->msg = __('backend.url_expired');
        }
    }

    public function render()
    {
        return view('livewire.front-dash.activate-account')->layout('layouts.frontend');
    }
}
