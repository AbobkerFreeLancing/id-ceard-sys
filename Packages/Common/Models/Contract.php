<?php

namespace Packages\Common\Models;

use App\Models\User;
use Packages\Payroll\Models\SalaryStructure;
use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasEnabledScope;
    use SoftDeletes;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
            'probation_end_date' => 'date',
            'termination_date' => 'date',
            'basic_salary' => 'decimal:2',
            'working_hours_per_day' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function salaryStructure(): BelongsTo
    {
        return $this->belongsTo(SalaryStructure::class);
    }
}
