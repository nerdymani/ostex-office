<?php
namespace App\Filament\Resources\BudgetRequests\Pages;
use App\Filament\Resources\BudgetRequests\BudgetRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
class ListBudgetRequests extends ListRecords {
    protected static string $resource = BudgetRequestResource::class;
    protected function getHeaderActions(): array { return [CreateAction::make()]; }
}