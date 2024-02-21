<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatusResource\Pages;
use App\Filament\Resources\StatusResource\RelationManagers;
use App\Helpers\Colors;
use App\Models\Status;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;

class StatusResource extends Resource
{
    protected static ?string $model = Status::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'mdi-list-status';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\Select::make('color')
                    ->options(
                        // collect(Color::all())->keys()->mapWithKeys(fn ($color) => [$color => $color])
                        collect(Colors::getAllKeys())->mapWithKeys(fn ($color) => [$color => Blade::render('<x-filament::badge color="' . $color . '">' . $color . '</x-filament::badge>')])
                    )
                    ->native(false)
                    ->allowHtml()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('color')
                    ->badge()
                    ->color(fn ($record) => $record->color)
                    ->searchable(),
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
                Tables\Actions\DeleteAction::make()
                    ->before(function (Status $record, Tables\Actions\DeleteAction $action) {
                        if ($record->items()->exists()) {
                            Notification::make()
                                ->title('Cannot delete Status')
                                ->body('Status has items assigned to it')
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
            'index' => Pages\ListStatuses::route('/'),
            'create' => Pages\CreateStatus::route('/create'),
            'view' => Pages\ViewStatus::route('/{record}'),
            'edit' => Pages\EditStatus::route('/{record}/edit'),
        ];
    }
}
