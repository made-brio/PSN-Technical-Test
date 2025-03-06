<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'address',
        'district',
        'city',
        'province',
        'postal_code',
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'postal_code' => 'integer',
    ];

    /**
     * Define relationship: An address belongs to a customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
