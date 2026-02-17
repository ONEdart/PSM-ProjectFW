<?php

namespace App\Filament\Widgets;

use App\Models\Pages\Program;
use App\Models\Pages\Member;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Program', Program::count())
                ->description('Jumlah program aktif')
                ->icon('heroicon-o-rectangle-stack')
                ->color('primary'),

            Stat::make('Total Pengurus', Member::count())
                ->description('Jumlah anggota organisasi')
                ->icon('heroicon-o-users')
                ->color('success'),
        ];
    }
}
