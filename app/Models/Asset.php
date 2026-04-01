<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Asset extends Model {
    protected $fillable = ['asset_tag','name','category','location','condition','purchase_date','purchase_value','assigned_to','notes'];
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
}
