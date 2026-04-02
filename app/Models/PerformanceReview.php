<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformanceReview extends Model {
    use HasFactory;
    protected $fillable = ['staff_id','reviewer_id','period','score','strengths','improvements','goals','status','submitted_at'];
    protected $casts = ['score'=>'integer','submitted_at'=>'datetime'];
    public function staff()    { return $this->belongsTo(User::class, 'staff_id'); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewer_id'); }
}
