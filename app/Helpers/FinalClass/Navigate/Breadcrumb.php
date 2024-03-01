<?php

namespace App\Helpers\FinalClass\Navigate;

use App\Helpers\Asbstract\Navigate;
use Illuminate\Support\Facades\Route;

final class Breadcrumb extends Navigate
{
    private array $links = [];
    private array $routes_except = [
        'dashboard',
        'admin.dashboard',
        'user.driving_school.dashboard'
    ];
    public function __construct()
    {
        $this->links['home'] = [
            'icon' => 'pi pi-home',
            'route' => route('dashboard'),
        ];
    }
    /**
     * Adciona caminho ou link ao breadcrumb
     *
     * @param string $label
     * @param boolean $isIcon
     * @param string|null $route
     * @param boolean $isHome
     * @return Breadcrumb
     */
    public function setLink(string $label, bool $isIcon = false, ?string $route = null, bool $isHome = false): Breadcrumb
    {
        $jsonLabel = 'label';
        if ($isIcon) {
            $jsonLabel = 'icon';
        }
        $array_mount = [];
        if (empty($route)) {
            $array_mount = [
                $jsonLabel => $label,
            ];
        } else {
            $array_mount = [
                $jsonLabel => $label,
                'route' => $route
            ];
        }
        $this->links['items'][] = $array_mount;
        return $this;
    }

    public function isShow(): bool
    {
        return !in_array(Route::currentRouteName(), $this->routes_except);
    }
    public function generate(): array
    {
        return $this->links;
    }
}
