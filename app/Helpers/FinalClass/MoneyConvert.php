<?php
namespace App\Helpers\FinalClass;
//facade
final class MoneyConvert
{
    /**
     * Convert valor em dinheiro para ser salvo no banco
     *
     * @param [type] $money
     * @return string
     */
    public static function convertToMoney($money):string
    {
        $source = array('.', ',');
        $replace = array('', '.');
        return str_replace($source ,$replace,$money);
    }

    /**
     * Pega valor em numero e convert para formato em dinheiro
     *
     * @param [type] $money
     * @return string
     */
    public static function getDbMoney($money):string
    {
        return number_format($money, 2 ,',','.');
    }
}
