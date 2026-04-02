<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email','password','department','position','phone',
        'employee_id','joined_date','is_active','is_admin',
    ];

    protected $hidden = ['password','remember_token'];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'joined_date'       => 'date',
            'is_active'         => 'boolean',
            'is_admin'          => 'boolean',
        ];
    }

    public function tasks()           { return $this->hasMany(Task::class, 'assigned_to'); }
    public function createdTasks()    { return $this->hasMany(Task::class, 'created_by'); }
    public function leaveRequests()   { return $this->hasMany(LeaveRequest::class); }
    public function onboarding()      { return $this->hasOne(OnboardingChecklist::class); }
    public function schedules()       { return $this->hasMany(StaffSchedule::class); }
    public function performanceReviews() { return $this->hasMany(PerformanceReview::class, 'staff_id'); }
}
