<?php
namespace App\Filament\Resources\BudgetRequests\Pages;
use App\Filament\Resources\BudgetRequests\BudgetRequestResource;
use Filament\Resources\Pages\CreateRecord;
class CreateBudgetRequest extends CreateRecord {
    protected static string $resource = BudgetRequestResource::class;
}