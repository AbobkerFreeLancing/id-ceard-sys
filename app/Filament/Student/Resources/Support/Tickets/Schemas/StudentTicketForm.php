<?php

namespace App\Filament\Student\Resources\Support\Tickets\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\Enum\PriorityEnum;
use Packages\Support\Models\TicketCategory;

class StudentTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('معلومات التذكرة والطلب')
                            ->description('يرجى تحديد عنوان وتفاصيل الطلب والمرفقات المطلوبة بدقة')
                            ->schema([
                                TextInput::make('title')
                                    ->label('عنوان التذكرة / المشكلة')
                                    ->placeholder('مثال: طلب تعديل الصورة الشخصية أو تصحيح الاسم')
                                    ->maxLength(120)
                                    ->required()
                                    ->columnSpanFull(),


                                Textarea::make('description')
                                    ->label('شرح الطلب أو المشكلة بالتفصيل')
                                    ->placeholder('اشرح هنا بالتفصيل ما ترغب بتعديله أو المشكلة التي تواجهك (مثلاً: أرجو اعتماد الصورة المرفقة كصورة شخصية رسمية، أو تصحيح رقم الهوية إلى...)')
                                    ->rows(6)
                                    ->required()
                                    ->columnSpanFull(),

                                FileUpload::make('attachment')
                                    ->label('المرفق (صورة شخصية / مستند إثبات شخصية / شهادة سودانية)')
                                    ->helperText('يمكنك رفع صورتك الشخصية الرسمية (JPG/PNG) أو صورة مستند إثبات الشخصية (الرقم الوطني) أو صورة الشهادة السودانية لاعتمادها في ملفك الأكاديمي')
                                    ->disk('public')
                                    ->directory(fn() => 'tickets/' . (student()?->university_no ?? 'general') . '/attachments')
                                    ->maxSize(10240)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
