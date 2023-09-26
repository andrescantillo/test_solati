<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'document',
        'first_name',
        'last_name',
        'phone',
        'address',
        'birthday',
        'id_companies',
        'created_by',
        'updated_by'
    ];
}
