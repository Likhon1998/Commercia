<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vat_number',
        'percentage',
        'status',
    ];

    // VAT groups this VAT belongs to
    public function vatGroups()
    {
        return $this->belongsToMany(VatGroup::class, 'vat_group_vat', 'vat_id', 'vat_group_id');
    }
}
