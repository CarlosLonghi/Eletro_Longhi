<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ServiceStatus: string implements HasLabel
{
    case AwaitingEvaluation = 'awaiting_evaluation';
    case InEvaluation = 'in_evaluation';
    case AwaitingApproval = 'awaiting_approval';
    case Approved = 'approved';
    case InRepair = 'in_repair';
    case AwaitingParts = 'awaiting_parts';
    case RepairCompleted = 'repair_completed';
    case AwaitingPayment = 'awaiting_payment';
    case PaymentReceived = 'payment_received';
    case DeviceCollected = 'device_collected';

    public function getLabel(): string
    {
        return match ($this) {
            self::AwaitingEvaluation => 'Aguardando Orçamento',
            self::InEvaluation => 'Em Avaliação',
            self::AwaitingApproval => 'Aguardando Aprovação',
            self::Approved => 'Serviço Aprovado',
            self::InRepair => 'Em Reparo',
            self::AwaitingParts => 'Aguardando Peças',
            self::RepairCompleted => 'Reparo Concluído',
            self::AwaitingPayment => 'Aguardando Pagamento',
            self::PaymentReceived => 'Pagamento Recebido',
            self::DeviceCollected => 'Aparelho Coletado',
        };
    }
}
