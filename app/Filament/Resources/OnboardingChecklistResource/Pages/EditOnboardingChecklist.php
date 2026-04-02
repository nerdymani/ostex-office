<?php
namespace App\Filament\Resources\OnboardingChecklistResource\Pages;

use App\Filament\Resources\OnboardingChecklistResource;
use Filament\Resources\Pages\EditRecord;

class EditOnboardingChecklist extends EditRecord
{
    protected static string $resource = OnboardingChecklistResource::class;

    protected function afterSave(): void
    {
        $r = $this->record->fresh();
        if ($r->completionCount() === 6 && ! $r->completed_at) {
            $r->update(['completed_at' => now()]);
        }
    }
}
