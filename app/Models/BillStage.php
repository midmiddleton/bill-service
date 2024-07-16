<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;

class BillStage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'label', 'color_name', 'order',
    ];

    public static function getExistingIds()
    {
        return array_values(BillStage::all()->pluck('id')->toArray());
    }

}