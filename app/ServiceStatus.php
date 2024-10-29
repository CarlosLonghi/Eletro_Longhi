<?php

namespace App;

enum ServiceStatus: string
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

    public function label(): string
    {
        return match ($this) {
            self::AwaitingEvaluation => 'Aguardando avaliação',
            self::InEvaluation => 'Em avaliação',
            self::AwaitingApproval => 'Aguardando aprovação do cliente',
            self::Approved => 'Serviço aprovado',
            self::InRepair => 'Em reparo',
            self::AwaitingParts => 'Aguardando peças',
            self::RepairCompleted => 'Reparo concluído',
            self::AwaitingPayment => 'Aguardando Pagamento',
            self::PaymentReceived => 'Pagamento recebido',
            self::DeviceCollected => 'Aparelho coletado',
        };
    }
}
