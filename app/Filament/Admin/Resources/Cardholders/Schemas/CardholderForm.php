<?php

namespace App\Filament\Admin\Resources\Cardholders\Schemas;

use App\Enums\CardholderAuditStatus;
use App\Models\Department;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class CardholderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('البيانات الشخصية والأساسية')
                    ->description('أدخل معلومات الاسم والرقم القومي بدقة وفق الوثائق الرسمية')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('full_name_ar')
                                ->label('الاسم الكامل (بالعربية)')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('full_name_en')
                                ->label('الاسم الكامل (بالإنجليزية)')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('national_id')
                                ->label('الرقم القومي / معرّف الهوية')
                                ->unique(ignoreRecord: true)
                                ->required()
                                ->maxLength(50),
                            TextInput::make('employee_no')
                                ->label('الرقم الوظيفي / الأكاديمي')
                                ->maxLength(50),
                            Select::make('blood_type')
                                ->label('فصيلة الدم')
                                ->options([
                                    'A+' => 'A+',
                                    'A-' => 'A-',
                                    'B+' => 'B+',
                                    'B-' => 'B-',
                                    'AB+' => 'AB+',
                                    'AB-' => 'AB-',
                                    'O+' => 'O+',
                                    'O-' => 'O-',
                                ]),
                        ]),
                    ]),

                Section::make('التبعية التنظيمية والصور')
                    ->description('تحديد المؤسسة والقسم ومرفقات الصورة والتوقيع للبطاقة')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('organization_id')
                                ->label('المؤسسة التابع لها')
                                ->relationship('organization', 'name_ar')
                                ->required()
                                ->live(),
                            Select::make('department_id')
                                ->label('القسم / الإدارة')
                                ->relationship('department', 'name_ar')
                                ->options(function (Get $get) {
                                    $orgId = $get('organization_id');
                                    if (! $orgId) {
                                        return [];
                                    }

                                    return Department::where('organization_id', $orgId)->pluck('name_ar', 'id');
                                })
                                ->searchable(),
                            FileUpload::make('photo_path')
                                ->label('الصورة الشخصية (CR80 Photo)')
                                ->image()
                                ->avatar()
                                ->disk('public')
                                ->directory('cardholders/photos')
                                ->visibility('public'),
                            FileUpload::make('signature_path')
                                ->label('التوقيع الرقمي المعتمد')
                                ->image()
                                ->disk('public')
                                ->directory('cardholders/signatures')
                                ->visibility('public'),
                        ]),
                    ]),

                Section::make('التدقيق واعتماد الطباعة')
                    ->description('مراجعة وتأكيد صحة البيانات وصلاحيتها للإصدار')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('audit_status')
                                ->label('حالة التدقيق والاعتماد')
                                ->options(CardholderAuditStatus::class)
                                ->default(CardholderAuditStatus::Approved->value)
                                ->required(),
                            Textarea::make('audit_notes')
                                ->label('ملاحظات التدقيق والاعتماد')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}
