<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';

    protected static ?int $navigationSort = 30;

    protected static ?string $navigationGroup = 'Competition';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('external_id')
                    ->numeric(),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'title')
                    ->required(),
                Forms\Components\Select::make('round_id')
                    ->relationship('round', 'title'),
                Forms\Components\TextInput::make('slug'),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\Textarea::make('body')
                    ->columnSpanFull(),
                Forms\Components\Select::make('home_team_id')
                    ->relationship('homeTeam', 'title')
                    ->required(),
                Forms\Components\Select::make('away_team_id')
                    ->relationship('awayTeam', 'title')
                    ->required(),
                Forms\Components\TextInput::make('home_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('away_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('home_score_q1')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('away_score_q1')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('home_score_q2')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('away_score_q2')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('home_score_q3')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('away_score_q3')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('home_score_q4')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('away_score_q4')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('home_score_ot1')
                    ->numeric(),
                Forms\Components\TextInput::make('away_score_ot1')
                    ->numeric(),
                Forms\Components\TextInput::make('home_score_ot2')
                    ->numeric(),
                Forms\Components\TextInput::make('away_score_ot2')
                    ->numeric(),
                Forms\Components\TextInput::make('home_score_ot3')
                    ->numeric(),
                Forms\Components\TextInput::make('away_score_ot3')
                    ->numeric(),
                Forms\Components\TextInput::make('home_score_ot4')
                    ->numeric(),
                Forms\Components\TextInput::make('away_score_ot4')
                    ->numeric(),
                Forms\Components\TextInput::make('status'),
                Forms\Components\Textarea::make('data')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('type')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('external_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('round.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('homeTeam.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('awayTeam.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('home_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('away_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('home_score_q1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('away_score_q1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('home_score_q2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('away_score_q2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('home_score_q3')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('away_score_q3')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('home_score_q4')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('away_score_q4')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('home_score_ot1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('away_score_ot1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('home_score_ot2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('away_score_ot2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('home_score_ot3')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('away_score_ot3')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('home_score_ot4')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('away_score_ot4')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
