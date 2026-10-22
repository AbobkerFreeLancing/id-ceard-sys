<?php

namespace Packages\DocsModule\Livewire;

use Packages\DocsModule\Models\Project;
use Livewire\Component;

class DocsProjecDetails extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = Project::with([
            'sections' => fn($query) => $query->orderBy('order_column', 'ASC'),
            'sections.items'
        ])->findOrFail($project->id);
    }

    public function render()
    {
        return view('bedaya:docs::livewire.docs-projec-details')->layout('layouts.docs');
    }
}
