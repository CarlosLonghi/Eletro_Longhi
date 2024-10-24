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
    case DeviceCollected = 'device_collected';

    public function label(): string
    {
        return match ($this) {
            self::AwaitingEvaluation => 'Awaiting Evaluation',
            self::InEvaluation => 'In Evaluation',
            self::AwaitingApproval => 'Awaiting Customer Approval',
            self::Approved => 'Approved',
            self::InRepair => 'In Repair',
            self::AwaitingParts => 'Awaiting Parts',
            self::RepairCompleted => 'Repair Completed',
            self::AwaitingPayment => 'Awaiting Payment',
            self::DeviceCollected => 'Device Collected',
        };
    }
}
