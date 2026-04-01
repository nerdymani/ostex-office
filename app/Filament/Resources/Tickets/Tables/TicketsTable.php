<?php

namespace App\Filament\Resources\Tickets\Tables;

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

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')->searchable(),
                TextColumn::make('subject')->searchable()->limit(40),
                TextColumn::make('requester_name')->label('Requester'),
                TextColumn::make('priority')->badge()->color(fn($s)=>match($s){'critical'=>'danger','high'=>'warning','medium'=>'primary',default=>'gray'}),
                TextColumn::make('status')->badge()->color(fn($s)=>match($s){'resolved'=>'success','closed'=>'gray','in_progress'=>'warning',default=>'primary'}),
                TextColumn::make('assignee.name')->label('Assigned To'),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
