<?php

namespace App\Models;

use App\Http\Wrapper\HeleApiResource;
use Illuminate\Database\Eloquent\Model;

class Region extends Model implements HeleApiResource
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'latitude',
        'longitude',
        'latitudeDelta',
        'longitudeDelta',
    ];

    /**
     * @param array $data provided from the API
     *
     * @return Region
     */
    public static function mapFromResponse(array $data)
    {
        $region = new Region();

        $region->id = $data['id'];
        $region->name = $data['name'];
        $region->latitude = $data['latitude'];
        $region->longitude = $data['longitude'];
        $region->latitudeDelta = $data['latitude_delta'];
        $region->longitudeDelta = $data['longitude_delta'];

        return $region;
    }
}
