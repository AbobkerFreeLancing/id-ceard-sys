<?php

namespace App\Livewire\Cardholders;

use App\Models\Cardholder;
use App\Models\Department;
use App\Models\Organization;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('دليل حاملي البطاقات | Huwia ID')]
class CardholderDirectory extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $organizationId = '';

    #[Url(history: true)]
    public string $departmentId = '';

    #[Url(history: true)]
    public string $status = '';

    public string $viewMode = 'grid'; // 'grid' | 'table'

    public ?int $flippedCardId = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedOrganizationId(): void
    {
        $this->departmentId = '';
        $this->resetPage();
    }

    public function updatedDepartmentId(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function toggleFlip(int $cardholderId): void
    {
        $this->flippedCardId = ($this->flippedCardId === $cardholderId) ? null : $cardholderId;
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->organizationId = '';
        $this->departmentId = '';
        $this->status = '';
        $this->resetPage();
    }

    public function render(): View
    {
        $query = Cardholder::with(['organization', 'department', 'activeCard', 'cards'])
            ->when($this->search, function ($q) {
                $term = trim($this->search);
                $q->where(function ($sub) use ($term) {
                    $sub->where('full_name_ar', 'like', "%{$term}%")
                        ->orWhere('full_name_en', 'like', "%{$term}%")
                        ->orWhere('national_id', 'like', "%{$term}%")
                        ->orWhere('employee_no', 'like', "%{$term}%");
                });
            })
            ->when($this->organizationId, fn ($q) => $q->where('organization_id', $this->organizationId))
            ->when($this->departmentId, fn ($q) => $q->where('department_id', $this->departmentId))
            ->when($this->status, function ($q) {
                if ($this->status === 'has_active') {
                    $q->whereHas('activeCard');
                } elseif ($this->status === 'no_card') {
                    $q->doesntHave('cards');
                }
            })
            ->latest('id');

        $cardholders = $query->paginate(8);

        $organizations = Organization::active()->orderBy('name_ar')->get();

        $departments = Department::when($this->organizationId, fn ($q) => $q->where('organization_id', $this->organizationId))
            ->orderBy('name_ar')
            ->get();

        return view('livewire.cardholders.cardholder-directory', [
            'cardholders' => $cardholders,
            'organizations' => $organizations,
            'departments' => $departments,
        ])->layout('layouts.app');
    }
}
