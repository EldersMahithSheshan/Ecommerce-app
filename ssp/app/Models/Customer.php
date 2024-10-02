<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Orders;

class Customer extends Authenticatable {
    use HasFactory;
    use HasApiTokens;

    // Define the table name
    protected $table = 'customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone_number',
        'password',
    ];
    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

}
