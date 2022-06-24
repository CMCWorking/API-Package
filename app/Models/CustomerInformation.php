<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInformation extends Model
{
    protected $guarded = [];
    use HasFactory;

    protected $table = 'customer_informations';

    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id');
    }
}
