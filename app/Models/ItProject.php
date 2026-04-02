<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItProject extends Model {
    use HasFactory;
    protected $fillable = ['title','description','lead_id','status','priority','start_date','due_date','completed_at'];
    protected $casts = ['start_date'=>'date','due_date'=>'date','completed_at'=>'datetime'];
    public function lead()    { return $this->belongsTo(User::class, 'lead_id'); }
    public function members() { return $this->belongsToMany(User::class, 'it_project_members')->withPivot('role')->withTimestamps(); }
}
