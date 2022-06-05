<?php


namespace App\Service\Converter;


interface ConverterInterface
{
    public function convertResponseToEntity($response, $entity): object;
}