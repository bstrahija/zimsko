<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoundResource\Pages;
use App\Filament\Resources\RoundResource\RelationManagers;
use App\Models\Event;
use App\Models\Round;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RoundResource extends Resource
{
    protected static ?string $model = Round::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 35;

    protected static ?string $navigationGroup = 'Competition';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->hiddenOn(['create'])
                    ->required(),
                TiptapEditor::make('body')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([20, 40, 100])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event.title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->relationship('event', 'title')
                    ->default(Event::current() ? Event::current()->id : (Event::last() ? Event::last()->id : null))
                    ->label('Event'),

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
            'index' => Pages\ListRounds::route('/'),
            'create' => Pages\CreateRound::route('/create'),
            'edit' => Pages\EditRound::route('/{record}/edit'),
        ];
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()->hasRole(['superadmin']);
    }
}
