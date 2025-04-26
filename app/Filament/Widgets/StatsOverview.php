<?php

namespace App\Filament\Widgets;

use App\Enums\ServiceStatus;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Todos os Serviços', Service::count())
            ->icon('heroicon-m-wrench-screwdriver'),

            Stat::make('Aguardando Orçamento', Service::where('status', ServiceStatus::AwaitingEvaluation->value)
            ->count()),

            Stat::make('Finalizados', Service::where('status', ServiceStatus::DeviceCollected->value)
            ->count())
        ];
    }
}
