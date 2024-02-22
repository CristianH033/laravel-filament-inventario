<?php

namespace App\Filament\Resources\DeviceResource\RelationManagers;

use App\Helpers\Colors;
use App\Helpers\RenderBlade;
use App\Models\Status;
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
