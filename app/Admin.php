<?php

namespace App;
use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    use Notifiable;

    protected $table = 'admins';
    protected $have_role;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }
    
    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function hasRole($roles)
    {
        $this->have_role = $this->getAdminUserRole();
        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->checkIfAdminUserHasRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->checkIfAdminUserHasRole($roles);
        }
        return false;
    }

    public function getAdminUserRole()
    {
        return $this->role()->getResults();
    }

    private function checkIfAdminUserHasRole($need_role)
    {
        return (strtolower($need_role) == strtolower($this->have_role->role_abbreviation)) ? true : false;
    }

}
