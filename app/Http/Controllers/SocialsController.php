<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;

class SocialsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('footer.social.create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:55'],
            'url' => ['nullable'],
            'icon' => ['required']
        ]);

        SocialAccount::create($data);

        return redirect()->route('footer.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $social = SocialAccount::where(['id' => $id])->first();

        return view('footer.social.edit', ['social' => $social]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id)
    {
        $data = request()->validate([
            'name' => ['required'],
            'url' => ['nullable'],
            'icon' => ['nullable']
        ]);

        $data['url'] = request('url', '');
        $data['icon'] = request('icon', '');

        $social = SocialAccount::findOrFail($id);
        $social->fill($data)->save();

        return redirect()->route('footer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        SocialAccount::where(['id' => $id])->delete();

        return Redirect()->route('footer.index');
    }
}
