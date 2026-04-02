<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SlaPolicy extends Model {
    use HasFactory;
    protected $fillable = ['name','priority','response_hours','resolution_hours','is_active'];
    protected $casts = ['is_active'=>'boolean'];
}
