<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorContract extends Model {
    use HasFactory;
    protected $fillable = ['vendor_id','title','description','value','currency','start_date','end_date','status','file_path'];
    protected $casts = ['value'=>'decimal:2','start_date'=>'date','end_date'=>'date'];
    public function vendor() { return $this->belongsTo(Vendor::class); }
}
