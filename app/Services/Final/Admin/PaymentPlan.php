<?php

namespace App\Services\Final\Admin;

use App\Facade\MoneyConvert;
use App\Models\PaymentPlan as ModelPaymentPlan;

final class PaymentPlan
{
    public function read(bool $changeMoney = false)
    {
        $data = null;
        if($changeMoney){
            $data = ModelPaymentPlan::get()->map(function ($value) {
                $value->price = MoneyConvert::getDbMoney($value->price);
                return $value;
            });
        }else{
            $data =  ModelPaymentPlan::cursor();
        }
        return $data;
    }
    public function create(array $data): ModelPaymentPlan
    {
        return ModelPaymentPlan::create($data);
    }
    public function update(int $id, array $data): int
    {
        return ModelPaymentPlan::where('id', $id)->update($data);
    }
    public function delete(int $id): bool
    {
        return ModelPaymentPlan::where('id', $id)->delete();
    }
}
