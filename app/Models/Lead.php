<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model {
    use HasFactory;
    protected $fillable = ['name','company','email','phone','source','service_interest','status','assigned_to','notes','expected_value','currency','expected_close'];
    protected $casts = ['expected_value'=>'decimal:2','expected_close'=>'date'];
    public function assignee()  { return $this->belongsTo(User::class, 'assigned_to'); }
    public function proposals() { return $this->hasMany(Proposal::class); }
}
