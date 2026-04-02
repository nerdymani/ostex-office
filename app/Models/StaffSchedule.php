<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffSchedule extends Model {
    use HasFactory;
    protected $fillable = ['user_id','department','date','shift_start','shift_end','type','notes'];
    protected $casts = ['date'=>'date'];
    public function user() { return $this->belongsTo(User::class); }
}
