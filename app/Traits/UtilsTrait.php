<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait UtilsTrait {
    public function jsonEncode(mixed $data, int $flags = 0, int $depth = 512): false|string
    {
        $flags |= JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        return json_encode($data, $flags, $depth);
    }
}
