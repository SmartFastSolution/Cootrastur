<?php

namespace App\Partner;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partner';
    protected $fillable =[

        'code_trans',
        'identification',
        'birthday',
        'date_begin',
        'identification',
        'line',
        'license_plate',
        'year_vehicle',
        'chasis',
        'motor',
        'name_partner',
        'address_partner',
        'phone1',
        'phone2',
        'email',
        'bank',
        'account_bank',
        'driver',
        'type_account',
        'status',
        'code_account',
       ];


}
