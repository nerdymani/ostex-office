<?php
namespace App\Filament\Resources\BudgetRequests\Pages;
use App\Filament\Resources\BudgetRequests\BudgetRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
class EditBudgetRequest extends EditRecord {
    protected static string $resource = BudgetRequestResource::class;
    protected function getHeaderActions(): array { return [DeleteAction::make()]; }
}