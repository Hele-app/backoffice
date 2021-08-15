<?php

namespace App\Models;

use App\Http\Wrapper\HeleApiResource;
use Illuminate\Database\Eloquent\Model;

class Article extends Model implements HeleApiResource
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
     * @return Article
     */
    public static function mapFromResponse(array $data)
    {
        $article = new Article();

        $article->id = $data['id'];
        $article->title = $data['title'];
        $article->filepath = $data['filepath'];

        return $article;
    }
}
