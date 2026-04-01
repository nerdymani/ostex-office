<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Staff extends Model {
    protected $fillable = ['user_id','employee_id','department','job_title','phone','date_hired','status'];
    public function user() { return $this->belongsTo(User::class); }
}
