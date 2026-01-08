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

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?int $navigationSort = 120;

    protected static ?string $navigationGroup = 'Competition';

    public static function form(Form $form): Form
    {
        return $form->columns(2)->schema([
            Forms\Components\Select::make('type')->label('Achievement')
                ->options(collect(config('achievements'))->mapWithKeys(fn ($cfg, $key) => [$key => $cfg['title'] ?? $key])->all(...))
                ->searchable()
                ->preload()
                ->required()
                ->columnSpan(2),
            Forms\Components\Select::make('event_id')
                ->relationship('event', 'title')
                ->searchable()->live()
                ->columnSpan(2)
                ->preload()
                ->required(),
            Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->columnSpan(2)
                ->required(),
            Forms\Components\Select::make('team_id')
                ->relationship('team', 'title')
                ->searchable()
                ->columnSpan(1)
                ->preload()
                ->required(),
            Forms\Components\Select::make('player_id')
                ->relationship('player', 'first_name')
                ->getOptionLabelFromRecordUsing(fn (Player $record) => "{$record->first_name} {$record->last_name}")
                ->getSearchResultsUsing(fn (string $search) => Player::query()
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->limit(50)
                    ->get()
                    ->mapWithKeys(fn (Player $p) => [$p->id => "{$p->first_name} {$p->last_name}"])
                    ->all())

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
                Tables\Columns\TextColumn::make('slug')->label('Slug')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('event.title')->label('Event')->searchable()->sortable(),

                // Config type as string (resolved via Achievement::getTitleAttribute())
                Tables\Columns\TextColumn::make('title')->label('Type')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('team.title')->label('Team')->searchable()->sortable(),

                // Player full name via computed accessor `name` on Player model
                Tables\Columns\TextColumn::make('player.name')->label('Player')->searchable(),
            ])
            ->defaultPaginationPageOption(25)
            ->paginationPageOptions([25, 50, 100])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->label('Event')
                    ->relationship('event', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('team')
                    ->label('Team')
                    ->relationship('team', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options(fn () => collect(config('achievements'))
                        ->mapWithKeys(fn ($cfg, $key) => [$key => $cfg['title'] ?? $key])->all())->searchable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
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
