<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birth_date',
        'gender',
        'civil_status',
        'sitio',
        'street_address',
        'household_number',
        'contact_number',
        'occupation',
        'religion',
        'citizenship',
        'photo',
        'is_head_of_family',
        'family_head_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_head_of_family' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        $name = $this->first_name . ' ' . $this->last_name;
        if ($this->middle_name) {
            $name = $this->first_name . ' ' . $this->middle_name[0] . '. ' . $this->last_name;
        }
        if ($this->suffix) {
            $name .= ' ' . $this->suffix;
        }
        return $name;
    }

    public function getAgeAttribute()
    {
        return $this->birth_date->age;
    }

    public function familyHead()
    {
        return $this->belongsTo(Resident::class, 'family_head_id');
    }

    public function familyMembers()
    {
        return $this->hasMany(Resident::class, 'family_head_id');
    }
}