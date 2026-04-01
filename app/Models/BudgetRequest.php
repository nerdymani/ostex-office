<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BudgetRequest extends Model {
    protected $fillable = ['title','description','department','requested_amount','approved_amount','status','requested_by','reviewed_by','review_note'];
    public function requester() { return $this->belongsTo(User::class, 'requested_by'); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }
}
