<?php

namespace App\Http\Middleware\CMS;

use Closure;
use Illuminate\Http\Request;
use App\Http\Middleware\BaseMiddleware;
use Illuminate\Contracts\Auth\Factory as Auth;

use App\Http\Controllers\Permission\PermissionBrowseController;
use App\Http\Controllers\Config\ConfigBrowseController;

class Authenticate extends BaseMiddleware
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth, Request $request)
    {
        $TokenType = $request->cookie('TokenType');
        $AccessToken = $request->cookie('AccessToken');
        $request->headers->set('Authorization', $TokenType.' '.$AccessToken);

        parent::__construct($request);
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!empty ($_COOKIE['AccessToken'])) {
            setcookie("AccessToken", $_COOKIE['AccessToken'], time() + (6000 * 10), '/');
        }
        if ($this->auth->guard($guard)->guest()) {
            return redirect()->route('login');
        }
        $Me = (object)[ 'account' => $request->user(), 'type' => 'user'];
        $this->_Request->merge(['Me' => $Me]);
        $Counter = \App\Support\Counter::Init();

        $Config = ConfigBrowseController::FetchBrowse($request)
        ->where('take', 'all')
        ->get('fetch');


        $configs = [];
        foreach ($Config['records'] as $key => $value) {
            $configs[$value->key] = $value->value;
        }

        $request->configs = $configs;
        $Config = \App\Support\Config::Init();
        $Config->InitAllConfig($request->configs);

        $PermissionId = $Me->account->position_id;
        $Permission = PermissionBrowseController::FetchBrowse($request)
        ->where('orderBy.created_at', 'desc')
        ->where('position_id', $PermissionId)
        ->where('with.total', 'true')
        ->where('take', 'all')
        ->get('fetch');

        $request->permissions = $Permission['records']->toArray();
        $Permission = \App\Support\Permission::Init();
        $Permission->InitAllPermission($request->permissions);

        return $next($request);
    }
}
