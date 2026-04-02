<?php
namespace App\Traits;

trait BelongsToDepartment
{
    /**
     * Valid department values: 'HR', 'Finance', 'Technology', 'Sales', 'Operations', 'Support', 'Social Media'
     * is_admin = true bypasses all department checks (managers see everything)
     */
    public static function canAccess(): bool
    {
        $user = auth()->user();
        if (! $user) return false;
        if ($user->is_admin) return true;
        return $user->department === static::DEPARTMENT;
    }
}
