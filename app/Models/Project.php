<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Project extends Model {
    protected $fillable = ['name','description','client','status','priority','start_date','deadline','lead_by','progress'];
    public function lead() { return $this->belongsTo(User::class, 'lead_by'); }
}
