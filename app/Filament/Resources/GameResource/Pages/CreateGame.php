<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGame extends CreateRecord
{
    protected static string $resource = GameResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // dd($data);

    //     return $data;
    // }

    // protected function mutateFormDataBeforeUpdate(array $data): array
    // {
    //     // dd("UPDATE");
    //     // dd($data);

    //     return $data;
    // }

    protected function handleRecordCreate(Model $record, array $data): Model
    {
        dd("CCC");
        dd($data);
        $record->update($data);

        return $record;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        dd("UUU");
        dd($data);
        $record->update($data);

        return $record;
    }
}
