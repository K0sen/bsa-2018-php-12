<?php


namespace App\Entity;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wallet.
 *
 * @property int                                      $id
 * @property int                                      $user_id
 * @property string                                   $deleted_at
 * @property \App\User                                $user
 * @property \Illuminate\Database\Eloquent\Collection $money
 */
class Wallet extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    public $timestamps = false;

    protected $casts = [
        'user_id' => 'int',
    ];

    protected $fillable = [
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function money()
    {
        return $this->hasMany(Money::class);
    }

    public function currencies()
    {
        return $this->belongsToMany(Currency::class, 'money')->withPivot(['amount']);
    }
}
