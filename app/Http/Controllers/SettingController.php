<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        // For now, we'll just flash a success message as settings might be stored in a config file or DB
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }
}
