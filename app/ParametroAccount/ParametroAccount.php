<?php

namespace App\ParametroAccount;

use Illuminate\Database\Eloquent\Model;

class ParametroAccount extends Model
{
    protected $table = 'accounting_parameter';
    protected $fillable =[

        'code',
        'description',
        'level',
        'account1',
        'account2'
       ];


}
