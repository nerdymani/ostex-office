<?php

namespace App\Filament\Resources\Tickets\Schemas;

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

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('ticket_number')->required()->unique(ignoreRecord:true)->default('TKT-'.date('Ymd').'-'.rand(100,999)),
            TextInput::make('subject')->required()->columnSpanFull(),
            Textarea::make('description')->required()->columnSpanFull(),
            TextInput::make('requester_name')->required(),
            TextInput::make('requester_email')->email()->required(),
            Select::make('priority')->options(['low'=>'Low','medium'=>'Medium','high'=>'High','critical'=>'Critical'])->default('medium'),
            Select::make('status')->options(['open'=>'Open','in_progress'=>'In Progress','resolved'=>'Resolved','closed'=>'Closed'])->default('open'),
            TextInput::make('category')->default('general'),
            Select::make('assigned_to')->relationship('assignee','name'),
        ])->columns(2);
    }
}
