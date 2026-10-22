<?php

namespace Packages\University\ApiResources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentChargeApiResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this?->id,
            'ref_number' => $this?->ref_number,
            'fee_type' => $this->feeType?->name,
            'amount' => $this?->net_amount,
            'currency' => [
                'name' => $this?->currency?->name,
                'symbol' => $this?->currency?->symbol,
            ],
            'student' => [
                'name' => $this->student?->name,
                'university_no' => $this->student?->university_no,
            ],
            'academic_year' => (int) $this->academicYear?->name,
            'created_at' => [
                'iso' => $this->created_at->toISOString(),
                'date' => $this->created_at->format('Y-m-d'),
                'time' => $this->created_at->format('H:i:s'),
                'datetime' => $this->created_at->format('Y-m-d H:i:s'),
                'human' => $this->created_at->diffForHumans(),
            ],
        ];
    }
}
