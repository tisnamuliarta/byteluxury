<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocsConfirmation extends Model
{
    use HasFactory;

    //    public $incrementing = false;
    protected $table = 'U_OWDD';
    protected $primaryKey = 'U_WddCode';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
