<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Helpers\Colors;
use App\Models\Device;
use App\Models\Item;
use App\Models\Location;
use App\Models\Status;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'gmdi-inventory-2-o';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('device')
                    ->relationship(titleAttribute: 'model')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\Select::make('category')
                            ->relationship(titleAttribute: 'name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                            ])
                            ->required(),
                        Forms\Components\Select::make('brand')
                            ->relationship(titleAttribute: 'name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('model')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                    ])
                    ->required(),
                Forms\Components\Select::make('location')
                    ->relationship(titleAttribute: 'name')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->relationship(titleAttribute: 'name')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\Select::make('color')
                            ->options(
                                collect(Colors::getAllKeys())->mapWithKeys(
                                    fn ($color) => [$color => Blade::render('<x-filament::badge color="' . $color . '">' . $color . '</x-filament::badge>')]
                                )
                            )
                            ->native(false)
                            ->allowHtml()
                            ->required(),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('serial')
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\TextInput::make('internal_serial')
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\Textarea::make('comments')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('serial')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('internal_serial')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('device.display_name')
                    ->numeric()
                    ->sortable(query: function (Builder $query, string $direction, $column): Builder {
                        // [$table, $field] = explode('.', $column->getName());
                        [$table, $field] = ['device', 'model'];

                        return $query->withAggregate($table, $field)
                            ->orderBy(implode('_', [$table, $field]), $direction);
                    }),
                Tables\Columns\TextColumn::make('location.name')
                    ->numeric()
                    ->sortable(),
                // Tables\Columns\SelectColumn::make('location_id')
                //     ->label('Location')
                //     ->options(Location::pluck('name', 'id')->toArray())
                //     ->rules(['required', 'exists:locations,id']),
                Tables\Columns\TextColumn::make('status.name')
                    ->numeric()
                    ->badge()
                    ->color(fn (Item $item) => $item->status?->color)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('location')
                    ->multiple()
                    ->options(Location::pluck('name', 'id'))
                    ->attribute('location_id'),
                SelectFilter::make('status')
                    ->multiple()
                    ->options(Status::pluck('name', 'id'))
                    ->attribute('status_id'),
                SelectFilter::make('device')
                    ->multiple()
                    ->options(Device::with('brand')->get()->collect()->pluck('display_name', 'id'))
                    ->attribute('device_id'),
                SelectFilter::make('brand')
                    ->multiple()
                    ->preload()
                    ->relationship('device.brand', 'name'),
                SelectFilter::make('category')
                    ->multiple()
                    ->preload()
                    ->relationship('device.category', 'name'),
            ], layout: FiltersLayout::Modal)
            ->actions([
                // Tables\Actions\Action::make('edit')
                //     ->label('Edit')
                //     ->icon('heroicon-o-pencil'),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            'historicals' => RelationManagers\HistoricalsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'view' => Pages\ViewItem::route('/{record}'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }

    /**
     * Get the Eloquent query builder for the resource's corresponding model.
     *
     * @return \Illuminate\Database\Eloquent\Builder<\App\Models\Item>
     **/
    public static function getEloquentQuery(): Builder
    {
        $query = static::getModel()::query()->with([
            'device.brand',
            'device.category',
            'location',
            'status',
        ]);

        if (
            static::isScopedToTenant() &&
            ($tenant = Filament::getTenant())
        ) {
            static::scopeEloquentQueryToTenant($query, $tenant);
        }

        return $query;
    }
}
