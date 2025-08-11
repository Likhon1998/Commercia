<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    // VATs that belong to this group
    public function vats()
    {
        return $this->belongsToMany(Vat::class, 'vat_group_vat', 'vat_group_id', 'vat_id');
    }

    // Calculate total percentage of all VATs in this group
    public function totalPercentage()
    {
        return $this->vats()->sum('percentage');
    }
}
