<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('guardName')) {
    /**
     * Retorna o guard do sessão atual
     *
     * @return string
     */
    function guardName(): string
    {
        $guards = config('auth.guards');
        unset($guards['sanctum']);
        foreach ($guards as $guardName => $guardConfig) {
            $user = Auth::guard($guardName)->user();
            return !empty($user) ? $guardName : '';
        }
    }
}
if (!function_exists('getArrayRequestReplaceNull')) {
    /**
     * Mudar valor nulo para valor do replace
     *
     * @param array $array
     * @param string $replace
     * @return array
     */
    function getArrayRequestReplaceNull(array $array, $replace = ''): array
    {
        $result = array_map(
            fn ($value) => $value ?? $replace,
            $array
        );
        return $result;
    }
}
