<?php

namespace App\Filament\Resources\BudgetRequests\Schemas;

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

class BudgetRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->columnSpanFull(),
            Textarea::make('description')->required()->columnSpanFull(),
            Select::make('department')->options(['HR'=>'HR','Finance'=>'Finance','Technology'=>'Technology','Sales'=>'Sales','Operations'=>'Operations','Support'=>'Support','Social Media'=>'Social Media'])->required(),
            TextInput::make('requested_amount')->numeric()->prefix('USD')->required(),
            TextInput::make('approved_amount')->numeric()->prefix('USD'),
            Select::make('status')->options(['pending'=>'Pending','under_review'=>'Under Review','approved'=>'Approved','partially_approved'=>'Partially Approved','rejected'=>'Rejected'])->default('pending'),
            Textarea::make('review_note')->columnSpanFull(),
            Hidden::make('requested_by')->default(fn()=>auth()->id()),
        ])->columns(2);
    }
}
