<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model {
    use HasFactory;
    protected $fillable = ['title','department','submitted_by','amount','currency','category','description','receipt_path','expense_date','status','reviewed_by'];
    protected $casts = ['amount'=>'decimal:2','expense_date'=>'date'];
    public function submitter() { return $this->belongsTo(User::class, 'submitted_by'); }
    public function reviewer()  { return $this->belongsTo(User::class, 'reviewed_by'); }
}
