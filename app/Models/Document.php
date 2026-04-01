<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Document extends Model {
    protected $fillable = ['title','file_path','department','uploaded_by','category'];
    public function uploader() { return $this->belongsTo(User::class, 'uploaded_by'); }
}
