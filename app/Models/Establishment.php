<?php

namespace App\Models;

use App\Http\Wrapper\HeleApiResource;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model implements HeleApiResource
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id',
       'name',
       'code',
       'region_id',
   ];

    /**
     * @param array $data provided from the API
     *
     * @return Establishment
     */
    public static function mapFromResponse(array $data)
    {
        $establishment = new Establishment();

        $establishment->id = $data['id'];
        $establishment->name = $data['name'];
        $establishment->code = $data['code'];
        $establishment->region_id = $data['region_id'];

        if (isset($data['region'])) {
            $establishment->region = Region::mapFromResponse($data['region']);
        }

        return $establishment;
    }
}
