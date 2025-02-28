<?php

namespace App\Filament\Resources\TeamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PlayersRelationManager extends RelationManager
{
    protected static string $relationship = 'players';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('position')
                    ->required()
                    ->maxLength(255),
                SpatieMediaLibraryFileUpload::make('photo')
                    ->collection('photos'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated([25, 50, 100])
            ->defaultSort('first_name', 'asc')
            ->recordTitleAttribute('first_name')
            ->columns([
                SpatieMediaLibraryImageColumn::make('photo')->collection('photos'),
                Tables\Columns\TextColumn::make('number'),
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('last_name'),
                Tables\Columns\TextColumn::make('position')->formatStateUsing(fn(string $state) => Str::upper($state)),
                Tables\Columns\ToggleColumn::make('is_active')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->label('Add Player')
                    ->recordTitle(fn($record) => "{$record->first_name} {$record->last_name}")
                    ->recordSelectSearchColumns(['first_name', 'last_name']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make()->label('Remove'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
