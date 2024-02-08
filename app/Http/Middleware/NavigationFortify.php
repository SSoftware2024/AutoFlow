<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\FinalClass\Navigate\Breadcrumb;
use Inertia\Inertia;

class NavigationFortify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Inertia::share('breadcrumb', $this->breadcrumb($request));
        return $next($request);
    }

    private function breadcrumb(Request $request):array
    {
        $breadcrumb = new Breadcrumb();
        switch ($request->route()->getName()) {
            case 'profile.show':
                $breadcrumb->setLink('Perfil');
                break;

            default:
                return [];
                break;
        }
        return $breadcrumb->generate();
    }
}
