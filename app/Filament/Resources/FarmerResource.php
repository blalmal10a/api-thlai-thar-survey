<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FarmerResource\Pages;
use App\Models\Farmer;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class FarmerResource extends Resource
{
    protected static ?string $model = Farmer::class;
    protected static ?string $name = 'Title';
    protected static ?string $navigationLabel = 'Thlai Thar';


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone'),

                Grid::make([])
                    ->schema([
                        TextInput::make('house_no'),
                        TextInput::make('locality'),
                        Select::make('district_id')
                            ->default(fn () => auth()->user()->district_id)
                            ->relationship('district', 'name'),
                    ])->columns(2),

                Repeater::make('Thlai thar')
                    ->columnSpanFull()
                    ->relationship('thlai_thars')
                    ->schema([

                        Grid::make(2)
                            ->schema([
                                Select::make('vegetable_id')
                                    ->relationship('vegetable', 'name')
                                    ->required()
                                    ->distinct()

                                    ->placeholder('Thlai hming'),
                                Select::make('district_id')
                                    ->disabled()
                                    ->default(fn () => auth()->user()->district_id)
                                    ->relationship('district', 'name'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('thar_zat')
                                    ->numeric(),
                                Select::make('thar_zat_unit_id')
                                    ->default(1)
                                    ->relationship('thar_zat_unit', 'name')
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('beisei_zat')
                                    ->numeric(),
                                Select::make('beisei_zat_unit_id')
                                    ->default(1)
                                    ->relationship('beisei_zat_unit', 'name')
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('house_no')
                    ->searchable(),
                TextColumn::make('ip')
                    ->searchable(),
                TextColumn::make('district.name')
                    ->sortable(),
                TextColumn::make('village_council.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFarmers::route('/'),
            'create' => Pages\CreateFarmer::route('/create'),
            'edit' => Pages\EditFarmer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
