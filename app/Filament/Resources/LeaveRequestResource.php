<?php
namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Models\LeaveRequest;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';
    protected static string|\UnitEnum|null $navigationGroup = 'My Work';
    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user  = auth()->user();
        // HR + admin see all; staff see own
        if ($user && ! $user->is_admin && $user->department !== 'HR') {
            $query->where('user_id', $user->id);
        }
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('type')
                ->options(['Annual Leave' => 'Annual Leave', 'Sick Leave' => 'Sick Leave', 'Personal' => 'Personal', 'Other' => 'Other'])
                ->required(),
            DatePicker::make('from_date')->required()->live()
                ->afterStateUpdated(function ($state, $get, $set) {
                    if ($state && $get('to_date')) {
                        $set('days_count', \Carbon\Carbon::parse($state)->diffInDays(\Carbon\Carbon::parse($get('to_date'))) + 1);
                    }
                }),
            DatePicker::make('to_date')->required()->live()
                ->afterStateUpdated(function ($state, $get, $set) {
                    if ($state && $get('from_date')) {
                        $set('days_count', \Carbon\Carbon::parse($get('from_date'))->diffInDays(\Carbon\Carbon::parse($state)) + 1);
                    }
                }),
            TextInput::make('days_count')->label('Days')->numeric()->readOnly(),
            Textarea::make('reason')->required()->rows(3)->columnSpanFull(),
            // HR/admin only fields
            Select::make('status')
                ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                ->visible(fn () => auth()->user()?->is_admin || auth()->user()?->department === 'HR')
                ->default('pending'),
            Textarea::make('reviewer_note')
                ->label('Reviewer Note')
                ->visible(fn () => auth()->user()?->is_admin || auth()->user()?->department === 'HR')
                ->rows(2)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Staff')->searchable(),
                TextColumn::make('type'),
                TextColumn::make('from_date')->date(),
                TextColumn::make('to_date')->date(),
                TextColumn::make('days_count')->label('Days'),
                TextColumn::make('status')->badge()
                    ->color(fn (string $s) => match ($s) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending'  => 'warning',
                        default    => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'pending' && (auth()->user()?->is_admin || auth()->user()?->department === 'HR'))
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'approved', 'reviewed_by' => auth()->id(), 'reviewed_at' => now()])),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status === 'pending' && (auth()->user()?->is_admin || auth()->user()?->department === 'HR'))
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'rejected', 'reviewed_by' => auth()->id(), 'reviewed_at' => now()])),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->status === 'pending' && $record->user_id === auth()->id()),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit'   => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
