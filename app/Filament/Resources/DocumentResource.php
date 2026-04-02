<?php
namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static string|\UnitEnum|null $navigationGroup = 'My Work';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->maxLength(255),
            Select::make('category')
                ->options(['Policy' => 'Policy', 'Template' => 'Template', 'Report' => 'Report', 'Guide' => 'Guide', 'Other' => 'Other'])
                ->nullable(),
            Textarea::make('description')->rows(2)->columnSpanFull(),
            FileUpload::make('file_path')
                ->label('File')
                ->disk('public')
                ->directory('documents')
                ->required()
                ->maxSize(20480)
                ->columnSpanFull()
                ->saveUploadedFileUsing(function ($file, $get, $set) {
                    $set('file_name', $file->getClientOriginalName());
                    $set('file_size', $file->getSize());
                    $set('mime_type', $file->getMimeType());
                    return $file->store('documents', 'public');
                }),
            TextInput::make('file_name')->hidden(),
            TextInput::make('file_size')->hidden(),
            TextInput::make('mime_type')->hidden(),
            Toggle::make('is_public')->label('Visible to all staff')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('category')->badge()->placeholder('—'),
                TextColumn::make('file_name')->label('File')->limit(30),
                TextColumn::make('file_size')->label('Size')
                    ->formatStateUsing(fn ($state) => $state
                        ? ($state < 1048576 ? round($state / 1024, 1) . ' KB' : round($state / 1048576, 1) . ' MB')
                        : '—'),
                TextColumn::make('download_count')->label('Downloads'),
                TextColumn::make('uploader.name')->label('Uploaded By'),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->label('Download')
                    ->action(function ($record) {
                        $record->increment('download_count');
                        return response()->download(storage_path('app/public/' . $record->file_path), $record->file_name);
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit'   => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
