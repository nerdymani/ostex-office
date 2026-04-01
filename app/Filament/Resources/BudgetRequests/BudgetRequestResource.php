<?php

namespace App\Filament\Resources\BudgetRequests;

use App\Filament\Resources\BudgetRequests\Pages\CreateBudgetRequest;
use App\Filament\Resources\BudgetRequests\Pages\EditBudgetRequest;
use App\Filament\Resources\BudgetRequests\Pages\ListBudgetRequests;
use App\Filament\Resources\BudgetRequests\Schemas\BudgetRequestForm;
use App\Filament\Resources\BudgetRequests\Tables\BudgetRequestsTable;
use App\Models\BudgetRequest;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BudgetRequestResource extends Resource
{
    protected static ?string $model = BudgetRequest::class;

    protected static string|\BackedEnum|null $navigationIcon = "heroicon-o-banknotes";

    protected static string|\UnitEnum|null $navigationGroup = 'Finance';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return BudgetRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BudgetRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBudgetRequests::route('/'),
            'create' => CreateBudgetRequest::route('/create'),
            'edit' => EditBudgetRequest::route('/{record}/edit'),
        ];
    }
}
