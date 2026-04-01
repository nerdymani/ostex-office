<?php

namespace App\Filament\Resources\Tasks\Schemas;

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

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->columnSpanFull(),
            Textarea::make('description')->columnSpanFull(),
            Select::make('assigned_to')->relationship('assignee','name')->required(),
            Hidden::make('assigned_by')->default(fn()=>auth()->id()),
            Select::make('department')->options(['HR'=>'HR','Finance'=>'Finance','Technology'=>'Technology','Sales'=>'Sales','Operations'=>'Operations','Support'=>'Support','Social Media'=>'Social Media'])->required(),
            Select::make('priority')->options(['low'=>'Low','medium'=>'Medium','high'=>'High','urgent'=>'Urgent'])->default('medium'),
            Select::make('status')->options(['pending'=>'Pending','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled'])->default('pending'),
            DatePicker::make('due_date'),
        ])->columns(2);
    }
}
