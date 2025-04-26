<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ServiceStatus: string implements HasLabel
{
    case AWAITING_EVALUATION = 'awaiting_evaluation';
    case IN_EVALUATION = 'in_evaluation';
    case AWAITING_APPROVAL = 'awaiting_approval';
    case APPROVED = 'approved';
    case AWAITING_PARTS = 'awaiting_parts';
    case IN_REPAIR = 'in_repair';
    case REPAIR_COMPLETED = 'repair_completed';
    case PAYMENT_RECEIVED = 'payment_received';
    case DEVICE_COLLECTED = 'device_collected';

    public function getLabel(): string
    {
        return match ($this) {
            self::AWAITING_EVALUATION => 'Aguardando Avaliação',
            self::IN_EVALUATION => 'Em Avaliação',
            self::AWAITING_APPROVAL => 'Aguardando Aprovação',
            self::APPROVED => 'Serviço Aprovado',
            self::AWAITING_PARTS => 'Aguardando Peças',
            self::IN_REPAIR => 'Em Reparo',
            self::REPAIR_COMPLETED => 'Reparo Concluído',
            self::PAYMENT_RECEIVED => 'Pagamento Recebido',
            self::DEVICE_COLLECTED => 'Aparelho Coletado',
        };
    }
}
