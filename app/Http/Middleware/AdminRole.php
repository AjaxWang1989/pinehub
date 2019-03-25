<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2018/9/5
 * Time: 上午11:29
 */

namespace App\Http\Middleware;


use App\Entities\User;
use App\Exceptions\RoleNotAllowed;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next = null)
    {
//        $request->route();
        $user = $request->user();
        tap($user, function (User $user) {
            $roles = [];
            $count = $user->roles()->whereIn($roles)->count();
            if($count < 1) {
                throw new RoleNotAllowed(HTTP_STATUS_FORBIDDEN);
            }
        });
    }
}