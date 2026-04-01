<?php

namespace App\Filament\Resources\Assets\Schemas;

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

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('asset_tag')->required()->unique(ignoreRecord:true),
            TextInput::make('name')->required(),
            Select::make('category')->options(['laptop'=>'Laptop','phone'=>'Phone','tablet'=>'Tablet','furniture'=>'Furniture','vehicle'=>'Vehicle','equipment'=>'Equipment','other'=>'Other'])->required(),
            TextInput::make('location'),
            Select::make('condition')->options(['excellent'=>'Excellent','good'=>'Good','fair'=>'Fair','poor'=>'Poor','retired'=>'Retired'])->default('good'),
            DatePicker::make('purchase_date'),
            TextInput::make('purchase_value')->numeric()->prefix('USD'),
            Select::make('assigned_to')->relationship('assignee','name'),
            Textarea::make('notes')->columnSpanFull(),
        ])->columns(2);
    }
}
