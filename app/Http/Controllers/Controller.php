<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base Controller aplikasi.
 * Pastikan semua controller lain 'extends Controller' ini
 * agar method middleware() tersedia.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
