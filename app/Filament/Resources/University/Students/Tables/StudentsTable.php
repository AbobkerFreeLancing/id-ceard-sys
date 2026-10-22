<?php

namespace App\Filament\Resources\University\Students\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Packages\University\Models\AcademicStatus;
use Packages\University\Models\AcceptanceType;
use Packages\University\Models\College;
use Illuminate\Database\Eloquent\Builder;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query, $livewire) {
                $filters = $livewire->tableFilters ?? [];

                $collegeId = $filters['college_id']['value'] ?? null;
                $statusId = $filters['academic_status_id']['value'] ?? null;
                $acceptanceId = $filters['acceptance_type_id']['value'] ?? null;
                $search = method_exists($livewire, 'getTableSearch') ? $livewire->getTableSearch() : ($livewire->tableSearch ?? null);

                // في حالة عدم تطبيق فلتر الكلية أو أي فلاتر أخرى أو بحث، يتم عرض أحدث 10 طلاب تمت إضافتهم للنظام
                if (blank($collegeId) && blank($statusId) && blank($acceptanceId) && blank($search)) {
                    $latestIds = \Packages\University\Models\Student::query()
                        ->latest('id')
                        ->limit(10)
                        ->pluck('id')
                        ->toArray();

                    $query->whereIn('students.id', $latestIds ?: [0]);
                }
            })
            ->defaultSort('id', 'desc')
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50, 100])
            ->columns([
                ImageColumn::make('profile_picture')
                    ->label(__('backend.profile_picture'))
                    ->circular()
                    ->defaultImageUrl(fn($record) => $record->getFilamentAvatarUrl()),
                TextColumn::make('university_no')
                    ->label(__('backend.university_no'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('backend.full_name'))
                    ->searchable(
                        query: function (Builder $query, string $search): Builder {
                            return $query->where(function ($q) use ($search) {
                                $q->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('second_name', 'like', "%{$search}%")
                                    ->orWhere('third_name', 'like', "%{$search}%")
                                    ->orWhere('fourth_name', 'like', "%{$search}%");
                            });
                        },
                    ),
                TextColumn::make('academicRecord.academicStatus.name')
                    ->label(__('backend.academic_status'))
                    ->badge()
                    ->searchable(),
                TextColumn::make('academicRecord.acceptanceType.name')->label(__('backend.acceptance_type')),
                TextColumn::make('academicRecord.college.name')->label(__('backend.college')),
                TextColumn::make('academicRecord.department.name')->label(__('backend.department')),
                TextColumn::make('created_at')
                    ->label(__('backend.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->emptyStateHeading(__('لا توجد بيانات طلاب'))
            ->emptyStateDescription(__('لم يتم العثور على أي طلاب مطابقين للبحث أو الفلتر المحدد.'))
            ->emptyStateIcon('heroicon-o-user-group')
            ->filters(
                [
                    SelectFilter::make('college_id')
                        ->label(__('backend.college'))
                        ->options(fn() => College::pluck('name', 'id')->toArray())
                        ->query(function ($query, array $data) {
                            if (filled($data['value'] ?? null)) {
                                $query->whereHas('academicRecord', fn($q) => $q->where('college_id', $data['value']));
                            }
                        })
                        ->searchable()
                        ->preload(),

                    SelectFilter::make('academic_status_id')
                        ->label(__('backend.academic_status'))
                        ->options(fn() => AcademicStatus::pluck('name', 'id')->toArray())
                        ->query(function ($query, array $data) {
                            if (filled($data['value'] ?? null)) {
                                $query->whereHas(
                                    'academicRecord',
                                    fn($q) => $q->where('academic_status_id', $data['value']),
                                );
                            }
                        })
                        ->searchable()
                        ->preload(),

                    SelectFilter::make('acceptance_type_id')
                        ->label(__('backend.acceptance_type'))
                        ->options(fn() => AcceptanceType::pluck('name', 'id')->toArray())
                        ->query(function ($query, array $data) {
                            if (filled($data['value'] ?? null)) {
                                $query->whereHas(
                                    'academicRecord',
                                    fn($q) => $q->where('acceptance_type_id', $data['value']),
                                );
                            }
                        })
                        ->searchable()
                        ->preload(),
                ],
                layout: FiltersLayout::AboveContent,
            )
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    Action::make('update_password')
                        ->label(__('backend.update_password'))
                        ->modalAlignment(Alignment::Center)
                        ->modalWidth(Width::Medium)
                        ->modalIcon(Heroicon::OutlinedKey)
                        ->icon(Heroicon::OutlinedKey)
                        ->after(function () {
                            Notification::make()->title(__('backend.password_reset_successfuly'))->success()->send();
                        })
                        ->action(function ($record, array $data): void {
                            $record->password = Hash::make($data['password']);
                            $record->save();
                        })
                        ->schema([
                            TextEntry::make('name')->label(__('backend.student'))->state(fn($record) => $record->name),
                            TextInput::make('password')
                                ->label(__('backend.password'))
                                ->password()
                                ->revealable()
                                ->minLength(6)
                                ->maxLength(40)
                                ->required(),
                        ]),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([BulkActionGroup::make([])]);
    }
}
