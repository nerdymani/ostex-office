<?php
namespace App\Filament\Resources;

use App\Filament\Resources\StaffAccountResource\Pages;
use App\Models\OnboardingChecklist;
use App\Models\User;
use App\Traits\BelongsToDepartment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class StaffAccountResource extends Resource
{
    use BelongsToDepartment;
    const DEPARTMENT = 'HR';

    protected static ?string $model = User::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';
    protected static string|\UnitEnum|null $navigationGroup = 'Human Resources';
    protected static ?string $navigationLabel = 'Staff Accounts';
    protected static ?string $modelLabel = 'Staff Account';
    protected static ?int $navigationSort = 1;

    public static function canEdit($record): bool   { return auth()->user()?->is_admin || auth()->user()?->department === 'HR'; }
    public static function canCreate(): bool        { return auth()->user()?->is_admin || auth()->user()?->department === 'HR'; }
    public static function canDelete($record): bool { return auth()->user()?->is_admin || auth()->user()?->department === 'HR'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Personal Information')->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                TextInput::make('phone')->tel()->nullable(),
            ])->columns(2),

            Section::make('Employment')->schema([
                Select::make('department')
                    ->options([
                        'HR'           => 'HR',
                        'Finance'      => 'Finance',
                        'Technology'   => 'Technology',
                        'Sales'        => 'Sales',
                        'Operations'   => 'Operations',
                        'Support'      => 'Support',
                        'Social Media' => 'Social Media',
                    ])
                    ->required(),
                TextInput::make('position')->required()->maxLength(100),
                TextInput::make('employee_id')->label('Employee ID')->nullable()->unique(ignoreRecord: true),
                DatePicker::make('joined_date')->default(now()),
            ])->columns(2),

            Section::make('Account')->schema([
                TextInput::make('password')
                    ->password()
                    ->required(fn (string $operation) => $operation === 'create')
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->label(fn (string $operation) => $operation === 'create' ? 'Password' : 'New Password (leave blank to keep)'),
                Toggle::make('is_admin')->label('Grant manager access')->default(false),
                Toggle::make('is_active')->label('Account active')->default(true),
                Toggle::make('send_welcome_email')
                    ->label('Send password-reset link to staff email')
                    ->default(false)
                    ->dehydrated(false)
                    ->visible(fn (string $operation) => $operation === 'create'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('department')->badge(),
                TextColumn::make('position')->placeholder('—'),
                TextColumn::make('employee_id')->label('Emp. ID')->placeholder('—'),
                TextColumn::make('is_active')->label('Status')->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                TextColumn::make('joined_date')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department')
                    ->options([
                        'HR'           => 'HR',
                        'Finance'      => 'Finance',
                        'Technology'   => 'Technology',
                        'Sales'        => 'Sales',
                        'Operations'   => 'Operations',
                        'Support'      => 'Support',
                        'Social Media' => 'Social Media',
                    ]),
                Tables\Filters\SelectFilter::make('is_active')
                    ->options(['1' => 'Active', '0' => 'Inactive']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('deactivate')
                    ->label('Deactivate')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->visible(fn ($record) => $record->is_active)
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['is_active' => false])),
                Tables\Actions\Action::make('reactivate')
                    ->label('Reactivate')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => ! $record->is_active)
                    ->action(fn ($record) => $record->update(['is_active' => true])),
                Tables\Actions\Action::make('send_reset')
                    ->label('Send Reset Email')
                    ->icon('heroicon-o-envelope')
                    ->action(fn ($record) => Password::sendResetLink(['email' => $record->email])),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStaffAccounts::route('/'),
            'create' => Pages\CreateStaffAccount::route('/create'),
            'edit'   => Pages\EditStaffAccount::route('/{record}/edit'),
        ];
    }
}
