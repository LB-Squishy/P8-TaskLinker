<?php

namespace App\Enum;

enum TacheStatut: string
{
    case TO_DO = 'To Do';
    case DOING = 'Doing';
    case DONE = 'Done';

    public static function toArray(): array
    {
        return array_map(fn(self $statut) => $statut->value, self::cases());
    }
}
