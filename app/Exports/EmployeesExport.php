<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    // Tambahkan tipe return : Collection di sini
    public function collection(): Collection
    {
        return Employee::with('division')->get();
    }

    public function headings(): array
    {
        return [
            'NIK Karyawan', 'Nama Lengkap', 'Divisi', 'Jabatan', 'Status', 'No. HP', 'Email',
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->employee_number,
            $employee->full_name,
            $employee->division?->name ?? '-',
            $employee->position,
            $employee->employment_status,
            $employee->phone,
            $employee->email,
        ];
    }
}
