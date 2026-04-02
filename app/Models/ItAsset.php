<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItAsset extends Model {
    use HasFactory;
    protected $fillable = ['name','asset_tag','category','serial_number','assigned_to','location','status','purchase_date','warranty_until','notes'];
    protected $casts = ['purchase_date'=>'date','warranty_until'=>'date'];
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
}
