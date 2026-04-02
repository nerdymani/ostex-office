<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model {
    use HasFactory;
    protected $fillable = ['job_posting_id','applicant_name','email','phone','cv_path','cover_letter','status','notes'];
    public function posting() { return $this->belongsTo(JobPosting::class, 'job_posting_id'); }
}
