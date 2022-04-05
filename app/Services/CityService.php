<?php

namespace App\Services;

use App\Repositories\CityRepositoryInterface;

class CityService
{
    public function __construct(CityRepositoryInterface $cityRepo)
    {
        $this->cityRepositry = $cityRepo;
    }

    public function getPrefName($pref_id)
    {
        return $this->cityRepositry->getPrefName($pref_id);
    }

    public function getCityName($city_id)
    {
        return $this->cityRepositry->getCityName($city_id);
    }

    public function getCity($pref_id)
    {
        return $this->cityRepositry->getCity($pref_id);
    }

    public function getCityAddSelect($pref_id)
    {
        return $this->cityRepositry->getCityAddSelect($pref_id);
    }

    public function getPrefId($city_id)
    {
        return $this->cityRepositry->getPrefId($city_id);
    }
}
