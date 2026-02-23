<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 110;

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('orderItems.product.title'),
                Tables\Columns\TextColumn::make('orderItems.quantity')->label('Qty'),
                Tables\Columns\TextColumn::make('orderItems.variation')->label('Size'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                SelectFilter::make('year')
                    ->options(function (): array {
                        $years = Order::query()
                            ->selectRaw('YEAR(created_at) as year')
                            ->distinct()
                            ->pluck('year')
                            ->all();

                        $years[] = now()->year;

                        return collect($years)
                            ->filter()
                            ->unique()
                            ->sortDesc()
                            ->mapWithKeys(fn (int $year): array => [$year => $year])
                            ->all();
                    })
                    ->default(now()->year)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] ?? null,
                            fn (Builder $query, string $value): Builder => $query->whereYear('created_at', $value)
                        );
                    })
                    ->label('Year'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Action::make('export')
                    ->url('/orders/export')
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
