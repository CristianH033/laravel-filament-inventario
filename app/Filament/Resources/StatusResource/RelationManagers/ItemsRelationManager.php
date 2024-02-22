<?php

namespace App\Filament\Resources\StatusResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('serial')
            ->heading(__('models.item._self_plural'))
            ->modelLabel(__('models.item._self'))
            ->pluralModelLabel(__('models.item._self_plural'))
            ->columns([
                Tables\Columns\TextColumn::make('serial')
                    ->label(__('models.item.serial')),
                Tables\Columns\TextColumn::make('internal_serial')
                    ->label(__('models.item.internal_serial')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
