<?php

namespace App\Enum;

enum TransactionType: string 
{

    case PURCHASE = 'purchase' ;
    case SALE = 'sale' ;
    case SWAP = 'swap';
}