<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class,'role_permissions', 'role_id', 'permission_id')->where('permission_type', 'menu');
    }

    public function userMenuActions()
    {
        return $this->belongsToMany(UserMenuAction::class,'role_permissions', 'role_id', 'permission_id')->where('permission_type', 'menu_action');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
