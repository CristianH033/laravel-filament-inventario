<?php

namespace App\Filament\Resources\ItemResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Attributes\On;

class HistoricalsRelationManager extends RelationManager
{
    protected static string $relationship = 'historicals';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('change_date')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('change_log')
            ->heading(__('models.historical._self_plural'))
            ->modelLabel(__('models.historical._self'))
            ->pluralModelLabel(__('models.historical._self_plural'))
            ->defaultSort('change_date', 'desc')
            ->columns([
                \App\Tables\Columns\ChangeLog::make('display_changes')
                    ->label(__('models.historical.display_changes')),
                Tables\Columns\TextColumn::make('reason')
                    ->label(__('models.historical.reason')),
                Tables\Columns\TextColumn::make('change_date')
                    ->label(__('models.historical.change_date')),
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

    public function isReadOnly(): bool
    {
        return true;
    }

    #[On('refreshRelationManager')]
    public function refresh(): void
    {
    }
}
