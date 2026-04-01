<?php

namespace App\Filament\Resources\Campaigns\Schemas;

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

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->columnSpanFull(),
            Textarea::make('description')->columnSpanFull(),
            Select::make('platform')->options(['facebook'=>'Facebook','instagram'=>'Instagram','twitter'=>'Twitter/X','linkedin'=>'LinkedIn','all'=>'All Platforms'])->required(),
            DatePicker::make('start_date')->required(),
            DatePicker::make('end_date'),
            TextInput::make('budget')->numeric()->prefix('USD'),
            Select::make('status')->options(['draft'=>'Draft','scheduled'=>'Scheduled','active'=>'Active','paused'=>'Paused','completed'=>'Completed'])->default('draft'),
            TextInput::make('reach')->numeric()->default(0),
            TextInput::make('engagement')->numeric()->default(0),
            Hidden::make('created_by')->default(fn()=>auth()->id()),
        ])->columns(2);
    }
}
