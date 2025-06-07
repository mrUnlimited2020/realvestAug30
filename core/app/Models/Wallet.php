<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    // Define the table associated with the model
    protected $table = 'wallets';

    // Specify the primary key field (if it's not 'id' or if it's not auto-incrementing)
    protected $primaryKey = 'id';

    // Specify whether the primary key is auto-incrementing
    public $incrementing = true;

    // Define the data type of the primary key
    protected $keyType = 'int';

    // Disable timestamps if your table doesn't have `created_at` and `updated_at` columns
    public $timestamps = false;

    // Specify which attributes should be mass-assignable
    protected $fillable = [
        'username',
        'balance',
        'referral_balance',
        'direct_sales_comm',
        'referrals_sales_comm',
        'transaction_wallet',
    ];

    // Optionally, you can define casts for attributes to ensure data types
    protected $casts = [
        'balance' => 'decimal:2',
        'referral_balance' => 'decimal:2',
        'direct_sales_comm' => 'decimal:2',
        'referrals_sales_comm' => 'decimal:2',
        'transaction_wallet' => 'decimal:2',
    ];

    // Define any additional methods, scopes, or relationships here
}
