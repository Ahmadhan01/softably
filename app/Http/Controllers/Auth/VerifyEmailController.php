<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, $id, $hash)
    {
        // Sementara kita hanya tampilkan respons sederhana
        return response("Verifikasi email berhasil untuk ID: {$id}, Hash: {$hash}");
    }
}
