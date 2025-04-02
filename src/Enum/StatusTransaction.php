<?php

namespace App\Enum;

enum StatusTransaction: string 
{

    case PENDING = 'Pending' ;
    case COMPLETED = 'Completed' ;
    case CANCELED = 'Canceled';
}