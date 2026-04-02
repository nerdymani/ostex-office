<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model {
    use HasFactory;
    protected $fillable = ['name','category','contact_name','email','phone','address','website','status','notes'];
    public function contracts() { return $this->hasMany(VendorContract::class); }
}
