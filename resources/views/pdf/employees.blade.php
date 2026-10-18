<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Data Karyawan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .meta { color: #555; margin-bottom: 16px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; font-weight: bold; }
        tr:nth-child(even) { background: #fafafa; }
        .footer { margin-top: 20px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>Laporan Data Karyawan</h1>
    <div class="meta">
        Dicetak: {{ now()->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
        &middot; Total: {{ $employees->count() }} karyawan
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Divisi</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th>Email</th>
                <th>HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $i => $e)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $e->employee_number ?? '-' }}</td>
                    <td>{{ $e->full_name }}</td>
                    <td>{{ $e->division?->name ?? '-' }}</td>
                    <td>{{ $e->position ?? '-' }}</td>
                    <td>{{ $e->employment_status ?? '-' }}</td>
                    <td>{{ $e->email ?? '-' }}</td>
                    <td>{{ $e->phone ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Sistem Data Kantor — Laporan Karyawan</div>
</body>
</html>
