<?php

namespace App\Repositories;

interface CityRepositoryInterface
{
    public function getPrefName($pref_id);
    public function getCityName($city_id);
    public function getCity($pref_id);
    public function getCityAddSelect($pref_id);
    public function getPrefId($city_id);
}
