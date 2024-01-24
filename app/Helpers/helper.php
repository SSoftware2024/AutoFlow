<?php
if (!function_exists('getArrayRequestReplaceNull')) {
    /**
     * Mudar valor nulo para valor do replace
     *
     * @param array $array
     * @param string $replace
     * @return array
     */
    function getArrayRequestReplaceNull(array $array, $replace=''):array
    {
        $result = array_map(
            fn ($value) => $value ?? $replace, $array
        );
        return $result;
    }
}
