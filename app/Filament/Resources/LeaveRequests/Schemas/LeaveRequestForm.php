<?php

namespace App\Filament\Resources\LeaveRequests\Schemas;

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

class LeaveRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')->relationship('user','name')->required(),
            Select::make('type')->options(['annual'=>'Annual','sick'=>'Sick','maternity'=>'Maternity','paternity'=>'Paternity','unpaid'=>'Unpaid','other'=>'Other'])->required(),
            DatePicker::make('start_date')->required(),
            DatePicker::make('end_date')->required(),
            Textarea::make('reason')->required()->columnSpanFull(),
            Select::make('status')->options(['pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'])->default('pending'),
            Textarea::make('review_note')->label('Review Note'),
        ])->columns(2);
    }
}
