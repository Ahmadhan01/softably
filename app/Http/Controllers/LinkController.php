<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Models\User;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        $query = Link::with('user');
        $sellerCount = User::where('role', 'seller')->count();
        

        // Filter berdasarkan nama user
        if ($request->has('user') && $request->user != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        $links = $query->latest()->paginate(10);
        return view('view-admin.manage-content-admin', compact('links',  'sellerCount'));
    }

    public function block(Link $link)
    {
        $link->status = 'blocked';
        $link->save();

        return back()->with('success', 'Link telah diblokir.');
    }

    public function activate(Link $link)
    {
        $link->status = 'active';
        $link->save();

        return back()->with('success', 'Link telah diaktifkan kembali.');
    }

    public function destroy(Link $link)
    {
        $link->delete();

        return back()->with('success', 'Link berhasil dihapus.');
    }
}
