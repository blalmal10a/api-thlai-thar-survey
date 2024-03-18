<?php

namespace App\Filament\Resources\FarmerResource\Pages;

use App\Filament\Resources\FarmerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFarmer extends CreateRecord
{
    protected static string $resource = FarmerResource::class;
    protected static ?string $title = 'Add Farmer';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['vc_id'] = auth()->id();
        $data['district_id'] = request()->user()?->district_id;
        $data['ip'] = request()->ip();
        return $data;
    }
}
