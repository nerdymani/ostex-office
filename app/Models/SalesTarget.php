<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesTarget extends Model {
    use HasFactory;
    protected $fillable = ['user_id','department','period','target_amount','actual_amount','currency','metric','notes'];
    protected $casts = ['target_amount'=>'decimal:2','actual_amount'=>'decimal:2'];
    public function user() { return $this->belongsTo(User::class); }
}
