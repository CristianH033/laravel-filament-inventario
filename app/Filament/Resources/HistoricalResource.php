<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoricalResource\Pages;
use App\Models\Historical;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HistoricalResource extends Resource
{
    protected static ?string $model = Historical::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('item_id')
                    ->relationship('item', 'id')
                    ->required(),
                Forms\Components\Textarea::make('change_log')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('change_date')
                    ->required(),
                Forms\Components\Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('change_date')
                    ->dateTime()
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistoricals::route('/'),
            'create' => Pages\CreateHistorical::route('/create'),
            'view' => Pages\ViewHistorical::route('/{record}'),
            'edit' => Pages\EditHistorical::route('/{record}/edit'),
        ];
    }
}
