<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'church_name' => Setting::getValue('church_name', 'SDA Church'),
            'church_address' => Setting::getValue('church_address', ''),
            'church_phone' => Setting::getValue('church_phone', ''),
            'church_email' => Setting::getValue('church_email', ''),
            'currency' => Setting::getValue('currency', 'TZS'),
            'fiscal_year_start' => Setting::getValue('fiscal_year_start', '01'),
            'email_notifications' => Setting::getValue('email_notifications', '1'),
            'auto_backup' => Setting::getValue('auto_backup', '0'),
        ];

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'church_name' => 'nullable|string|max:255',
            'church_address' => 'nullable|string',
            'church_phone' => 'nullable|string|max:20',
            'church_email' => 'nullable|email|max:255',
            'currency' => 'nullable|string|max:10',
            'fiscal_year_start' => 'nullable|string|max:2',
            'email_notifications' => 'nullable|string',
            'auto_backup' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }
}
