<?php

namespace App\Filament\Resources\TeamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomeGamesRelationManager extends RelationManager
{
    protected static string $relationship = 'homeGames';

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
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('homeTeamNumbers.score')->label('Score'),
                Tables\Columns\TextColumn::make('awayTeamNumbers.score')->label('Score OPP'),
                Tables\Columns\TextColumn::make('awayTeam.title')->label('Against'),
                Tables\Columns\TextColumn::make('scheduled_at'),
            ])
            ->filters([
                //
            ]);
    }
}
