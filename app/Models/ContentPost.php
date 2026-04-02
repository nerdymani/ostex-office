<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentPost extends Model {
    use HasFactory;
    protected $fillable = ['title','caption','media_paths','platforms','post_type','status','scheduled_at','published_at','created_by','approved_by','campaign_id','notes'];
    protected $casts = ['media_paths'=>'array','platforms'=>'array','scheduled_at'=>'datetime','published_at'=>'datetime'];
    public function creator()  { return $this->belongsTo(User::class, 'created_by'); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }
}
