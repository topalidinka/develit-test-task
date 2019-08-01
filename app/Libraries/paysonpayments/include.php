<?php
/**
 *  @author    Payson AB <integration@payson.se>
 *  @copyright 2019 Payson AB
 *  @license   http://unlicense.org/
 */

function spl__autoload_payson_payments_classes($className)
{
    if (!preg_match('#^(Payson\\\\Payments)#', $className)) {
        return;
    }

    $filename = str_replace('Payson\\Payments\\', '', $className);
    $fullPath = str_replace('\\', '/', __DIR__ . '\\src\\' . $filename . ".php");

    if (file_exists($fullPath)) {
        include_once $fullPath;
    }
}

spl_autoload_register('spl__autoload_payson_payments_classes');
