<?php

namespace App\Models;

use App\Http\Wrapper\HeleApiResource;
use Illuminate\Database\Eloquent\Model;

class Advice extends Model implements HeleApiResource
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id',
       'title',
       'filepath',
   ];

    /**
     * @param array $data provided from the API
     *
     * @return Advice
     */
    public static function mapFromResponse(array $data)
    {
        $advice = new Advice();

        $advice->id = $data['id'];
        $advice->quote = $data['quote'];

        return $advice;
    }
}
