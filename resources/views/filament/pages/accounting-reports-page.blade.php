<x-filament-panels::page>
<section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
    <x-stat-widget title="Test 1" subtitle="5,840" color="bg-danger-600"></x-stat-widget>
    <x-stat-widget title="Test 2" subtitle="1540" color="bg-danger-600"></x-stat-widget>
    <x-stat-widget title="Test 3" subtitle="720" color="bg-danger-600"></x-stat-widget>
    <x-stat-widget title="Test 4" subtitle="100,000" color="bg-danger-600"></x-stat-widget>
</section>
{{-- ------------------- --}}
{{-- {{ $this->form }} --}}
{{-- ------------------- --}}
{{ $this->table }}
</x-filament-panels::page>
