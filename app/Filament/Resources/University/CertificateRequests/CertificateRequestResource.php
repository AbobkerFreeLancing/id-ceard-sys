<?php

namespace App\Filament\Resources\University\CertificateRequests;

use App\Filament\Resources\University\CertificateRequests\Pages\CreateCertificateRequest;
use App\Filament\Resources\University\CertificateRequests\Pages\EditCertificateRequest;
use App\Filament\Resources\University\CertificateRequests\Pages\ListCertificateRequests;
use App\Filament\Resources\University\CertificateRequests\Pages\ViewCertificateRequest;
use App\Filament\Resources\University\CertificateRequests\Schemas\CertificateRequestForm;
use App\Filament\Resources\University\CertificateRequests\Schemas\CertificateRequestInfolist;
use App\Filament\Resources\University\CertificateRequests\Tables\CertificateRequestsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\University\Models\CertificateRequest;

class CertificateRequestResource extends Resource
{
    protected static ?string $model = CertificateRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?string $recordTitleAttribute = 'serial_no';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): string
    {
        return __('backend.student_affairs_module');
    }

    public static function getLabel(): ?string
    {
        return __('backend.certificate_request');
    }

    public static function getPluralLabel(): ?string
    {
        return __('backend.certificate_requests');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.certificate_requests');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('certificate_requests_management');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('certificate_requests_management');
    }

    public static function form(Schema $schema): Schema
    {
        return CertificateRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CertificateRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CertificateRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCertificateRequests::route('/'),
            'create' => CreateCertificateRequest::route('/create'),
            'view' => ViewCertificateRequest::route('/{record}'),
            'edit' => EditCertificateRequest::route('/{record}/edit'),
        ];
    }
}
