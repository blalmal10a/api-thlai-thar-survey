<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThlaiThar extends Model
{
    use HasFactory;

    public function vegetable()
    {
        return $this->belongsTo(Vegetable::class);
    }

    public function thar_zat_unit()
    {
        return $this->belongsTo(MeasurementUnit::class, 'thar_zat_unit_id');
    }

    public function beisei_zat_unit()
    {
        return $this->belongsTo(MeasurementUnit::class, 'beisei_zat_unit_id');
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
