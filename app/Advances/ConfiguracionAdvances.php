<?php

namespace App\Advances;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionAdvances extends Model
{
    protected $table = 'advances_loan';
    protected $fillable =[

        'key_account',
        'code_account',
        'type_prestamo',
        'id_percentaje',
        'value_total',
        'months',
        'id_partner',
        'value_payment',
        'value_pending',
        'status',
        'type_formula',
       ];


}
