<?php

namespace App\Enum;

enum TacheStatut: string
{
    case TO_DO = 'To Do';
    case DOING = 'Doing';
    case DONE = 'Done';

    public function getLabel(): string
    {
        return match ($this) {
            self::TO_DO => 'To Do',
            self::DOING => 'Doing',
            self::DONE => 'Done',
        };
    }
}
