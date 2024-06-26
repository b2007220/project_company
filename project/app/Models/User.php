<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'gender',
        'avatar',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function socialAccount()
    {
        return $this->hasMany(SocialAccount::class);
    }
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'user_select_discounts', 'user_id', 'discount_id');
    }
    public function isValidAvatarUrl()
    {
        return filter_var($this->avatar, FILTER_VALIDATE_URL) !== false;
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function productsInCart()
    {
        return $this->hasManyThrough(Product::class, Cart::class, 'user_id', 'id', 'id', 'product_id');
    }
}
