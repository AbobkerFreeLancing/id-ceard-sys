---
name: livewire-modular-architecture
description: Comprehensive development skill for building modular Laravel applications with Livewire 3/4, Filament Server-Driven UI, Packages/ modular architecture, and Tailwind CSS v4. Use when creating or modifying Livewire components, developing package modules, embedding forms/tables in Livewire, implementing real-time WebSockets with Reverb, or adhering to Bedaya architecture standards.
---

# 🚀 Modular Livewire & Filament Architecture Skill

This skill provides step-by-step procedures, conventions, and implementation recipes for building applications using the **Bedaya Modular Laravel + Livewire + Filament** stack.

---

## 📌 1. Architectural Philosophy

1. **Livewire-First for Interactivity**:
   - Every reactive frontend feature must use Livewire instead of standalone SPA frameworks (React/Vue).
   - Use Alpine.js only for browser-local UI state (e.g., dropdown toggles, modal open/close, show/hide password).
2. **Filament Server-Driven UI (SDUI)**:
   - For complex forms, use Filament Schemas (`HasSchemas`) inside Livewire.
   - For data lists, filters, pagination, and bulk actions, use Filament Tables (`HasTable`) inside Livewire.
3. **Internal Modular Packages (`Packages/`)**:
   - Group domain features into internal packages under `Packages/<ModuleName>/`.
   - Autoloaded via PSR-4 `"Packages\\": "Packages/"` in `composer.json`.
   - Packaged Livewire components are registered using `Livewire::addNamespace(...)`.
4. **Tailwind CSS v4 & Vite**:
   - Modern utility styling compiled via `@tailwindcss/vite`.
   - Hot reloading watches `app/Livewire/**`, `app/Filament/**`, and `Packages/**`.
5. **Real-time WebSockets**:
   - Laravel Reverb + Laravel Echo for broadcasting events and live table/component updates.

---

## 🛠️ 2. Livewire Component Recipes

### Recipe A: Full-Page Livewire Component
Use for public pages, dashboards, and portals without standard Laravel blade controllers.

```php
<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class CourseCatalogPage extends Component
{
    public string $search = '';
    public ?int $selectedCollegeId = null;

    public function mount(): void
    {
        // Initial setup
    }

    public function render()
    {
        return view('livewire.pages.course-catalog-page', [
            // query logic
        ])->layout('layouts.frontend'); // Standard layout
    }
}
```

### Recipe B: Livewire Component with Filament Form/Schema (`HasSchemas`)
Use for rich, validated forms without manual HTML inputs.

```php
<?php

namespace App\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;

class StudentRegistrationForm extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public ?string $name = null;
    public ?string $national_id = null;
    public ?int $college_id = null;
    public ?string $notes = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('backend.registration_details'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('backend.full_name'))
                            ->required()
                            ->maxLength(120),
                        TextInput::make('national_id')
                            ->label(__('backend.national_id'))
                            ->required()
                            ->unique(table: 'students', column: 'national_id'),
                        Select::make('college_id')
                            ->label(__('backend.college'))
                            ->options(\Packages\University\Models\College::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Textarea::make('notes')
                            ->label(__('backend.notes'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        // Save logic...
        
        $this->dispatch('registration-completed', id: 123);
    }

    public function render()
    {
        return view('livewire.student-registration-form')->layout('layouts.frontend');
    }
}
```

**Blade Template (`resources/views/livewire/student-registration-form.blade.php`):**
```blade
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-sm">
    <form wire:submit.prevent="submit" class="space-y-6">
        {{ $this->form }}

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg shadow-sm transition disabled:opacity-50">
                <span wire:loading.remove wire:target="submit">{{ __('backend.save') }}</span>
                <span wire:loading wire:target="submit">{{ __('backend.processing') }}...</span>
            </button>
        </div>
    </form>
</div>
```

### Recipe C: Livewire Component with Filament Table (`HasTable`)
Use for paginated, searchable, and filterable data tables on the frontend or student/client panels.

```php
<?php

namespace App\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Packages\University\Models\Result;

class StudentResultsTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Result::query()->where('student_id', auth('student')->id())->latest())
            ->columns([
                TextColumn::make('course.name')
                    ->label(__('backend.course'))
                    ->searchable(),
                TextColumn::make('course.code')
                    ->label(__('backend.course_code')),
                TextColumn::make('total_mark')
                    ->label(__('backend.total_mark'))
                    ->sortable(),
                TextColumn::make('grade')
                    ->label(__('backend.grade'))
                    ->badge(),
                TextColumn::make('created_at')
                    ->label(__('backend.date'))
                    ->date(),
            ])
            ->filters([
                // Add select filters
            ])
            ->paginationPageOptions([10, 25, 50]);
    }

    public function render()
    {
        return view('livewire.student-results-table');
    }
}
```

**Blade Template (`resources/views/livewire/student-results-table.blade.php`):**
```blade
<div class="w-full">
    {{ $this->table }}
</div>
```

---

## 📦 3. Modular Package (`Packages/`) Creation Guide

When adding a new module (e.g. `HumanResources` or `Inventory`):

1. **Directory Structure**:
   ```text
   Packages/HumanResources/
   ├── Database/
   │   ├── Migrations/
   │   └── Seeders/
   ├── Enums/
   ├── Livewire/
   │   └── EmployeeList.php
   ├── Models/
   ├── routes/
   │   ├── api.php
   │   └── web.php
   ├── resources/
   │   ├── lang/
   │   └── views/
   │       └── livewire/
   │           └── employee-list.blade.php
   └── HumanResourcesServiceProvider.php
   ```

2. **Package ServiceProvider Template**:
   ```php
   <?php

   namespace Packages\HumanResources;

   use Illuminate\Support\ServiceProvider;
   use Livewire\Livewire;

   class HumanResourcesServiceProvider extends ServiceProvider
   {
       public function boot(): void
       {
           // 1. Migrations
           $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

           // 2. Views
           $this->loadViewsFrom(__DIR__ . '/resources/views', 'hr');

           // 3. Translations
           $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'hr');

           // 4. Livewire Namespace registration
           Livewire::addNamespace(
               namespace: 'hr',
               classNamespace: 'Packages\\HumanResources\\Livewire',
               classPath: __DIR__ . '/Livewire',
               classViewPath: __DIR__ . '/resources/views/livewire',
           );

           // 5. Routes
           $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
       }
   }
   ```

3. **Registering in `Packages/Providers/BedayaServiceProvider.php`**:
   Add feature-flag control:
   ```php
   if (config('bedaya.hr_enabled', false)) {
       $this->app->register(\Packages\HumanResources\HumanResourcesServiceProvider::class);
   }
   ```

4. **Using the Modular Livewire Component in Blade**:
   ```blade
   <livewire:hr::employee-list />
   ```

---

## ⚡ 4. Livewire & Reverb Real-Time Broadcasting

When broadcasting events from background jobs or controllers:

1. **Dispatching Event**:
   ```php
   use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

   class PaymentReceivedEvent implements ShouldBroadcast
   {
       public function __construct(public int $accountId, public float $amount) {}

       public function broadcastOn(): array
       {
           return [new \Illuminate\Broadcasting\PrivateChannel('account.' . $this->accountId)];
       }
   }
   ```

2. **Listening in Livewire Component**:
   ```php
   use Livewire\Attributes\On;

   class AccountBalanceWidget extends Component
   {
       public int $accountId;
       public float $balance = 0.0;

       #[On('echo-private:account.{accountId},PaymentReceivedEvent')]
       public function onPaymentReceived($event): void
       {
           $this->balance += $event['amount'];
           $this->dispatch('notify', message: __('backend.payment_received'));
       }
   }
   ```

---

## 📋 5. Code Quality & Standards Checklist

- [ ] **Arabic Localization**: Never hardcode labels in Blade or Livewire components. Always use `__('backend.key_name')` or package translation `__('package::file.key_name')`.
- [ ] **Asset Requirements**: Frontend layouts MUST include `@filamentStyles`, `@filamentScripts`, and `@vite(['resources/css/frontend.css', 'resources/js/app.js'])`.
- [ ] **Alpine.js Cloak**: Always include `[x-cloak] { display: none !important; }` in layouts and use `x-cloak` on conditional elements.
- [ ] **Form Validation**: Always define validation rules either in `$this->validate()` or through Filament Schema component rules (`->required()`, `->maxLength()`).
- [ ] **Loading States**: Add `wire:loading` and `wire:target` for every action button to prevent double-submissions.
