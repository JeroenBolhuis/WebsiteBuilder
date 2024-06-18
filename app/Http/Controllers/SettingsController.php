<?php

namespace App\Http\Controllers;

use App\Models\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function updateColor()
    {
        request()->validate([
            'primaryColor' => ['required', 'string', 'max:7', 'min:7'],
            'secondaryColor' => ['required', 'string', 'max:7', 'min:7'],
        ]);

        $settings = Settings::firstOrNew();
        $settings->primary_color = request()->input('primaryColor');
        $settings->secondary_color = request()->input('secondaryColor');
        $settings->save();

        return redirect()->back()->with('success', 'De kleur is succesvol bijgewerkt.');
    }

    public function updateLogo()
    {
        request()->validate([
            'image_id' => ['integer', 'nullable'],
            'use_logo' => ['boolean'],
        ]);

        $settings = Settings::firstOrNew();
        $use_logo = request()->has('use_logo') ? true : false;
        $settings->use_logo = $use_logo;
        $settings->image_id = request()->input('image_id');
        $settings->save();

        return redirect()->back()->with('success', 'Het logo is succesvol bijgewerkt.');
    }


    public function updateFavicon()
    {
        request()->validate([
            'favicon' => ['required', 'mimes:ico', 'max:2048'],
        ]);

        $settings = Settings::firstOrNew();
        $faviconPath = request()->file('favicon')->store('favicons', 'public');
        $settings->favicon = $faviconPath;
        $settings->save();

        return redirect()->back()->with('success', 'De favicon is succesvol bijgewerkt.');
    }
}
