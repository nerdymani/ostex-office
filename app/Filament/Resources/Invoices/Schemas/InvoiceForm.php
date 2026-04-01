<?php

namespace App\Filament\Resources\Invoices\Schemas;

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

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('invoice_number')->required()->unique(ignoreRecord:true)->default('INV-'.date('Ymd').'-'.rand(100,999)),
            TextInput::make('client_name')->required(),
            TextInput::make('client_email')->email(),
            TextInput::make('amount')->numeric()->prefix('USD')->required(),
            DatePicker::make('due_date')->required(),
            Select::make('status')->options(['draft'=>'Draft','sent'=>'Sent','paid'=>'Paid','overdue'=>'Overdue','cancelled'=>'Cancelled'])->default('draft'),
            Textarea::make('notes')->columnSpanFull(),
            Hidden::make('created_by')->default(fn()=>auth()->id()),
        ])->columns(2);
    }
}
