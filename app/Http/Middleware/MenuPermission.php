<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\UserMenuAction;
use App\Models\UserPermission;
use Closure;
use Illuminate\Http\Request;

class MenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   $routeName = \Route::currentRouteName();
        $menu = Menu::where('route_name',$routeName)->first();
        $menu_action = UserMenuAction::where('route_name',$routeName)->first();
        $permission = UserPermission::where('user_id',auth()->user()->id)->where('route_name',$routeName)->first();
        if(@$menu || @$menu_action){
            if(@$permission){
                return $next($request);
            }else{
                return response()->view('errors.403');
            }

        }else{
            return $next($request);
        }

    }
}
