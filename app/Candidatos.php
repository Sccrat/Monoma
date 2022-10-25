<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Events\LeadCreated;
use App\Events\LeadUpdated;
use App\Events\LeadDeleted;

class Candidatos extends Authenticatable
{
    protected $fillable = [
        'name', 'source', 'owner'
    ];

    protected $dispatchesEvents = [
        'created' => LeadCreated::class,
        'updated' => LeadUpdated::class,
        'deleted' => LeadDeleted::class,
    ];
}
