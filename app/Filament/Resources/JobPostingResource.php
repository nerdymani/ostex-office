<?php
namespace App\Filament\Resources;

use App\Filament\Resources\JobPostingResource\Pages;
use App\Models\JobPosting;
use App\Traits\BelongsToDepartment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JobPostingResource extends Resource
{
    use BelongsToDepartment;
    const DEPARTMENT = 'HR';

    protected static ?string $model = JobPosting::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';
    protected static string|\UnitEnum|null $navigationGroup = 'Human Resources';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->maxLength(255),
            TextInput::make('department')->required(),
            Select::make('type')
                ->options(['full_time' => 'Full Time', 'part_time' => 'Part Time', 'contract' => 'Contract', 'internship' => 'Internship'])
                ->required(),
            Select::make('status')
                ->options(['draft' => 'Draft', 'open' => 'Open', 'closed' => 'Closed'])
                ->default('draft'),
            TextInput::make('salary_range')->nullable(),
            DatePicker::make('deadline')->nullable(),
            RichEditor::make('description')->required()->columnSpanFull(),
            Textarea::make('requirements')->rows(4)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('department'),
                TextColumn::make('type')->badge(),
                TextColumn::make('deadline')->date()->placeholder('—'),
                TextColumn::make('status')->badge()
                    ->color(fn ($s) => match ($s) {
                        'open'   => 'success',
                        'closed' => 'gray',
                        'draft'  => 'warning',
                        default  => 'gray',
                    }),
                TextColumn::make('applications_count')->label('Applications')
                    ->counts('applications'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListJobPostings::route('/'),
            'create' => Pages\CreateJobPosting::route('/create'),
            'edit'   => Pages\EditJobPosting::route('/{record}/edit'),
        ];
    }
}
