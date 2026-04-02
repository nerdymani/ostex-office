<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model {
    use HasFactory;
    protected $fillable = ['title','client_name','description','department','manager_id','status','priority','start_date','due_date','completed_at','budget','currency'];
    protected $casts = ['start_date'=>'date','due_date'=>'date','completed_at'=>'datetime','budget'=>'decimal:2'];
    public function manager() { return $this->belongsTo(User::class, 'manager_id'); }
    public function members() { return $this->belongsToMany(User::class, 'project_members')->withPivot('role')->withTimestamps(); }
}
