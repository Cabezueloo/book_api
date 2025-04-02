<?php

namespace App\Enum;

enum TransactionType: string 
{

    case PURCHASE = 'Purchase' ;
    case SALE = 'Sale' ;
    case SWAP = 'Swap';
}