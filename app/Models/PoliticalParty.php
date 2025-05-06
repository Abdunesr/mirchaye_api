<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliticalParty extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'party_name',
        'party_acronym',
        'registration_number',
        'certificate_url',
        'logo_url',
        'president_name',
        'president_photo_url',
        'contact_phone',
        'contact_email',
        'headquarters_address',
        'facebook_url',
        'twitter_url',
        'founded_year',
        'slogan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}