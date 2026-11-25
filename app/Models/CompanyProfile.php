<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address', 'tax_number'];

    public static function current()
    {
        return self::first() ?? self::create([
            'name' => 'PT Maju Jaya Akuntansi',
            'email' => 'info@majujaya.co.id',
            'phone' => '021-55588899',
            'address' => 'Jl. Jenderal Sudirman Kav. 25, Jakarta Selatan',
            'tax_number' => '01.234.567.8-901.000'
        ]);
    }
}
