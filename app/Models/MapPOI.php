<?php

namespace App\Models;

use App\Http\Wrapper\HeleApiResource;
use Illuminate\Database\Eloquent\Model;

class MapPOI extends Model implements HeleApiResource
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'address',
        'zipcode',
        'city',
        'hour',
        'phone',
        'site',
        'latitude',
        'longitude',
        'region_id',
    ];

    /**
     * @param array $data provided from the API
     *
     * @return MapPOI
     */
    public static function mapFromResponse(array $data)
    {
        $poi = new MapPOI();

        $poi->id = $data['id'];
        $poi->name = $data['name'];
        $poi->description = $data['description'];
        $poi->address = $data['address'];
        $poi->zipcode = $data['zipcode'];
        $poi->city = $data['city'];
        $poi->hour = $data['hour'];
        $poi->phone = $data['phone'];
        $poi->site = $data['site'];
        $poi->latitude = $data['latitude'];
        $poi->longitude = $data['longitude'];
        $poi->region_id = $data['region_id'];

        if (isset($data['region'])) {
            $poi->region = Region::mapFromResponse($data['region']);
        }

        return $poi;
    }
}
