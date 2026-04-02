<?php
namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-check-circle';
    protected static string|\UnitEnum|null $navigationGroup = 'My Work';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();
        if ($user && ! $user->is_admin) {
            $query->where('assigned_to', $user->id);
        }
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
            Textarea::make('description')->rows(3)->columnSpanFull(),
            Select::make('assigned_to')
                ->label('Assign To')
                ->options(User::where('is_active', true)->pluck('name', 'id'))
                ->searchable()->nullable(),
            DatePicker::make('due_date')->nullable(),
            Select::make('status')
                ->options(['todo' => 'To Do', 'in_progress' => 'In Progress', 'review' => 'Review', 'done' => 'Done'])
                ->default('todo')->required(),
            Select::make('priority')
                ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'])
                ->default('medium')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('assignee.name')->label('Assigned To')->placeholder('—'),
                TextColumn::make('due_date')->date()->sortable()->placeholder('—'),
                TextColumn::make('priority')->badge()
                    ->color(fn (string $s) => match ($s) {
                        'urgent' => 'danger',
                        'high'   => 'warning',
                        'medium' => 'primary',
                        'low'    => 'gray',
                        default  => 'gray',
                    }),
                TextColumn::make('status')->badge()
                    ->color(fn (string $s) => match ($s) {
                        'done'        => 'success',
                        'in_progress' => 'info',
                        'review'      => 'warning',
                        'todo'        => 'gray',
                        default       => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['todo' => 'To Do', 'in_progress' => 'In Progress', 'review' => 'Review', 'done' => 'Done']),
                Tables\Filters\SelectFilter::make('priority')
                    ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('priority', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit'   => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
