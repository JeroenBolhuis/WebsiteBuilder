<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\SocialAccount;

class FooterController extends Controller
{
    public function index()
    {
        return view('footer.index', [
            'footer' => Footer::firstOrNew(),
            'socials' => SocialAccount::all()
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'title' => ['required', 'string', 'max:55'],
            'content' => ['required'],
            'enabled' => [],
            'image_id' => ['integer', 'nullable']
        ]);

        $footer = Footer::firstOrNew();
        $footer->fill($data);

        $footer->enabled = isset($data['enabled']);
        $footer->image_id = $data['image_id'];

        $footer->save();

        return redirect()->route('footer.index')->with('success', 'De footer is succesvol bijgewerkt.');
    }
}
