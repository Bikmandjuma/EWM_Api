<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $fillable=[
    	'firstname',
        'lastname',
        'gender',
        'email',
        'phone',
        'image',
        'province',
        'district',
        'sector',
        'cell',
        'village',
        'swm_sn',
        'password'
    ];
}
