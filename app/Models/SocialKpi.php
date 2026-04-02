<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialKpi extends Model {
    use HasFactory;
    protected $fillable = ['platform','metric','value','period','recorded_by'];
    public function recorder() { return $this->belongsTo(User::class, 'recorded_by'); }
}
