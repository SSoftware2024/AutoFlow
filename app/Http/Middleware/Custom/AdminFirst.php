<?php
namespace App\Http\Middleware\Custom;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use App\Enum\Database\LevelAccessAdmin;
use Symfony\Component\HttpFoundation\Response;

class AdminFirst
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->level_access != LevelAccessAdmin::FIRST->value){
            $errors = new MessageBag();
            $errors->add('catch', 'Você não tem permissão de acessar essa página');
            return redirect()->back()->withErrors($errors);
        }else{
            return $next($request);
        }

    }
}
