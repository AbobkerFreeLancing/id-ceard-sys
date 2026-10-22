<x-mail::message>
# {{__('backend.welcome')}}, {{$user->name}}!

{{ __('backend.password_reset_requested') }}

{{ __('backend.otp') }}

<x-mail::panel>
<span style="font-size: 20px;color: #222">{{ $token }}</span>
</x-mail::panel>

<br>
{{__('backend.thank_you')}},<br>
{{ config('app.name') }}
</x-mail::message>
