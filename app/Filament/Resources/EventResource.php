<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use App\Models\Team;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?int $navigationSort = 80;

    protected static ?string $navigationGroup = 'Competition';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                [
                    Tabs::make('Tabs')
                        ->columnSpanFull()
                        ->tabs(
                            [
                                Tabs\Tab::make('General')
                                    ->icon('heroicon-o-document-text')
                                    ->columns('12')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->columnSpanFull()
                                            ->required(),
                                        Forms\Components\TextInput::make('slug')
                                            ->columnSpanFull()
                                            ->hiddenOn(['create'])
                                            ->required(),
                                        Forms\Components\DateTimePicker::make('scheduled_at')
                                            ->required()
                                            ->columnSpanFull(),
                                        TiptapEditor::make('body')
                                            ->columnSpanFull()
                                            ->profile('simple'),
                                    ]),
                                Tabs\Tab::make('Leaderboard')
                                    ->icon('heroicon-o-chart-bar')
                                    ->schema([
                                        Forms\Components\Repeater::make('leaderboard')
                                            ->schema([
                                                Forms\Components\Select::make('team_id')
                                                    ->searchable()
                                                    ->columnSpan(3)
                                                    ->preload()
                                                    ->getSearchResultsUsing(fn(string $search): array => Team::where('title', 'like', "%{$search}%")->limit(50)->pluck('title', 'id')->toArray())
                                                    ->getOptionLabelUsing(fn($value): ?string => Team::find($value)?->title)
                                                    ->required(),
                                                Forms\Components\TextInput::make('games')->default(0)->integer()->required(),
                                                Forms\Components\TextInput::make('wins')->default(0)->integer()->required(),
                                                Forms\Components\TextInput::make('loses')->default(0)->integer()->required(),
                                                Forms\Components\TextInput::make('score')->default(0)->numeric()->required(),
                                                Forms\Components\TextInput::make('points')->default(0)->integer()->required(),
                                            ])
                                            ->columns(8),
                                    ]),
                            ]
                        ),
                ]
            );


        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('title', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
            RelationManagers\TeamsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
