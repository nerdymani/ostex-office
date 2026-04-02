<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model {
    use HasFactory;
    protected $fillable = ['lead_id','client_name','client_email','title','body','amount','currency','valid_until','status','sent_at','prepared_by'];
    protected $casts = ['amount'=>'decimal:2','valid_until'=>'date','sent_at'=>'datetime'];
    public function lead()     { return $this->belongsTo(Lead::class); }
    public function preparer() { return $this->belongsTo(User::class, 'prepared_by'); }
}
