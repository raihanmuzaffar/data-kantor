<?php

namespace App\Filament\Resources\Reimbursements\Pages;

use App\Filament\Resources\Reimbursements\ReimbursementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReimbursement extends CreateRecord
{
    protected static string $resource = ReimbursementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = 'pending';

        if (auth()->user()?->hasRole('karyawan') && auth()->user()->employee) {
            $data['employee_id'] = auth()->user()->employee->id;
        }

        return $data;
    }
}
