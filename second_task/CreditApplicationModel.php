<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditApplication extends Model
{
    protected $fillable = [
        'dealer',
        'contact_person',
        'loan_amount',
        'loan_term',
        'interest_rate',
        'reason',
        'status',
        'bank_id',
    ];

    public $timestamps = true;

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
