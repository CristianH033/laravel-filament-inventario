<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DevicesRelationManager extends RelationManager
{
    protected static string $relationship = 'devices';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('modelo')
            ->heading(__('models.device._self_plural'))
            ->modelLabel(__('models.device._self'))
            ->pluralModelLabel(__('models.device._self_plural'))
            ->columns([
                Tables\Columns\TextColumn::make('model')
                    ->label(__('models.device.model')),
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
