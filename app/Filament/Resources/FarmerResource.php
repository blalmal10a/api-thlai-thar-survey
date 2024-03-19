<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FarmerResource\Pages;
use App\Forms\Components\LatLong;
use App\Models\Farmer;
use App\Models\Vegetable;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
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
        $year = date('Y');
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone'),
                Grid::make([])
                    ->schema([
                        TextInput::make('house_no'),
                        TextInput::make('locality'),
                        Hidden::make('district_id')
                            ->default(function () {
                                return request()->user()->district_id ?? 1;
                            }),
                        LatLong::make('latlong'),

                        Select::make('district_id')
                            ->hidden()
                            ->default(function () {
                                return request()->user()->district_id ?? 1;
                            })
                            ->default(fn () => auth()->user()->district_id)
                            ->relationship('district', 'name'),
                    ])->columns(2),

                Repeater::make('Thlai thar')
                    ->columnSpanFull()
                    ->relationship('thlai_thars')
                    ->label('Thlai thar')
                    ->schema([
                        Fieldset::make('Thlai hming')
                            ->schema([
                                Select::make('vegetable_id')
                                    ->relationship('vegetable', 'name')
                                    ->required()
                                    ->distinct()
                                    ->label(''),

                                Select::make('district_id')
                                    ->default(function () {
                                        return request()->user()->district_id ?? 1;
                                    })
                                    ->relationship('district', 'name')
                                    ->required()
                                    ->label(''),
                            ]),
                        Fieldset::make(($year - 1) . ' thlai thar report')
                            ->schema([
                                TextInput::make('thar_zat')
                                    ->prefix('Quintal')
                                    ->numeric(),
                                TextInput::make('zau_zawng')
                                    ->label('Thlai chinna hmun zau zawng')
                                    ->prefix('Ṭin')
                                    ->numeric(),

                                TextInput::make('a_hring_rate')
                                    ->suffix('per Kg')
                                    ->numeric()
                                    ->requiredIf('a_ro_rate', null),
                                TextInput::make('a_hring_hralh_zat')
                                    ->prefix('Quintal')
                                    ->numeric(),


                                TextInput::make('a_ro_rate')
                                    ->suffix('per Kg')
                                    ->numeric()
                                    ->requiredIf('a_hring_rate', null),
                                TextInput::make('a_ro_hralh_zat')
                                    ->prefix('Quintal')
                                    ->numeric(),
                                TextInput::make('hluihlawn_zat')
                                    ->prefix('Quintal')
                                    ->numeric(),
                            ])
                            ->columns(2),

                        Fieldset::make($year .  ' thlir lawkna')
                            ->schema([
                                TextInput::make('thar_zat_beisei')
                                    ->label('Thar inbeisei zat')
                                    ->prefix('Quintal')
                                    ->numeric(),
                                TextInput::make('zau_zawng_beisei')
                                    ->label('Thlai chinna hmun zau zawng')
                                    ->prefix('Ṭin')
                                    ->numeric(),
                            ])
                            ->columns(2)

                    ])
                    ->itemLabel(function ($state) {
                        $veg = Vegetable::find($state['vegetable_id']);
                        return $veg ? $veg->name : '';
                    })
                    ->reactive()
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
            // AuditsRelationManager::class
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
