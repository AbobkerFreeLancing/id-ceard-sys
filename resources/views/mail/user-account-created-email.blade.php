<x-mail::message>
# {{__('backend.welcome')}}, {{$user->name}}!

{{ __('backend.account_created_successfuly') }}

{{ __('backend.account_number') }}

<x-mail::panel>
<span style="font-size: 20px;color: #222">{{ $user->email }}</span>
</x-mail::panel>

<br>
{{__('backend.thank_you')}},<br>
{{ config('app.name') }}
</x-mail::message>
