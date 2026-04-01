<?php

namespace App\Filament\Resources\Leads\Schemas;

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

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('company'),
            TextInput::make('email')->email(),
            TextInput::make('phone'),
            Select::make('source')->options(['website'=>'Website','referral'=>'Referral','social'=>'Social Media','cold'=>'Cold Call','event'=>'Event','other'=>'Other']),
            TextInput::make('service_interest'),
            Select::make('status')->options(['new'=>'New','contacted'=>'Contacted','qualified'=>'Qualified','proposal'=>'Proposal','negotiation'=>'Negotiation','won'=>'Won','lost'=>'Lost'])->default('new'),
            TextInput::make('estimated_value')->numeric()->prefix('USD'),
            Select::make('assigned_to')->relationship('assignee','name'),
            Textarea::make('notes')->columnSpanFull(),
        ])->columns(2);
    }
}
