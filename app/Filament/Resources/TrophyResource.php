<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrophyResource\Pages;
use App\Filament\Resources\TrophyResource\RelationManagers;
use App\Models\Player;
use App\Models\Trophy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrophyResource extends Resource
{
    protected static ?string $model = Trophy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'title')
                    ->searchable()
                    ->live()
                    ->columnSpan(2)
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('team_id')
                    ->relationship('team', 'title')
                    ->searchable()
                    ->columnSpan(1)
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('player_id')
                    ->relationship('player', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->first_name} {$record->last_name}")
                    ->getSearchResultsUsing(fn(string $search) => Player::where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id'))

                    ->searchable()


                    ->columnSpan(1)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListTrophies::route('/'),
            'create' => Pages\CreateTrophy::route('/create'),
            'edit' => Pages\EditTrophy::route('/{record}/edit'),
        ];
    }
}
