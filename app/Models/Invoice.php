<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $fillable = ['id','customer_id','status','payment_method','total_price'];

    public function orders()
    {
        return $this->hasMany(Order::class,'invoice_id','id');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }
}
