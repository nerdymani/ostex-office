<?php

namespace App\Filament\Resources\Projects\Schemas;

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

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->columnSpanFull(),
            Textarea::make('description')->columnSpanFull(),
            TextInput::make('client'),
            Select::make('status')->options(['planning'=>'Planning','active'=>'Active','on_hold'=>'On Hold','completed'=>'Completed','cancelled'=>'Cancelled'])->default('planning'),
            Select::make('priority')->options(['low'=>'Low','medium'=>'Medium','high'=>'High'])->default('medium'),
            DatePicker::make('start_date'),
            DatePicker::make('deadline'),
            Select::make('lead_by')->relationship('lead','name')->label('Project Lead'),
            TextInput::make('progress')->numeric()->minValue(0)->maxValue(100)->suffix('%')->default(0),
        ])->columns(2);
    }
}
