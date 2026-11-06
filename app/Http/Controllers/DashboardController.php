<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return match ($user->role) {
            'pelapor' => redirect()->route('pelapor.dashboard'),
            'wadir_ii' => redirect()->route('wadir.dashboard'),
            'upa' => redirect()->route('upa.dashboard'),
            'teknisi' => redirect()->route('teknisi.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => abort(403, 'Role akun tidak dikenali.'),
        };
    }
}
