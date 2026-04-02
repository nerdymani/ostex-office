<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model {
    use HasFactory;
    protected $fillable = ['title','description','file_path','file_name','file_size','mime_type','category','uploaded_by','is_public','download_count'];
    protected $casts = ['is_public'=>'boolean'];
    public function uploader() { return $this->belongsTo(User::class, 'uploaded_by'); }
}
