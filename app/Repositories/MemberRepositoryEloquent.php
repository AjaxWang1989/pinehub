<?php

namespace App\Repositories;

use App\Entities\Role;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Traits\Destruct;
use App\Repositories\Traits\RepositoryRelationShip;
use App\Criteria\Admin\SearchRequestCriteria;

use App\Entities\Member;

/**
 * Class MemberRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MemberRepositoryEloquent extends BaseRepository implements MemberRepository
{
    use Destruct, RepositoryRelationShip;

    protected $fieldSearchable = [
        'name' => 'like',
    ];
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
        $this->pushCriteria(app(SearchRequestCriteria::class));
        Member::created(function (Member $member) {
            $role = Role::whereSlug(Role::MEMBER)->first();
            $member->roles()->attach($role->id);
        });
    }
}
