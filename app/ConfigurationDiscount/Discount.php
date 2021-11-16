<?php

namespace App\ConfigurationDiscount;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'configuration_discount';
    protected $fillable =[

        'type_payment',
        'key_account',
        'code_account',
        'code_discount',
        'name_discount',
        'id_partner'
       ];


}
