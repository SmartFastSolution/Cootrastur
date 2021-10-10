<?php

namespace App\Charges;

use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    protected $table = 'charges';
    protected $fillable =[

        'description',
        'type_charges',
        'value',
       ];


}
