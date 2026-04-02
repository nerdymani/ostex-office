<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PerformanceReviewResource\Pages;
use App\Models\PerformanceReview;
use App\Models\User;
use App\Traits\BelongsToDepartment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PerformanceReviewResource extends Resource
{
    use BelongsToDepartment;
    const DEPARTMENT = 'HR';

    protected static ?string $model = PerformanceReview::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-star';
    protected static string|\UnitEnum|null $navigationGroup = 'Human Resources';
    protected static ?int $navigationSort = 5;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();
        if ($user && ! $user->is_admin && $user->department !== 'HR') {
            $query->where('staff_id', $user->id);
        }
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('staff_id')->label('Staff Member')
                ->options(User::where('is_active', true)->pluck('name', 'id'))
                ->searchable()->required(),
            TextInput::make('period')->required()->placeholder('e.g. Q1 2025'),
            Select::make('score')->label('Score (1-5)')
                ->options([
                    1 => '1 - Poor',
                    2 => '2 - Below Average',
                    3 => '3 - Average',
                    4 => '4 - Good',
                    5 => '5 - Excellent',
                ])
                ->nullable(),
            Select::make('status')
                ->options(['draft' => 'Draft', 'submitted' => 'Submitted', 'acknowledged' => 'Acknowledged'])
                ->default('draft'),
            Textarea::make('strengths')->rows(3)->columnSpanFull(),
            Textarea::make('improvements')->label('Areas for Improvement')->rows(3)->columnSpanFull(),
            Textarea::make('goals')->rows(3)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('staff.name')->label('Staff')->searchable(),
                TextColumn::make('reviewer.name')->label('Reviewer'),
                TextColumn::make('period'),
                TextColumn::make('score')
                    ->formatStateUsing(fn ($s) => $s ? str_repeat('★', $s) . str_repeat('☆', 5 - $s) : '—'),
                TextColumn::make('status')->badge()
                    ->color(fn ($s) => match ($s) {
                        'acknowledged' => 'success',
                        'submitted'    => 'info',
                        'draft'        => 'gray',
                        default        => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPerformanceReviews::route('/'),
            'create' => Pages\CreatePerformanceReview::route('/create'),
            'edit'   => Pages\EditPerformanceReview::route('/{record}/edit'),
        ];
    }
}
