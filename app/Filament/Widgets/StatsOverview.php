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
        $counts = Service::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // qual é o prefixo do seu painel? (default em config/filament.php é "admin")
        $panelPath = config('filament.path', 'admin');

        return collect(ServiceStatus::cases())
            ->filter(fn (ServiceStatus $status) => ($counts[$status->value] ?? 0) > 0)
            ->map(fn (ServiceStatus $status): Stat => Stat::make('', $counts[$status->value])
                ->description($status->getLabel())
                ->descriptionIcon($this->getIconForStatus($status))
                ->color($this->getColorForStatus($status))
                // monta o URL “/admin?statusFilter=...”
                ->url(
                    url($panelPath)
                    . '?statusFilter='
                    . $status->value
                )
            )
            ->toArray();
    }

    private function getIconForStatus(ServiceStatus $status): string
    {
        return match ($status) {
            ServiceStatus::AWAITING_EVALUATION => 'heroicon-o-clock',
            ServiceStatus::IN_EVALUATION => 'heroicon-o-magnifying-glass',
            ServiceStatus::AWAITING_APPROVAL => 'heroicon-o-question-mark-circle',
            ServiceStatus::APPROVED => 'heroicon-o-check-circle',
            ServiceStatus::AWAITING_PARTS => 'heroicon-o-cube',
            ServiceStatus::IN_REPAIR => 'heroicon-o-cog',
            ServiceStatus::REPAIR_COMPLETED => 'heroicon-o-check',
            ServiceStatus::PAYMENT_RECEIVED => 'heroicon-o-currency-dollar',
            ServiceStatus::DEVICE_COLLECTED => 'heroicon-o-truck',
        };
    }

    private function getColorForStatus(ServiceStatus $status): string
    {
        return match ($status) {
            ServiceStatus::AWAITING_EVALUATION => 'secondary',
            ServiceStatus::IN_EVALUATION => 'warning',
            ServiceStatus::AWAITING_APPROVAL => 'warning',
            ServiceStatus::APPROVED => 'success',
            ServiceStatus::AWAITING_PARTS => 'warning',
            ServiceStatus::IN_REPAIR => 'primary',
            ServiceStatus::REPAIR_COMPLETED => 'success',
            ServiceStatus::PAYMENT_RECEIVED => 'success',
            ServiceStatus::DEVICE_COLLECTED => 'info',
        };
    }
}
