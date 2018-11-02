<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MemberCardInfo.
 *
 * @package namespace App\Entities;
 */
class MemberCardInfo extends Card
{
    protected $table = 'cards';

    public function members() : BelongsToMany
    {
        return $this->belongsTo(MemberCard::class, 'users',
            'user_id', 'card_id');
    }

    public static function boot()
    {
        MemberCardInfo::creating(function(MemberCardInfo $memberCardInfo) {
            $memberCardInfo->code = 'MC'.app('uid.generator')->getUid(MEMBER_CARD_CODE_FORMAT,
                    MEMBER_CARD_SEGMENT_MAX_LENGTH);
            return $memberCardInfo;
        });
    }
}
