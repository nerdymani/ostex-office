<?php
namespace App\Filament\Resources;

use App\Filament\Resources\JobApplicationResource\Pages;
use App\Models\JobApplication;
use App\Traits\BelongsToDepartment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobApplicationResource extends Resource
{
    use BelongsToDepartment;
    const DEPARTMENT = 'HR';

    protected static ?string $model = JobApplication::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-plus';
    protected static string|\UnitEnum|null $navigationGroup = 'Human Resources';
    protected static ?int $navigationSort = 4;

    public static function canCreate(): bool { return false; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('status')
                ->options([
                    'new'         => 'New',
                    'reviewing'   => 'Reviewing',
                    'shortlisted' => 'Shortlisted',
                    'interviewed' => 'Interviewed',
                    'offered'     => 'Offered',
                    'rejected'    => 'Rejected',
                ])
                ->required(),
            Textarea::make('notes')->rows(3)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('applicant_name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('posting.title')->label('Position'),
                TextColumn::make('status')->badge()
                    ->color(fn ($s) => match ($s) {
                        'offered'     => 'success',
                        'rejected'    => 'danger',
                        'shortlisted' => 'info',
                        'new'         => 'gray',
                        default       => 'warning',
                    }),
                TextColumn::make('created_at')->date()->label('Applied'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new'         => 'New',
                        'reviewing'   => 'Reviewing',
                        'shortlisted' => 'Shortlisted',
                        'interviewed' => 'Interviewed',
                        'offered'     => 'Offered',
                        'rejected'    => 'Rejected',
                    ]),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobApplications::route('/'),
            'edit'  => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
}
