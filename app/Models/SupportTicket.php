<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportTicket extends Model {
    use HasFactory;
    protected $fillable = ['title','description','submitted_by','assigned_to','priority','category','status','resolved_at'];
    protected $casts = ['resolved_at'=>'datetime'];
    public function submitter() { return $this->belongsTo(User::class, 'submitted_by'); }
    public function assignee()  { return $this->belongsTo(User::class, 'assigned_to'); }
}
