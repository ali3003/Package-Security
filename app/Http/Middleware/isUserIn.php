<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\HelperClass;
use App\Services\JWTService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isUserIn
{
    protected $jwtService;
    public function __construct(JWTService $jWTService)
    {
        $this->jwtService = $jWTService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        if($request->jwt!=null){
            if(HelperClass::isUserIn($this->jwtService,$request)){
            return $next($request);
        }
        return HelperClass::sendResponse('e',"You are Not Allowed To visit This Site Please Register",statusCode:400);
        }
        
        return HelperClass::sendResponse('e',"You are Not Allowed To visit This Site Please Register",statusCode:400);
    }
}
