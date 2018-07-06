<?php

namespace App\Repositories;

use App\Entities\Role;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

use App\Entities\Member;

/**
 * Class MemberRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MemberRepositoryEloquent extends BaseRepository implements MemberRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Member::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        Member::created(function (Member $member) {
            $role = Role::whereSlug(Role::MEMBER)->first();
            $member->roles()->attach($role->id);
        });
    }
}
