<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Invoice extends Model {
    protected $fillable = ['invoice_number','client_name','client_email','amount','status','due_date','notes','created_by'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
