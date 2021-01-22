<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationHeader extends Model
{
    use HasFactory;

    //    public $incrementing = false;
    protected $table = 'RESV_H';
    protected $primaryKey = 'DocEntry';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
