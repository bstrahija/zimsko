<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers;
use App\Models\Event;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Player;
use App\Models\Team;
use App\Validation\CheckGameScores;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Attributes\Layout;
use Livewire\Component as Livewire;

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
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('General')
                            ->icon('heroicon-o-document-text')
                            ->columns('12')
                            ->schema(self::generalSchema()),
                        Tabs\Tab::make('Score')
                            ->icon('heroicon-o-chart-bar')
                            ->columns('2')
                            ->schema(self::scoreSchema())
                            ->disabled(function (Forms\Get $get) {
                                return ! $get('id');
                            }),
                        Tabs\Tab::make('Players')
                            ->columns('2')
                            ->icon('heroicon-o-user-group')
                            ->disabled(function (Forms\Get $get) {
                                return ! $get('id');
                            })
                            ->schema([
                                self::playerRepeater('home'),
                                self::playerRepeater('away'),
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('Load players')
                                        ->label(function (Forms\Get $get) {
                                            return ! $get('id') ? 'Save as draft to enable loading players' : 'Re-load players';
                                        })
                                        ->requiresConfirmation()
                                        ->modalDescription('This action will load the players for the game and remove the current data.')
                                        ->disabled(function (Forms\Get $get) {
                                            return ! $get('id');
                                        })
                                        ->action(function (Forms\Get $get, Forms\Set $set) {
                                            self::loadPlayers($get, $set);
                                        })
                                ]),
                            ]),
                        Tabs\Tab::make('Gallery')
                            ->icon('heroicon-o-photo')
                            ->schema([]),
                    ]),



            ]);
    }

    public static function generalSchema()
    {
        // Get default event
        $defaultEvent = Event::first();

        return [
            Fieldset::make('General')
                ->columnSpan(8)
                ->schema([
                    Forms\Components\Select::make('home_team_id')
                        ->relationship('homeTeam', 'title')
                        ->searchable()
                        ->live()
                        ->columnSpan(1)
                        ->preload()
                        ->required()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::updateTitle($get, $set);
                        }),
                    Forms\Components\Select::make('away_team_id')
                        ->relationship('awayTeam', 'title')
                        ->searchable()
                        ->live()
                        ->columnSpan(1)
                        ->preload()
                        ->required()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::updateTitle($get, $set);
                        }),

                    Forms\Components\TextInput::make('title')
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\TextInput::make('slug')
                        ->hiddenOn(['create'])
                        ->required()
                        ->columnSpanFull(),
                    RichEditor::make('body')
                        ->columnSpanFull()
                        ->columnSpanFull(),
                ]),
            Fieldset::make('Meta')
                ->columnSpan(4)
                ->schema([
                    Forms\Components\Select::make('event_id')
                        ->columnSpanFull()
                        ->default($defaultEvent?->id)
                        ->relationship('event', 'title'),
                    Forms\Components\Select::make('status')
                        ->default('scheduled')
                        ->options(Game::STATUS_OPTIONS)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('type')
                        ->columnSpanFull()
                        ->options(Game::TYPE_OPTIONS)
                        ->default('regular')
                        ->required(),
                    // Forms\Components\Select::make('round_id')
                    //     ->columnSpanFull()
                    //     ->relationship('round', 'title'),
                    Forms\Components\DateTimePicker::make('scheduled_at')
                        ->columnSpanFull(),
                ]),

        ];
    }

    public static function scoreSchema()
    {
        return [
            Fieldset::make('Home Score')
                ->columnSpan(1)
                ->relationship('homeTeamNumbers')
                ->label(function (Forms\Get $get) {
                    return Team::find($get('home_team_id'))?->title ?: 'Home';
                })
                ->schema([
                    Forms\Components\TextInput::make('score')->label('Final Score')->required()->numeric()->columnSpanFull()->default(0)->rules([
                        fn(Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            $quarterScores = $get('score_p1') + $get('score_p2') + $get('score_p3') + $get('score_p4') + $get('score_p5') + $get('score_p6') + $get('score_p7') + $get('score_p8');

                            if ($quarterScores !== $value) {
                                $fail("The quarter scores do not match the total score.");
                            }
                        },
                    ]),
                    Fieldset::make('Quarters')
                        ->columns(4)
                        ->schema([
                            Forms\Components\TextInput::make('score_p1')->label('Q1')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p2')->label('Q2')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p3')->label('Q3')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p4')->label('Q4')->numeric()->default(0),
                        ]),
                    Section::make('Overtime')
                        ->columns(4)
                        ->collapsed()
                        ->schema([
                            Forms\Components\TextInput::make('score_p5')->label('OT1')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p6')->label('OT2')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p7')->label('OT3')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p8')->label('OT4')->numeric()->default(0),
                        ]),
                ]),
            Fieldset::make('Away Score')
                ->columnSpan(1)
                ->relationship('awayTeamNumbers')
                ->label(function (Forms\Get $get) {
                    return Team::find($get('away_team_id'))?->title ?: 'Away';
                })
                ->schema([
                    Forms\Components\TextInput::make('score')->label('Final Score')->required()->numeric()->columnSpanFull()->default(0)->rules([
                        fn(Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            $quarterScores = $get('score_p1') + $get('score_p2') + $get('score_p3') + $get('score_p4') + $get('score_p5') + $get('score_p6') + $get('score_p7') + $get('score_p8');

                            if ($quarterScores !== $value) {
                                $fail("The quarter scores do not match the total score.");
                            }
                        },
                    ]),
                    Fieldset::make('Quarters')
                        ->columns(4)
                        ->schema([
                            Forms\Components\TextInput::make('score_p1')->label('Q1')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p2')->label('Q2')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p3')->label('Q3')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p4')->label('Q4')->numeric()->default(0),
                        ]),
                    Section::make('Overtime')
                        ->columns(4)
                        ->collapsed()
                        ->schema([
                            Forms\Components\TextInput::make('score_p5')->label('OT1')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p6')->label('OT2')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p7')->label('OT3')->numeric()->default(0),
                            Forms\Components\TextInput::make('score_p8')->label('OT4')->numeric()->default(0),
                        ]),
                ]),

        ];
    }

    public static function playerRepeater($location = 'home')
    {
        $name         = $location . '_players';
        $relationship = $location . 'GamePlayers';
        $label        = $location . ' Team';
        $teamIdField  = $location . '_team_id';

        return Repeater::make($name)
            ->columnSpan(1)
            ->columns(6)
            ->orderColumn('score')
            ->addable(false)
            ->deletable(true)
            ->hidden(function (Forms\Get $get) use ($teamIdField) {
                return ! $get($teamIdField);
            })
            ->label(function (Forms\Get $get) use ($label, $teamIdField) {
                return Team::find($get($teamIdField))?->title ?: $label;
            })
            ->itemLabel(function ($state) {
                $record = $state && isset($state['id']) ? GamePlayer::find($state['id']) : null;
                if ($record) {
                    return $record->player->name;
                } else {
                    return 'Loading...';
                }
            })
            ->relationship($relationship)
            ->schema([
                Forms\Components\TextInput::make('score')->label('PTS')->numeric()->columnSpan(1),
                Forms\Components\TextInput::make('three_points')->label('3PT')->numeric()->columnSpan(1),
                Forms\Components\TextInput::make('assists')->label('AST')->numeric()->columnSpan(1),
                Forms\Components\TextInput::make('rebounds')->label('REB')->numeric()->columnSpan(1),
                Forms\Components\TextInput::make('blocks')->label('BLK')->numeric()->columnSpan(1),
                Forms\Components\TextInput::make('steals')->label('STL')->numeric()->columnSpan(1),
            ]);
    }

    public static function loadPlayers(Get $get, Set $set)
    {
        $gameId = $get('id');
        $game   = Game::find($gameId);

        // Get team data first
        $teams = [
            'home' => Team::find($get('home_team_id')),
            'away' => Team::find($get('away_team_id')),
        ];

        foreach ($teams as $location => $team) {
            $players = $team->players;

            if ($players->count() > 0) {
                // Generate records for each player
                foreach ($players as $player) {
                    // Check if player already exists
                    $exists = GamePlayer::where('game_id', $gameId)->where('player_id', $player->id)->first();

                    if (! $exists) {
                        GamePlayer::create([
                            'event_id'  => $game->event_id,
                            'game_id'   => $gameId,
                            'player_id' => $player->id,
                            'team_id'   => $team->id,
                        ]);
                    }
                }

                // Now re-fetch all player and create records for them
                $records = [];
                $players = $game->{$location . 'GamePlayers'};
                foreach ($players as $player) {
                    if ($player && $player->toArray()) {
                        $records['record-' . $player->id] = $player->toArray();
                    }
                }

                $set($location . '_players', $records);
            }
        }

        // $set('home_players', []);

        return true;
    }

    public static function updateTitle(Get $get, Set $set): ?string
    {
        if ($get('title')) return $get('title');

        // Try generating a title
        $homeTeam = Team::find($get('home_team_id'));
        $awayTeam = Team::find($get('away_team_id'));

        if ($homeTeam && $awayTeam) {
            $title = $homeTeam->title . ' vs ' . $awayTeam->title;
            $set('title', $title);

            return $title;
        }

        return null;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([20, 40, 100])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->color(fn($state) => match ($state) {
                        'scheduled' => 'blue',
                        'in_progress' => 'orange',
                        'finished' => 'green',
                        'cancelled' => 'red',
                        'completed' => '#0f0',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->dateTime()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('scheduled_at', 'desc')
            ->filters([
                SelectFilter::make('event')
                    ->relationship('event', 'title'),
                SelectFilter::make('status')
                    ->options(Game::STATUS_OPTIONS),
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
