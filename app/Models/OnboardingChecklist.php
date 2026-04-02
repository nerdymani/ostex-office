<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnboardingChecklist extends Model {
    use HasFactory;
    protected $fillable = ['user_id','created_by','contract_signed','id_submitted','equipment_issued','email_setup','system_access','orientation_done','probation_end','notes','completed_at'];
    protected $casts = ['contract_signed'=>'boolean','id_submitted'=>'boolean','equipment_issued'=>'boolean','email_setup'=>'boolean','system_access'=>'boolean','orientation_done'=>'boolean','probation_end'=>'date','completed_at'=>'datetime'];
    public function user()    { return $this->belongsTo(User::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }

    public function completionCount(): int {
        return (int)$this->contract_signed + (int)$this->id_submitted + (int)$this->equipment_issued
             + (int)$this->email_setup + (int)$this->system_access + (int)$this->orientation_done;
    }
}
