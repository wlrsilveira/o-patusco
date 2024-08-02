<?php

namespace App\Http\Resources;

use App\Http\Traits\FormatFieldsTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class AbstractResource extends JsonResource
{
    use FormatFieldsTrait;
}
