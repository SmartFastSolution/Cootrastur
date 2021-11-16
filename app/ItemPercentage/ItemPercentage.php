<?php

namespace App\ItemPercentage;

use Illuminate\Database\Eloquent\Model;

class ItemPercentage extends Model
{
    protected $table = 'items_percentage';
    protected $fillable =[

        'code',
        'description',
        'type',
        'value',
        'status',
        'key_account',
        'code_account',
        
       ];


}
