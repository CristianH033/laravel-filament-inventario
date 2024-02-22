<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'tabler-device-heart-monitor';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label(__('models.category._self'))
                    ->exists()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label(__('models.category.name'))
                            ->required(),
                    ])
                    ->required(),
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->label(__('models.brand._self'))
                    ->exists()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label(__('models.brand.name'))
                            ->required(),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('model')
                    ->label(__('models.device.model'))
                    ->columnSpanFull()
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label(__('models.device.description'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('models.category._self'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label(__('models.brand._self'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model')
                    ->label(__('models.device.model'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('models.device.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('models.device.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Device $record, Tables\Actions\DeleteAction $action) {
                        if ($record->items()->exists()) {
                            Notification::make()
                                ->title('Cannot delete Device')
                                ->body('Device has items assigned to it')
                                ->status('danger')
                                ->send();

                            $action->cancel();

                            return;
                        }

                        return $action;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            'items' => RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'view' => Pages\ViewDevice::route('/{record}'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('models.device._self_plural');
    }

    public static function getModelLabel(): string
    {
        return __('models.device._self');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models.device._self_plural');
    }
}
