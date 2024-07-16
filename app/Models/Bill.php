<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Bill extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use HasUuids;

    protected $fillable = [
        'bill_reference', 'bill_date', 'submitted_at', 'approved_at', 'on_hold_at', 'bill_stage_id',
    ];

    //ended up not using this method as the default seemed more sensible
    public function setStageRandom(): void
    {
        $amountOfBillStages = BillStage::count();
        $this->bill_stage_id = rand(1, $amountOfBillStages);
    }

    public function setDefaultStage($stage = null): void
    {
        if ($stage) {
            $this->bill_stage_id = $stage;
        } else {
            $this->bill_stage_id = 1;
        }
        $this->save();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}