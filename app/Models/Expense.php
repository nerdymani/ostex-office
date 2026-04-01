<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Expense extends Model {
    protected $fillable = ['title','amount','category','expense_date','receipt_path','status','submitted_by','notes'];
    public function submitter() { return $this->belongsTo(User::class, 'submitted_by'); }
}
