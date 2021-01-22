<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalTemplate extends Model
{
    use HasFactory;

//    public $incrementing = false;
    protected $table = 'U_OWTM';
    protected $primaryKey = 'U_WtmCode';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
