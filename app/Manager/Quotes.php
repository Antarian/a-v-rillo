<?php
namespace App\Manager;

interface Quotes
{
    public function getQuotes(int $numberOfQuotes): array;
}
