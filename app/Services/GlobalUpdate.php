<?php 
namespace App\Services;

class GlobalUpdate
{
    protected $endpoint;

    public function __construct()
    {
        $this->endpoint = 'https://api.covid19api.com/';
    }

    public function testing()
    {
        return true;
    }
}
