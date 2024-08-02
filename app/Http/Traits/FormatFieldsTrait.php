<?php
namespace App\Http\Traits;

use Carbon\Carbon;

trait FormatFieldsTrait
{
    public function formatTimestampBr(?string $date) : ?string
    {
        return Carbon::make($date)?->format('d/m/Y H:i:s');
    }

    public function formatDateBr(?string $date) : ?string
    {
        return Carbon::make($date)?->format('d/m/Y');
    }

    public function formatDateYearMonth(?string $date) : ?string
    {
        return Carbon::make($date)?->format('m.Y');
    }
}
