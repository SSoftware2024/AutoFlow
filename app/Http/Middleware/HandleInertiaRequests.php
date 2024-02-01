<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;
use Laravel\Fortify\Features;
use App\Facade\NavigateFactory;
use Laravel\Jetstream\Jetstream;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'breadcrumb_show' => NavigateFactory::breadcrumb()->isShow(),
            'auth_more' => [
                'guard' => $request->guardName(),
                'isAdmin' => $request->isAdmin()
            ],
            'flash' => [
                'toast' => session('toast')
            ],
            'toast' => [
                'time' => 1000 * 7,
            ]
        ]);
    }


}
