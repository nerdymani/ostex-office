<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Campaign extends Model {
    protected $fillable = ['name','description','platform','start_date','end_date','budget','status','reach','engagement','created_by'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
