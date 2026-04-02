<?php
namespace App\Filament\Resources;

use App\Filament\Resources\OnboardingChecklistResource\Pages;
use App\Models\OnboardingChecklist;
use App\Traits\BelongsToDepartment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OnboardingChecklistResource extends Resource
{
    use BelongsToDepartment;
    const DEPARTMENT = 'HR';

    protected static ?string $model = OnboardingChecklist::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static string|\UnitEnum|null $navigationGroup = 'Human Resources';
    protected static ?string $navigationLabel = 'Onboarding';
    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool { return false; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Toggle::make('contract_signed')->label('Employment contract signed'),
            Toggle::make('id_submitted')->label('ID / passport copy submitted'),
            Toggle::make('equipment_issued')->label('Equipment issued'),
            Toggle::make('email_setup')->label('Company email account created'),
            Toggle::make('system_access')->label('E-office access granted'),
            Toggle::make('orientation_done')->label('Orientation completed'),
            DatePicker::make('probation_end')->label('Probation End Date')->nullable(),
            Textarea::make('notes')->rows(3)->columnSpanFull(),
            DateTimePicker::make('completed_at')->label('Completed At')->nullable()->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Staff')->searchable(),
                TextColumn::make('user.department')->label('Department')->badge(),
                TextColumn::make('progress')->label('Progress')
                    ->getStateUsing(fn ($record) => $record->completionCount() . ' / 6'),
                TextColumn::make('probation_end')->date()->placeholder('—'),
                TextColumn::make('completed_at')->label('Status')->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Complete' : 'Pending')
                    ->color(fn ($state) => $state ? 'success' : 'warning'),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOnboardingChecklists::route('/'),
            'edit'  => Pages\EditOnboardingChecklist::route('/{record}/edit'),
        ];
    }
}
