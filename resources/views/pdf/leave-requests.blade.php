<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Pengajuan Cuti</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .meta { color: #555; margin-bottom: 16px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; font-weight: bold; }
        tr:nth-child(even) { background: #fafafa; }
        .footer { margin-top: 20px; font-size: 10px; color: #666; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .pending { background: #fef3c7; }
        .approved { background: #d1fae5; }
        .rejected { background: #fee2e2; }
    </style>
</head>
<body>
    <h1>Laporan Pengajuan Cuti</h1>
    <div class="meta">
        Dicetak: {{ now()->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
        &middot; Total: {{ $leaveRequests->count() }} pengajuan
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Karyawan</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Alasan</th>
                <th>Status</th>
                <th>Disetujui Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaveRequests as $i => $lr)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $lr->employee?->full_name ?? '-' }}</td>
                    <td>{{ $lr->start_date?->format('d M Y') }}</td>
                    <td>{{ $lr->end_date?->format('d M Y') }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($lr->reason, 40) }}</td>
                    <td>
                        <span class="badge {{ $lr->status }}">
                            {{ match($lr->status) {
                                'pending' => 'Menunggu',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                default => $lr->status,
                            } }}
                        </span>
                    </td>
                    <td>{{ $lr->approver?->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Sistem Data Kantor — Laporan Cuti</div>
</body>
</html>
