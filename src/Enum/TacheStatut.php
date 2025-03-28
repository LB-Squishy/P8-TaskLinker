<?php

namespace App\Enum;

enum TacheStatut: string
{
    case TO_DO = 'To Do';
    case DOING = 'Doing';
    case DONE = 'Done';
}
