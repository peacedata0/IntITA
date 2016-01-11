<?php

trait GracefulDivision
{
    public static function getArrayInvoiceSumma($summa, $payCount){
        $arrayInvoiceSumma = [];

        $pay = ceil($summa * 100 / $payCount);
        $pay /= 100;
        for($i = 0; $i < $payCount; $i++){
            $arrayInvoiceSumma[$i] = $pay;
            if ($i == $payCount - 1){
                $arrayInvoiceSumma[$payCount - 1] = $summa - $pay * ($payCount - 1);
            }
        }

        return  $arrayInvoiceSumma;
    }
}