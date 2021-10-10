<?php

namespace App\Partner;

use Illuminate\Database\Eloquent\Model;

class PartnerAditional extends Model
{
    protected $table = 'partner_aditional';
    protected $fillable =[

        'id_partner',
        'type_vehicule',
        'payment_aditional',
        'safe_vehicule',
        'ptmo',
        'line',
        'saving',
        'other',
        'iess',
        'garage',
        'cleaning',
        'penalty_fee',
        'safe_internal',
        'store',
        'membership',
        'sensor',
        'satellite',
       ];


}
