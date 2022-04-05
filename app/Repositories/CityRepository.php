<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository implements CityRepositoryInterface
{
    public function getPrefName($pref_id)
    {
        return City::where('pref_id', $pref_id)
        ->select('pref_name')
        ->first();
    }

    public function getCityName($city_id)
    {
        return City::where('id', $city_id)->select('city_name')
        ->first();
    }

    public function getCity($pref_id)
    {
        return City::where('pref_id', $pref_id)
        ->get(); // 選択した都道府県に所属している市区町村情報を取得
    }

    public function getCityAddSelect($pref_id)
    {
        return City::where('pref_id', $pref_id)
        ->pluck('city_name', 'id')
        ->prepend('選択', '');
    }

    public function getPrefId($city_id)
    {
        return City::where('id', $city_id)
        ->pluck('pref_id')
        ->first();
    }
}
