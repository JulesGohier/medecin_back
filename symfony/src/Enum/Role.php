<?php

namespace App\Enum;

enum Role: string
{
    case MEDECIN = 'medecin';
    case PATIENT = 'patient';
}
