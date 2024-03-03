<?php
namespace App\Helpers\FinalClass;

use Illuminate\Support\Facades\Validator;

final class Rules
{
    public function execute()
    {
        $this->biggerThen();
        $this->dateAge();
    }

    private function dateAge()
    {
        Validator::extend('date_age', function ($attribute, $value, $parameters, $validator) {
            $parameters[0] = $parameters[0] ?? null;
            if (is_null($parameters[0])) {
                throw new \Exception("The date age field requires a date in the format 'date_age:18'");
            } else {
                $time = strtotime($value);
                $year_diff = '';
                $date = date('Y-m-d', $time);
                list($year, $month, $day) = explode('-', $date);
                $year_diff = date('Y') - $year;
                $month_diff = date('m') - $month;
                // $day_diff = (date('d') - $day) * -1;
                if ($month_diff < 0 || ($month == date('m') && $day > date('d'))) {
                    $year_diff--;
                }
                session()->flash('date_age_year_diff',$year_diff );
                return ($year_diff >= $parameters[0]) ? true : false;
            }
        }, 'O campo :attribute deve resultar em uma idade maior ou igual :parameter, valor encontrado :val.');

        Validator::replacer('date_age', function ($message, $attribute, $rule, $parameters) {
            $message = str_replace(':attribute', $attribute, $message);
            $message = str_replace(':parameter', $parameters[0] ?? null, $message);
            $message = str_replace(':val', session('date_age_year_diff') ?? null, $message);
            return $message;
        });
    }
    private function biggerThen()
    {
        Validator::extend('bigger_then', function ($attribute, $value, $parameters, $validator) {
            $parameters[0] = $parameters[0] ?? 0;
            return $value > $parameters[0];
        }, 'O campo :attribute deve ter o valor maior que :ct_minimum.');

        Validator::replacer('bigger_then', function ($message, $attribute, $rule, $parameters) {
            $message = str_replace(':attribute', $attribute, $message);
            $message = str_replace(':ct_minimum', $parameters[0] ?? 0, $message);
            return $message;
        });
    }
}
