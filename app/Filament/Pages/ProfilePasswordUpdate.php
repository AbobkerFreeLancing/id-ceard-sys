<?php

namespace App\Filament\Pages;

use Closure;
use App\Models\User;
use Filament\Pages\Page;
use App\Rules\OldPasswordMatch;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Hash;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification as Notify;

class ProfilePasswordUpdate extends Page
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';
    protected string $view = 'filament.pages.profile-password-update';
    protected ?string $heading = '';

    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return __("backend.update_password");
    }

    public function getTitle(): string
    {
        return ucwords(__("backend.update_password"));
    }

    public function mount()
    {
        $user = auth()->user();
    }

    protected function getFormSchema(): array
    {
        return [


            Group::make()->schema([
                Group::make()->schema([
                    Section::make(__('backend.update_password'))
                        ->icon(Heroicon::OutlinedShieldCheck)
                        ->schema([
                            TextEntry::make('full_name')
                                ->label(__('backend.name'))
                                ->badge()
                                ->color('gray')
                                ->state(fn() => auth()->user()->full_name),
                            TextInput::make('current_password')
                                ->required()
                                ->password()
                                ->revealable()
                                ->maxLength(50)
                                ->label(__('backend.current_password'))
                                ->rules([
                                    function () {
                                        return function (string $attribute, $value, Closure $fail) {
                                            if (!Hash::check($this->current_password, auth()->user()->password)) {
                                                $fail(__('backend.password_entered_not_match_current'));
                                            }
                                        };
                                    },
                                ]),

                            TextInput::make('new_password')
                                ->required()
                                ->minLength(6)
                                ->password()
                                ->revealable()
                                ->label(__('backend.new_password'))
                                ->confirmed()
                                ->maxLength(50),

                            TextInput::make('new_password_confirmation')
                                ->required()
                                ->minLength(6)
                                ->password()
                                ->revealable()
                                ->label(__('backend.confirm_new_password'))
                                ->maxLength(50),
                        ])->compact()->columns(2)
                ])->columnSpan(['lg' => 2]),
                Group::make()->schema([
                    Section::make(__('backend.extra_info'))
                        ->compact()
                        ->schema([
                            TextEntry::make('created_at')->label(__('backend.created_at'))
                                ->state(auth()->user()->created_at?->diffForHumans()),
                            TextEntry::make('updated_at')->label(__('backend.updated_at'))
                                ->state(auth()->user()->updated_at?->diffForHumans()),
                        ])
                ]),
            ])->columns(3)
        ];
    }


    public function updatePassword()
    {
        $this->form->getState();

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($this->new_password)
        ]);

        Notify::make()->title(__('backend.action_updated'))->success()->send();
        return redirect(request()->header('Referer'));
    }
}
