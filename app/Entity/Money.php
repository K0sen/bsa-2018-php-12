<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Money.
 *
 * @property int                  $id
 * @property float                $amount
 * @property int                  $currency_id
 * @property int                  $wallet_id
 * @property string               $deleted_at
 * @property \App\Entity\Currency $currency
 * @property \App\Entity\Wallet   $wallet
 */
class Money extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    public $timestamps = false;

    protected $casts = [
        'amount'      => 'float',
        'currency_id' => 'int',
        'wallet_id'   => 'int',
    ];

    protected $fillable = [
        'amount',
        'currency_id',
        'wallet_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
