<?php

namespace App\Filament\Resources\Tasks\Tables;

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

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('assignee.name')->label('Assigned To'),
                TextColumn::make('department')->badge(),
                TextColumn::make('priority')->badge()->color(fn($s)=>match($s){'urgent'=>'danger','high'=>'warning','medium'=>'primary',default=>'gray'}),
                TextColumn::make('status')->badge()->color(fn($s)=>match($s){'completed'=>'success','in_progress'=>'warning','cancelled'=>'danger',default=>'gray'}),
                TextColumn::make('due_date')->date()->sortable(),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
