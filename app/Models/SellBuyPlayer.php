<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellBuyPlayer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['player_id', 'amount', 'buy', 'sell'];

    /**
     * Define a belongsTo relationship with the `Player` model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id');
    }
}
