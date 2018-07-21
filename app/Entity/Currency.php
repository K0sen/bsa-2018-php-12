<?php


namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency.
 *
 * @property int                                      $id
 * @property string                                   $short_name
 * @property float                                    $actual_course
 * @property \Illuminate\Database\Eloquent\Collection $money
 */
class Currency extends Model
{
    public $timestamps = false;

    protected $casts = [
        'actual_course' => 'float',
    ];

    protected $fillable = [
        'short_name', 'actual_course'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function money()
    {
        return $this->hasMany(Money::class);
    }

    public function wallets()
    {
        return $this->belongsToMany(Wallet::class, 'money')->withPivot(['amount']);
    }
}
