<?php
namespace App\Filament\Resources;

use App\Filament\Resources\StaffScheduleResource\Pages;
use App\Models\StaffSchedule;
use App\Models\User;
use App\Traits\BelongsToDepartment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StaffScheduleResource extends Resource
{
    use BelongsToDepartment;
    const DEPARTMENT = 'HR';

    protected static ?string $model = StaffSchedule::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';
    protected static string|\UnitEnum|null $navigationGroup = 'Human Resources';
    protected static ?string $navigationLabel = 'Staff Schedules';
    protected static ?int $navigationSort = 6;

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && ($user->is_admin || in_array($user->department, ['HR', 'Technology']));
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();
        if ($user && ! $user->is_admin && $user->department !== 'HR') {
            $query->where('department', $user->department);
        }
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')->label('Staff')
                ->options(User::where('is_active', true)->pluck('name', 'id'))
                ->searchable()->required()->live()
                ->afterStateUpdated(function ($state, $set) {
                    if ($state) {
                        $dept = User::find($state)?->department;
                        $set('department', $dept);
                    }
                }),
            TextInput::make('department')->readOnly(),
            DatePicker::make('date')->required(),
            Select::make('type')
                ->options(['work' => 'Work', 'off' => 'Off', 'holiday' => 'Holiday', 'remote' => 'Remote'])
                ->default('work')->required(),
            TimePicker::make('shift_start')->nullable(),
            TimePicker::make('shift_end')->nullable(),
            TextInput::make('notes')->nullable()->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Staff')->searchable(),
                TextColumn::make('department')->badge(),
                TextColumn::make('date')->date()->sortable(),
                TextColumn::make('shift_start')->time('H:i')->placeholder('—'),
                TextColumn::make('shift_end')->time('H:i')->placeholder('—'),
                TextColumn::make('type')->badge()
                    ->color(fn ($s) => match ($s) {
                        'work'    => 'success',
                        'remote'  => 'info',
                        'off'     => 'gray',
                        'holiday' => 'warning',
                        default   => 'gray',
                    }),
            ])
            ->defaultSort('date', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStaffSchedules::route('/'),
            'create' => Pages\CreateStaffSchedule::route('/create'),
            'edit'   => Pages\EditStaffSchedule::route('/{record}/edit'),
        ];
    }
}
