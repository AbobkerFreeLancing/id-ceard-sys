<div class="flex items-center">
    @if($account->isChild())
        <svg class="rotate-y h-6 w-6" xmlns="http://www.w3.org/2000/svg" version="1.0" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
<g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
<path d="M420 4789 c-14 -5 -36 -20 -48 -32 -55 -51 -52 95 -52 -2200 l0 -2124 23 -34 c12 -18 38 -44 56 -56 l34 -23 2127 0 2127 0 34 23 c104 70 106 197 6 271 l-28 21 -2030 3 -2029 2 0 2013 0 2013 -22 44 c-13 24 -35 53 -50 63 -31 23 -112 32 -148 16z"/>
</g>
</svg>
    @endif
    <div class="bg-white px-8 py-3 gap-x-2 items-center rounded-lg shadow flex" style="min-width: 300px">
    @if($account->level_type == 'group')
    <svg class="h-4 w-4" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 58 58" style="enable-background:new 0 0 58 58;" xml:space="preserve">
<path style="fill:#EFCE4A;" d="M46.324,58H1.565c-1.03,0-1.779-0.978-1.51-1.973l10.166-27.871C10.405,27.474,11.024,27,11.731,27
	H56.49c1.03,0,1.51,0.984,1.51,1.973L47.834,56.844C47.65,57.526,47.031,58,46.324,58z"/>
<path style="fill:#EBBA16;" d="M50.268,18H48v9h4v-7.268C52,18.775,51.224,18,50.268,18z"/>
<path style="fill:#EBBA16;" d="M4,11H1.732C0.776,11,0,11.775,0,12.732V55.46c0.069,0.002,0.138,0.006,0.205,0.01L4,45.122V11z"/>
<path style="fill:#F4EFDC;" d="M10.221,28.156C10.405,27.474,11.024,27,11.731,27h2H48V15V0H33H10v28.761L10.221,28.156z"/>
<g><path style="fill:#CEC9AE;" d="M17,16h24c0.552,0,1-0.447,1-1s-0.448-1-1-1H17c-0.552,0-1,0.447-1,1S16.448,16,17,16z"/><path style="fill:#CEC9AE;" d="M17,9h10c0.552,0,1-0.447,1-1s-0.448-1-1-1H17c-0.552,0-1,0.447-1,1S16.448,9,17,9z"/><path style="fill:#CEC9AE;" d="M41,21H17c-0.552,0-1,0.447-1,1s0.448,1,1,1h24c0.552,0,1-0.447,1-1S41.552,21,41,21z"/>
</g><polygon style="fill:#CEC9AE;" points="10,28.761 10,2 7,2 7,36.986 "/>
<polygon style="fill:#D1BF86;" points="7,36.986 7,4 4,4 4,45.211 "/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
@else
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#b9a770" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
</svg>

@endif {{ $account->name }}</div>
</div>

<x-accounts :accounts="$account->children" />