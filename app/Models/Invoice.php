<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model {
    use HasFactory;
    protected $fillable = ['invoice_number','client_name','client_email','client_address','items','subtotal','tax_rate','tax_amount','total','currency','status','issued_date','due_date','notes','paid_at'];
    protected $casts = ['items'=>'array','subtotal'=>'decimal:2','tax_rate'=>'decimal:2','tax_amount'=>'decimal:2','total'=>'decimal:2','issued_date'=>'date','due_date'=>'date','paid_at'=>'date'];

    protected static function booted(): void {
        static::creating(function (Invoice $invoice) {
            if (empty($invoice->invoice_number)) {
                $prefix = 'INV-' . now()->format('Ym') . '-';
                $count  = static::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count() + 1;
                $invoice->invoice_number = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
