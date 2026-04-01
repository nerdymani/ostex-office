<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->columnSpanFull(),
            RichEditor::make('body')->required()->columnSpanFull(),
            Select::make('audience')->options(['all'=>'All Staff','HR'=>'HR','Finance'=>'Finance','Technology'=>'Technology','Sales'=>'Sales','Operations'=>'Operations','Support'=>'Support','Social Media'=>'Social Media'])->default('all'),
            Hidden::make('created_by')->default(fn()=>auth()->id()),
            Toggle::make('is_pinned')->label('Pin Announcement'),
        ])->columns(2);
    }
}
