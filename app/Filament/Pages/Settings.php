<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class Settings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 110;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('site_active')
                    ->columnSpanFull()
                    ->label('Site active')
                    ->required(),
                TextInput::make('copyright')
                    ->columnSpanFull()
                    ->label('Copyright notice')
                    ->required(),
                TextInput::make('facebook')
                    ->columnSpanFull()
                    ->label('Facebook URL')
                    ->required(),
                TextInput::make('instagram')
                    ->columnSpanFull()
                    ->label('Instagram URL')
                    ->required(),
            ]);
    }
}
