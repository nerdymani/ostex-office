<?php

namespace App\Filament\Resources\Expenses\Schemas;

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

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required(),
            TextInput::make('amount')->numeric()->prefix('USD')->required(),
            Select::make('category')->options(['travel'=>'Travel','equipment'=>'Equipment','software'=>'Software','office'=>'Office Supplies','utilities'=>'Utilities','other'=>'Other'])->required(),
            DatePicker::make('expense_date')->required(),
            FileUpload::make('receipt_path')->disk('public')->directory('receipts')->label('Receipt'),
            Select::make('status')->options(['pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'])->default('pending'),
            Textarea::make('notes')->columnSpanFull(),
            Hidden::make('submitted_by')->default(fn()=>auth()->id()),
        ])->columns(2);
    }
}
