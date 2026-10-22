<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification as Notify;

class DashboardProfilePage extends Page
{
    use InteractsWithForms;

    protected static bool $isScopedToTenant = false;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog';

    protected string $view = 'filament.pages.user-profile';

    public $user__id, $name, $email, $phone, $lang, $address, $has_admin_sidebar;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.my_profile');
    }

    public function getTitle(): string
    {
        return ucwords(__('backend.my_profile'));
    }

    public function mount()
    {
        $user = auth()->user();

        $this->user__id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->lang = $user->lang;
        $this->address = $user->address;
        $this->has_admin_sidebar = $user->has_admin_sidebar;
    }

    protected function getFormSchema(): array
    {
        return [
            Group::make([
                Group::make()
                    ->schema([
                        Section::make([
                            TextInput::make('name')
                                ->label(ucfirst(__('backend.name')))
                                ->prefixIcon(Heroicon::OutlinedUser)
                                ->minLength(2)
                                ->maxLength(45),
                            Select::make('lang')
                                ->label(ucfirst(__('backend.interface_language')))
                                ->required()
                                ->prefixIcon(Heroicon::OutlinedLanguage)
                                ->options(['en' => __('backend.english'), 'ar' => __('backend.arabic')]),
                            TextInput::make('email')
                                ->label(__('backend.email'))
                                ->email()
                                ->prefixIcon(Heroicon::OutlinedEnvelope)
                                ->required()
                                ->unique(ignoreRecord: true),
                            TextInput::make('phone')
                                ->label(__('backend.phone'))
                                ->prefixIcon(Heroicon::OutlinedPhone)
                                ->numeric()
                                ->maxLength(14)
                                ->unique(ignoreRecord: true),
                            TextInput::make('address')
                                ->label(ucfirst(__('backend.address')))
                                ->prefixIcon(Heroicon::OutlinedHome)
                                ->maxLength(200),
                        ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            Toggle::make('has_admin_sidebar')
                                ->label(ucfirst(__('backend.has_admin_sidebar')))
                                ->default(true)
                                ->required(),
                            TextEntry::make('created_at')
                                ->label(__('backend.created_at'))
                                ->icon(Heroicon::OutlinedCalendarDays)
                                ->state(fn(): ?string => auth()->user()?->created_at?->diffForHumans()),
                            TextEntry::make('updated_at')
                                ->label(__('backend.updated_at'))
                                ->icon(Heroicon::OutlinedCalendarDays)
                                ->state(fn(): ?string => auth()->user()?->updated_at?->diffForHumans()),
                        ]),
                ]),
            ])->columns(3),
        ];
    }

    public function updateSettings()
    {
        $this->form->getState();

        User::find(auth()->id())->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'lang' => $this->lang,
            'address' => $this?->address,
            'has_admin_sidebar' => $this?->has_admin_sidebar,
        ]);

        Notify::make()->title(__('backend.action_updated'))->success()->send();

        return redirect(request()->header('Referer'));
    }
}
