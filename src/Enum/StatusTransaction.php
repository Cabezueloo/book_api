<?php

namespace App\Enum;

enum StatusTransaction: string 
{

    case PENDING = 'pending' ;
    case COMPLETED = 'completed' ;
    case CANCELED = 'canceled';
}