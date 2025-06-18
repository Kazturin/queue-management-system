<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
//use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Models\Contracts\FilamentUser;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource implements FilamentUser
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getModelLabel(): string
    {
        return __('User');
    }

    protected static function getNavigationLabel(): string
    {
        return __('Users');
    }

    public static function getPluralLabel(): ?string
    {
        return static::getNavigationLabel();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Fullname'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('login')
                    ->alphaDash()
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->minLength('8')
                    ->dehydrateStateUsing(fn($state)=>bcrypt($state)),
                Forms\Components\TextInput::make('number')
                    ->label(__('Number'))
                    ->required()
                    ->unique(ignorable: fn ($record) => $record),
                Forms\Components\CheckboxList::make('roles')
                    ->label(__('Roles'))
                    ->columns(3)
                    ->relationship('roles','name', function ($query) {
                        return  $query->when(!auth()->user()->hasRole('Admin'), function ($query) {
                            $query->where('name', '!=', 'Admin');
                        });
                    }),
//                Forms\Components\Select::make('roles')
//                ->multiple()
//                ->relationship('roles','name', function ($query) {
//                    return $query->where('name', '!=','Admin');
//                })->preload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Fullname')),
                Tables\Columns\TextColumn::make('login')
                    ->label('Логин'),
                Tables\Columns\TagsColumn::make('roles.name')
                    ->label(__('Roles'))
                    ->limit(2),
                Tables\Columns\TextColumn::make('number')
                    ->label(__('Number')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record): bool => !$record->hasRole('Admin')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record): bool => !$record->hasRole('Admin')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public function canAccessFilament(): bool
    {
        return true;
    }
}
