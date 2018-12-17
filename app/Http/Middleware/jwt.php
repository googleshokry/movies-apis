<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class jwt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$token = \Tymon\JWTAuth\Facades\JWTAuth::setRequest($request)->getToken()) {
            return response()->json([
                'status'    =>  false,
                'errors'    =>  "404",
                'msg'       =>  "Not Send Token",
                'payload'   =>  "",
                'level'     =>  ""
            ]);
        }
        try {
            if (! $user = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'status'    =>  false,
                    'errors'    =>  "404",
                    'msg'       =>  "User Not Found",
                    'payload'   =>  "",
                    'level'     =>  ""
                ]);
            }
        } catch (TokenExpiredException $e) {
//            $refreshed = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json([
                'status'    =>  false,
                'errors'    =>  "",
                'msg'       =>  "token expired",
                'payload'   =>  "",
                'level'     =>  ""
            ]);

        }  catch (TokenInvalidException $e) {
            return response()->json([
                'status'    =>  false,
                'errors'    =>  "",
                'msg'       =>  "token invalid",
                'payload'   =>  "",
                'level'     =>  ""
            ]);


        } catch (JWTException $e) {
            return response()->json([
                'status'    =>  false,
                'errors'    =>  "",
                'msg'       =>  "token absent",
                'payload'   =>  "",
                'level'     =>  ""
            ]);
        }
        return $next($request);

    }
}
