<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoricalResource\Pages;
use App\Models\Historical;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class HistoricalResource extends Resource
{
    protected static ?string $model = Historical::class;

    protected static ?string $navigationIcon = 'fluentui-history-20';

    protected static ?int $navigationSort = 7;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \App\Tables\Columns\ChangeLog::make('display_changes')
                    ->label(__('models.historical.display_changes'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->where('change_log->prev_state->serial', 'like', '%'.$search.'%')
                            ->Orwhere('change_log->prev_state->internal_serial', 'like', '%'.$search.'%')
                            ->Orwhere('change_log->prev_state->device', 'like', '%'.$search.'%')
                            ->Orwhere('change_log->prev_state->location', 'like', '%'.$search.'%')
                            ->Orwhere('change_log->prev_state->status', 'like', '%'.$search.'%')
                            ->Orwhere('change_log->prev_state->comments', 'like', '%'.$search.'%')
                            ->orWhere('change_log->new_state->serial', 'like', '%'.$search.'%')
                            ->Orwhere('change_log->new_state->internal_serial', 'like', '%'.$search.'%')
                            ->Orwhere('change_log->new_state->device', 'like', '%'.$search.'%')
                            ->Orwhere('change_log->new_state->location', 'like', '%'.$search.'%')
                            ->Orwhere('change_log->new_state->status', 'like', '%'.$search.'%')
                            ->Orwhere('change_log->new_state->comments', 'like', '%'.$search.'%');
                    }),
                Tables\Columns\TextColumn::make('reason')
                    ->label(__('models.historical.reason')),
                Tables\Columns\TextColumn::make('change_date')
                    ->label(__('models.historical.change_date'))
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('change_date', 'desc')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->exports([
                        ExcelExport::make('historicals')
                            ->fromTable()
                            ->withColumns([
                                Column::make('item_id'),
                                Column::make('prev_state_text'),
                                Column::make('new_state_text'),
                                Column::make('reason'),
                                Column::make('change_date'),
                            ])
                            ->only([
                                'item_id', 'prev_state_text', 'new_state_text', 'reason', 'change_date',
                            ])
                            ->askForFilename(default: 'Historico_Cambios_'.date('Ymd'), label: __('File name'))
                            ->askForWriterType(default: Excel::XLSX, label: __('File type')),
                    ]),
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
            // 'create' => Pages\CreateHistorical::route('/create'),
            // 'edit' => Pages\EditHistorical::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('models.historical._self_plural');
    }

    public static function getModelLabel(): string
    {
        return __('models.historical._self');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models.historical._self_plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('History');
    }
}
