<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ExportPdfController extends Controller
{
    public function employees(): Response
    {
        $employees = Employee::with('division')
            ->orderBy('full_name')
            ->get();

        $pdf = Pdf::loadView('pdf.employees', compact('employees'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-karyawan-'.now()->format('Y-m-d').'.pdf');
    }

    public function leaveRequests(): Response
    {
        $leaveRequests = LeaveRequest::with(['employee', 'approver'])
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView('pdf.leave-requests', compact('leaveRequests'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-cuti-'.now()->format('Y-m-d').'.pdf');
    }
}
