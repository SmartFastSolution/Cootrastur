<?php

namespace App\Supplier;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $fillable =[
        'code',
        'name',
        'address',
        'contact',
        'identification',
        'phone1',
        'phone2',
        'fax',
        'email',
        'plazos',
        'line',
        'key_advance',
        'key_supplier',
        'autorization',
       ];
}
