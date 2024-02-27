<?php

namespace App\Enums;

enum RentStatus: string
{
    case PENDING_PAYMENT = 'Pagamento Pendente';
    case PAID            = 'Pago';
    case IN_PROGRESS     = 'Em Andamento';
    case CLOSED          = 'Finalizado';

    public static function getColor(RentStatus $case): string
    {
        return match ($case) {
            self::PENDING_PAYMENT => 'green',
            self::PAID, self::IN_PROGRESS => 'yellow',
            self::CLOSED => 'red',
        };
    }

    public static function fromValue(string $search): self
    {
        return match ($search) {
            'pending_payment' => self::PENDING_PAYMENT,
            'paid'            => self::PAID,
            'in_progress'     => self::IN_PROGRESS,
            'closed'          => self::CLOSED,
        };
    }
}
