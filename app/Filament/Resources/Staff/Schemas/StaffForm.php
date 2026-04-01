<?php

namespace App\Filament\Resources\Staff\Schemas;

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

class StaffForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')->relationship('user','name')->required(),
            TextInput::make('employee_id')->required()->unique(ignoreRecord:true),
            Select::make('department')->options(['HR'=>'HR','Finance'=>'Finance','Technology'=>'Technology','Sales'=>'Sales','Operations'=>'Operations','Support'=>'Support','Social Media'=>'Social Media'])->required(),
            TextInput::make('job_title')->required(),
            TextInput::make('phone'),
            DatePicker::make('date_hired')->required(),
            Select::make('status')->options(['active'=>'Active','inactive'=>'Inactive','on_leave'=>'On Leave'])->default('active'),
        ])->columns(2);
    }
}
