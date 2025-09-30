<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementResource\Pages;
use App\Models\Achievement;
use App\Models\Player;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

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
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->last_name}")
                    ->getSearchResultsUsing(fn (string $search) => Player::where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")->limit(50)->pluck('first_name', 'id'))

                    ->searchable()

                    ->columnSpan(1)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (EloquentBuilder $query) => $query->with(['event', 'team', 'player']))
            ->columns([
                Tables\Columns\TextColumn::make('event.title')
                    ->label('Event')
                    ->searchable()
                    ->sortable(),

                // Config type as string (resolved via Achievement::getTitleAttribute())
                Tables\Columns\TextColumn::make('title')
                    ->label('Type')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('team.title')
                    ->label('Team')
                    ->searchable()
                    ->sortable(),

                // Player full name via computed accessor `name` on Player model
                Tables\Columns\TextColumn::make('player.name')
                    ->label('Player')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->label('Event')
                    ->relationship('event', 'title')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options(fn () => collect(config('achievements'))
                        ->mapWithKeys(fn ($cfg, $key) => [$key => $cfg['title'] ?? $key])
                        ->all())
                    ->searchable(),
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
            'index'  => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            'edit'   => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
