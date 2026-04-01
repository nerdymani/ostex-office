<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Lead extends Model {
    protected $fillable = ['name','company','email','phone','source','service_interest','status','estimated_value','assigned_to','notes'];
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
}
