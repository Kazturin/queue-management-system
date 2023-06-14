<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OperatorServiceResource\Pages;
//use App\Filament\Resources\OperatorServiceResource\RelationManagers;
use App\Models\OperatorService;
use App\Models\Service;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

class OperatorServiceResource extends Resource
{
    protected static ?string $model = OperatorService::class;

   // protected static ?string $title = 'Операторға қызметті тағайындау';


    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getModelLabel(): string
    {
        return __('Assignment of Service to Operator');
    }

    protected static function getNavigationLabel(): string
    {
        return __('Assignment of Service to Operator');
    }

    public static function getPluralLabel(): ?string
    {
        return static::getNavigationLabel();
    }

//    protected function getHeader()
//    {
//        return 'Операторға қызметті тағайындау';
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('operator_id')
                    ->label('Оператор')
                    ->required()
                    ->options(fn() => User::pluck('name', 'id')->toArray()),
                Forms\Components\Select::make('service_id')
                    ->label('Қызмет')
                    ->required()
                    ->options(fn() => Service::pluck('name', 'id')->toArray())
                    ->unique(callback: function (Unique $rule, callable $get) { // $get callable is used
                        return $rule
                            ->where('operator_id', $get('operator_id')) // get the current value in the 'school_id' field
                            ->where('service_id', $get('service_id'));
                    }, ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                Select::make('operator_id')
//                    ->relationship('operator', 'name'),
                Tables\Columns\TextColumn::make('operator.name')
                    ->label('Оператор')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service.name')
                ->Label(__('Service')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOperatorServices::route('/'),
        ];
    }
}
