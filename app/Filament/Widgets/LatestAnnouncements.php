<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAnnouncements extends BaseWidget
{
    protected static ?string $heading = 'Pengumuman Terbaru';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Announcement::query()
                    ->where('is_published', true)
                    ->latest('published_at')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->weight('bold')
                    ->limit(60),

                TextColumn::make('priority')
                    ->label('Prioritas')
                    ->badge()
                    ->colors([
                        'gray' => 'low',
                        'info' => 'normal',
                        'warning' => 'high',
                        'danger' => 'urgent',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'low' => 'Rendah',
                        'normal' => 'Normal',
                        'high' => 'Tinggi',
                        'urgent' => 'Mendesak',
                        default => $state,
                    }),

                TextColumn::make('published_at')
                    ->label('Dipublish')
                    ->dateTime('d M Y H:i')
                    ->color('gray'),
            ])
            ->paginated(false)
            ->striped();
    }
}
