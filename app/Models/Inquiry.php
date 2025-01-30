<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'assign_id',
        'company_name',
        'contact_person',
        'phone',
        'city',
        'business_id',
        'requirement_id',
        'status_id',
        'reff',
        'remarks',
        'image',
        'inquiry_date',
        'followup_remarks_1',
        'followup_date_1',
        'followup_remarks_2',
        'followup_date_2',
        'followup_remarks_3',
        'followup_date_3',
        'followup_remarks_4',
        'followup_date_4',
        'followup_remarks_5',
        'followup_date_5',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function assign()
    {
        return $this->belongsTo(User::class, 'assign_id', 'id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }
    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id', 'id');
    }
}
