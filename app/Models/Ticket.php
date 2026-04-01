<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Ticket extends Model {
    protected $fillable = ['ticket_number','subject','description','requester_name','requester_email','priority','status','category','assigned_to','resolved_at'];
    protected $casts = ['resolved_at' => 'datetime'];
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
}
