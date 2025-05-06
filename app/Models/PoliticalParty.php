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
        'abbreviation',
        'description',
        'logo',
        'website',
        'founding_date',
        'headquarters'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}