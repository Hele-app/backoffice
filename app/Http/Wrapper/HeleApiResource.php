<?php

namespace App\Http\Wrapper;

interface HeleApiResource
{
    public static function mapFromResponse(array $data);
}
