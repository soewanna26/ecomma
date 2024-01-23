<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = ['id', 'customer_name', 'phone_primary', 'address', 'division_id','district_id', 'township_id'];

    public function orders(): HasMany
    {
        return $this->HasMany(Order::class,'customer_id','id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function township()
    {
        return $this->belongsTo(Township::class, 'township_id');
    }
}
