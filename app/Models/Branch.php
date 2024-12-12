<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{

    use SoftDeletes;
    protected $guarded = [];

    function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
