<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'country', 'balance'];
 
    /**
     * Define a has-many  relationship with the `Player` model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
}
