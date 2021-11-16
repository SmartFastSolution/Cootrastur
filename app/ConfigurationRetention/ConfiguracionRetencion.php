<?php

namespace App\ConfigurationRetention;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionRetencion extends Model
{
    protected $table = 'configuration_retention';
    protected $fillable =[

        'key_account',
        'code_account',
        'percentage',
        'status',
       ];


}
