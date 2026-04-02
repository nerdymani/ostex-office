<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentCalendar extends Model {
    use HasFactory;
    protected $fillable = ['title','month','year','goal','created_by'];
    protected $casts = ['month'=>'integer','year'=>'integer'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
