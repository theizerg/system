<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
   


    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 
        'last_name',
        'email', 
        'password',
        'status',
        'direccion',
        'telefono',
        'fecha_nacimiento',
        'genero_id',
        'nacionalidad_id',
        'username'
    ];

    protected $hidden = [];

    protected $appends = ['full_name'];


    protected $searchable = [
        'columns' => [
          'users.name' => 5,
          'users.last_name' => 5,
        ]
    ];


    /*
    |
    | ** Relationships model **
    |
    */

    public function logins()
    {
        return $this->hasMany('App\Models\Login');
    }

    /*
    |
    | ** Accesors model **
    |
    */ 

    public function getEncodeIDAttribute()
    {
        return \Hashids::encode($this->id);
    }




    public function getFullNameAttribute()
    {
        return title_case($this->name).' '. title_case($this->last_name);
    }

     public function getRolNameAttribute()
    {
        return $this->roles->pluck(['name']);
    }




    public function getDisplayNameAttribute()
    {
        $name      = explode(' ', $this->name);
        $last_name = explode(' ', $this->last_name);

        return title_case($name[0]).' '.title_case($last_name[0]);
    }




    public function getDisplayStatusAttribute()
    {
        return $this->status == 1 ? 'Activo' : 'Denegado';
    }

    /*
    |
    | ** Mutators model **
    |
    */

    public function setPasswordAttribute($attribute)
    {
        if (! empty($attribute))
        {
           $this->attributes['password'] = strlen($attribute) < 60 ? bcrypt($attribute) : $attribute;
        }
    }

    /*
    |
    | ** Send the custom password reset notification **
    |
    */

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

     public function carts()
    {
        return $this->hasMany(Cart::class);
    }


 
   

// cart_id
    public function getCartAttribute()
    {
        $cart = $this->carts()->where('status', 'Active')->first();
        if ($cart)
            return $cart;

        // else
        $cart = new Cart();
        $cart->status = 'Active';
        $cart->user_id = $this->id;
        $cart->save();

        return $cart;
    }


    
       public function payments()
    {
        return $this->hasMany(PagoRutas::class);
    }

}
