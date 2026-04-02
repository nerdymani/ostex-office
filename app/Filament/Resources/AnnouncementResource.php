<?php
namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-megaphone';
    protected static string|\UnitEnum|null $navigationGroup = 'My Work';
    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return auth()->user()?->is_admin ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
            RichEditor::make('body')->required()->columnSpanFull(),
            Toggle::make('is_pinned')->label('Pin this announcement'),
            DateTimePicker::make('published_at')->label('Publish At')->nullable(),
            DateTimePicker::make('expires_at')->label('Expires At')->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_pinned')->label('Pinned')->boolean(),
                TextColumn::make('title')->searchable()->limit(50),
                TextColumn::make('author.name')->label('Author')->placeholder('System'),
                TextColumn::make('published_at')->dateTime()->sortable()->placeholder('Draft'),
            ])
            ->defaultSort('is_pinned', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn () => auth()->user()?->is_admin),
                Tables\Actions\DeleteAction::make()->visible(fn () => auth()->user()?->is_admin),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit'   => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
