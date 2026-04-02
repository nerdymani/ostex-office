<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model {
    use HasFactory;
    protected $fillable = ['title','type','description','budget','currency','start_date','end_date','status','target_audience','goals','results','created_by'];
    protected $casts = ['budget'=>'decimal:2','start_date'=>'date','end_date'=>'date'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
