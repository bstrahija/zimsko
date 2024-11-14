<?php

namespace App\Filament\Resources\RefereeResource\Pages;

use App\Filament\Resources\RefereeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReferee extends EditRecord
{
    protected static string $resource = RefereeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
