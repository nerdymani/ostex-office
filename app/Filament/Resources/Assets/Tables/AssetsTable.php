<?php

namespace App\Filament\Resources\Assets\Tables;

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
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_tag')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('category')->badge(),
                TextColumn::make('condition')->badge()->color(fn($s)=>match($s){'excellent'=>'success','good'=>'primary','fair'=>'warning','poor'=>'danger',default=>'gray'}),
                TextColumn::make('location'),
                TextColumn::make('assignee.name')->label('Assigned To'),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
