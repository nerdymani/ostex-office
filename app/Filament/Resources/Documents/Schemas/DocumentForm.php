<?php

namespace App\Filament\Resources\Documents\Schemas;

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

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required(),
            Select::make('department')->options(['HR'=>'HR','Finance'=>'Finance','Technology'=>'Technology','Sales'=>'Sales','Operations'=>'Operations','Support'=>'Support','Social Media'=>'Social Media','General'=>'General'])->required(),
            TextInput::make('category')->default('general'),
            FileUpload::make('file_path')->required()->disk('public')->directory('documents')->label('File'),
            Hidden::make('uploaded_by')->default(fn()=>auth()->id()),
        ])->columns(2);
    }
}
