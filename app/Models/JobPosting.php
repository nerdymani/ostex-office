<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobPosting extends Model {
    use HasFactory;
    protected $fillable = ['title','department','type','description','requirements','salary_range','deadline','status'];
    protected $casts = ['deadline'=>'date'];
    public function applications() { return $this->hasMany(JobApplication::class); }
}
