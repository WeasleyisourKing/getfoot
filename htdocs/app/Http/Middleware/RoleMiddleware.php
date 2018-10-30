<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use App\Http\Model\PrivilegeModel;
use App\Http\Model\PrivilegeRoleModel;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle ($request, Closure $next)
    {

        $info = Auth::user();

        if (!$info) {
            return redirect('error');
        }

        $role = PrivilegeModel::whereIn('id', PrivilegeRoleModel::where('role_id', $info->role)
            ->get(['privilege_id']))
            ->get()
            ->toArray();



        $current = explode('/',\Request::getRequestUri());
        $currents = '';
            if (count($current) > 3) {
                $currents = '/'.$current[1].'/'.$current[2].'/'.$current[3];
            } else {

                foreach ($current as $key => $items) {
                    $currents .= $current[$key].'/';
                }
                $currents = rtrim($currents,'/');
            }


        $arr = array_column($role, 'route');

        if (in_array($currents,$arr)) {

            return $next($request);

        } else {
            return redirect('auth');
        }

    }
}
