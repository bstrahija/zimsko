<?php

namespace App\Filament\Resources\RoundResource\RelationManagers;

use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GamesRelationManager extends RelationManager
{
    protected static string $relationship = 'games';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated([25, 50, 100])
            ->defaultSort('scheduled_at', 'desc')
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('home_score')
                    ->label('Score')
                    ->formatStateUsing(function ($state, Game $game) {
                        return $game->home_score . ':' . $game->away_score;
                    })
                    ->label('Home'),
                Tables\Columns\TextColumn::make('scheduled_at'),
            ])
            ->filters([
                //
            ]);
    }
}
