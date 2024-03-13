<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory, SoftDeletes;

    public function farmers()
    {
        return $this->hasMany(Farmer::class);
    }

    public function vegetables()
    {
        return $this->hasMany(ThlaiThar::class);
    }
}
