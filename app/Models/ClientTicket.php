<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientTicket extends Model {
    use HasFactory;
    protected $fillable = ['ticket_number','client_name','client_email','client_phone','subject','description','category','priority','status','assigned_to','source','resolved_at','first_response_at'];
    protected $casts = ['resolved_at'=>'datetime','first_response_at'=>'datetime'];

    protected static function booted(): void {
        static::creating(function (ClientTicket $ticket) {
            if (empty($ticket->ticket_number)) {
                $prefix = 'TKT-' . now()->format('Ym') . '-';
                $count  = static::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count() + 1;
                $ticket->ticket_number = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
    public function notes()    { return $this->hasMany(TicketNote::class, 'ticket_id'); }
}
