@foreach($accounts as $account)
    <div
        class="space-y-2 {{ $account->isChild() ? 'ltr:ml-8 rtl:mr-8' : null }}">
        <x-account :account="$account" />
    </div>
@endforeach