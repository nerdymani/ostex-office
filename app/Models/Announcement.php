<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model {
    use HasFactory;
    protected $fillable = ['title','body','author_id','is_pinned','published_at','expires_at'];
    protected $casts = ['is_pinned'=>'boolean','published_at'=>'datetime','expires_at'=>'datetime'];
    public function author() { return $this->belongsTo(User::class, 'author_id'); }
}
