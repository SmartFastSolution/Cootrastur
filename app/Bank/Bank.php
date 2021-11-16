<?php

namespace App\Bank;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';
    protected $fillable =[

        'description',
        'status',
        'key_account',
        'code_account'
       ];


}
