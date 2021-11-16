<?php

namespace App\AccountPlan;

use Illuminate\Database\Eloquent\Model;

class AccountPlan extends Model
{
    protected $table = 'account_plan';
    protected $fillable =[

        'account_type',
        'sub_account',
        'object',
        'detail',
        'aux1',
        'aux2',
        'aux3',
        'description',
        'level',
        'display',
        'status',
        'code_account',
        'key_account',
       ];


}
