<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Task extends Model {
    protected $fillable = ['title','description','assigned_to','assigned_by','department','priority','status','due_date'];
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
    public function assigner() { return $this->belongsTo(User::class, 'assigned_by'); }
}
