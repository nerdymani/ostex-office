<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KpiRecord extends Model {
    use HasFactory;
    protected $fillable = ['department','metric_name','metric_value','target_value','period','notes','recorded_by'];
    public function recorder() { return $this->belongsTo(User::class, 'recorded_by'); }
}
