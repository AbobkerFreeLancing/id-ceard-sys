<x-mail::message>
@if ($user)
# {{__('backend.welcome')}}, {{$user->name}}!
@endif

{{$subject}}
<br>
<br>

{{__('backend.thank_you')}},<br>
{{ config('app.name') }}
</x-mail::message>
