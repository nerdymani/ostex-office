<?php
namespace App\Filament\Resources\StaffAccountResource\Pages;

use App\Filament\Resources\StaffAccountResource;
use App\Models\OnboardingChecklist;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Password;

class CreateStaffAccount extends CreateRecord
{
    protected static string $resource = StaffAccountResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;

        // Auto-create onboarding checklist
        OnboardingChecklist::create([
            'user_id'    => $record->id,
            'created_by' => auth()->id(),
        ]);

        // Send welcome email if toggle was on
        if ($this->data['send_welcome_email'] ?? false) {
            Password::sendResetLink(['email' => $record->email]);
        }
    }
}
