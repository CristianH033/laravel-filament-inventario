<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Helpers\Colors;
use App\Helpers\RenderBlade;
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
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'gmdi-inventory-2-o';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('device_id')
                    ->relationship('device', 'model')
                    ->label(__('models.device._self'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->exists('devices', 'id')
                    ->createOptionForm([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->label(__('models.category._self'))
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('models.category.name'))
                                    ->required(),
                            ])
                            ->required(),
                        Forms\Components\Select::make('brand_id')
                            ->relationship('brand', 'name')
                            ->label(__('models.brand._self'))
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('models.brand.name'))
                                    ->required(),
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('model')
                            ->label(__('models.device.model'))
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('models.device.description'))
                            ->columnSpanFull(),
                    ])
                    ->required(),
                Forms\Components\Select::make('owner_id')
                    ->relationship('owner', 'name')
                    ->label(__('models.item.owned_by'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label(__('models.location.name'))
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('models.location.description'))
                            ->columnSpanFull(),
                    ])
                    ->required(),
                Forms\Components\Select::make('location_id')
                    ->relationship('location', 'name')
                    ->label(__('models.location._self'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label(__('models.location.name'))
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('models.location.description'))
                            ->columnSpanFull(),
                    ])
                    ->required(),
                Forms\Components\Select::make('status_id')
                    ->relationship('status', 'name')
                    ->label(__('models.status._self'))
                    ->allowHtml(true)
                    ->options(
                        Status::all()->mapWithKeys(
                            fn ($status) => [$status->id => RenderBlade::badge($status->color, $status->name)]
                        )
                    )
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label(__('models.status.name'))
                            ->required(),
                        Forms\Components\Select::make('color')
                            ->label(__('models.status.color'))
                            ->options(
                                collect(Colors::getAllKeys())->mapWithKeys(
                                    fn ($color) => [$color => RenderBlade::badge($color, $color)]
                                )
                            )
                            ->native(false)
                            ->allowHtml()
                            ->required(),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('serial')
                    ->label(__('models.item.serial'))
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\TextInput::make('internal_serial')
                    ->label(__('models.item.internal_serial'))
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\Textarea::make('comments')
                    ->label(__('models.item.comments'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('models.item.id'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('serial')
                    ->label(__('models.item.serial'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('internal_serial')
                    ->label(__('models.item.internal_serial'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('device.display_name')
                    ->label(__('models.device.display_name'))
                    ->numeric()
                    ->sortable(query: function (Builder $query, string $direction, $column): Builder {
                        // [$table, $field] = explode('.', $column->getName());
                        [$table, $field] = ['device', 'model'];

                        return $query->withAggregate($table, $field)
                            ->orderBy(implode('_', [$table, $field]), $direction);
                    }),
                Tables\Columns\TextColumn::make('owner.name')
                    ->label(__('models.item.owned_by'))
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->label(__('models.location._self'))
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\SelectColumn::make('location_id')
                //     ->label('Location')
                //     ->options(Location::pluck('name', 'id')->toArray())
                //     ->rules(['required', 'exists:locations,id']),
                Tables\Columns\TextColumn::make('status.name')
                    ->label(__('models.status._self'))
                    ->numeric()
                    ->badge()
                    ->color(fn (Item $item) => $item->status?->color)
                    ->sortable(),
                Tables\Columns\TextColumn::make('comments')
                    ->label(__('models.item.comments'))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('models.item.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('models.item.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('owner')
                    ->label(__('models.item.owned_by'))
                    ->multiple()
                    ->options(Location::pluck('name', 'id'))
                    ->attribute('owner_id'),
                SelectFilter::make('location')
                    ->label(__('models.location._self'))
                    ->multiple()
                    ->options(Location::pluck('name', 'id'))
                    ->attribute('location_id'),
                SelectFilter::make('status')
                    ->label(__('models.status._self'))
                    ->multiple()
                    ->options(Status::pluck('name', 'id'))
                    ->attribute('status_id'),
                SelectFilter::make('device')
                    ->label(__('models.device._self'))
                    ->multiple()
                    ->options(Device::with('brand')->get()->collect()->pluck('display_name', 'id'))
                    ->attribute('device_id'),
                SelectFilter::make('brand')
                    ->label(__('models.brand._self'))
                    ->multiple()
                    ->preload()
                    ->relationship('device.brand', 'name'),
                SelectFilter::make('category')
                    ->label(__('models.category._self'))
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
                    // Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->exports([
                        ExcelExport::make('export')
                            ->fromTable()
                            ->askForFilename(default: 'Inventario_'.date('Y_m_d'), label: __('File name'))
                            ->askForWriterType(default: Excel::XLSX, label: __('File type')),
                    ]),
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

    public static function getNavigationLabel(): string
    {
        return __('models.item._self_plural');
    }

    public static function getModelLabel(): string
    {
        return __('models.item._self');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models.item._self_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Inventory');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
