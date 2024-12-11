<?php

namespace App\Enum;

enum State: string
{
    case ANNULE = 'annulé';
    case RESERVE = 'réservé';
    case PASSE = 'passé';
}
