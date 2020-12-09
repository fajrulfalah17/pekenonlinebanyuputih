<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSettingController extends Controller
{
    public function store()
    {
        $user = Auth::user();
        $categories = Category::all();

        return view('pages.dashboard-settings-store', [
            'user' => $user,
            'categories' => $categories
        ]);
    }
    public function account()
    {
        $user = Auth::user();

        return view('pages.dashboard-settings-account', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $redirect)
    {
        $data = $request->all();
        $item = Auth::user();

        $item->update($data);

        // kenapa routing nya redirect karena ketika dia sudah update data maka dia akan dikembalikan ke halaman sebelumnya yang dia edit
        return redirect()->route($redirect);
    }
}