<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetRequest extends Model {
    use HasFactory;
    protected $fillable = ['title','department','requested_by','amount','currency','category','description','justification','status','reviewed_by','reviewed_at','reviewer_note','needed_by'];
    protected $casts = ['amount'=>'decimal:2','reviewed_at'=>'datetime','needed_by'=>'date'];
    public function requester() { return $this->belongsTo(User::class, 'requested_by'); }
    public function reviewer()  { return $this->belongsTo(User::class, 'reviewed_by'); }
}
