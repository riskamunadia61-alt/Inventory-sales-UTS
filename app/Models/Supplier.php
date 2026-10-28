<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 
    // Atau jika Anda menggunakan $fillable, pastikan 'address' ikut ditulis seperti ini:
    // protected $fillable = ['name', 'phone', 'email', 'address'];
}