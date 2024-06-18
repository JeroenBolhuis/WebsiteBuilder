<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\Page;
use Illuminate\Validation\Rule;
use App\Models\Template;
use App\Models\TemplateCategory;
use App\Http\Controllers\PageController;

class SponsorController extends SoftDeletesController
{
    public function __construct()
    {
        parent::__construct(Sponsor::class);
    }

    public function index()
    {
        return view('sponsors.index', [
            'sponsors' => Sponsor::all(),
        ]);
    }

    public function create()
    {
        return view('sponsors.create');
    }

    public function store()
    {
        $sponsorParams = $this->validateSponsor();

        $newPage = Page::create($this->validatePage());
        $newPage->isRegularPage = false;
        $newPage->save();

        $newSponsor = new Sponsor();
        $newSponsor->name = $sponsorParams['title'];
        $newSponsor->image_id = $sponsorParams['image_id'];
        $newSponsor->page_id = $newPage->id;

        $newSponsor->save();

        return redirect()->route('sponsors.edit', $newSponsor)->with('success', 'De sponsor is succesvol aangemaakt.');
    }

    public function edit(Sponsor $sponsor)
    {
        $page = $sponsor->page;
        $page->templates->each(function ($template) {
            $template->pivot->data = json_decode($template->pivot->data);
        });

        $urls = PageController::extractUrl($page);

        $categories = TemplateCategory::all();

        $extraCategory = new TemplateCategory([
            'id' => $categories->max('id') + 1,
            'name' => 'Overige',
            'templates' => Template::whereNull('template_category_id')->get()
        ]);

        $categories->push($extraCategory);

        return view('sponsors.edit', compact('sponsor', 'page', 'categories', 'urls'));
    }

    public function update(Sponsor $sponsor)
    {
        $sponsorParams = $this->validateSponsor();

        $page = $sponsor->page;
        $page->update($this->validatePage($page->id));

        $sponsor->name = $sponsorParams['title'];
        $sponsor->image_id = $sponsorParams['image_id'];
        $sponsor->save();

        return redirect()->route('sponsors.index')->with('success', 'De sponsor is aangepast.');
    }

    private function validateSponsor()
    {
        return request()->validate([
            'title' => ['required', 'string', 'max:55'],
            'image_id' => 'required',
        ]);
    }

    private function validatePage($pageId = null)
    {
        $parameters = request()->validate([
            'title' => ['required', 'string', 'max:55'],
            'slug' => ['required', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i', Rule::unique('pages')->ignore($pageId ?? 0)],
            'isActive' => ['nullable', 'in:on']
        ]);

        $parameters['isActive'] = isset($parameters['isActive']) && $parameters['isActive'] ? true : false;

        return $parameters;
    }

    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();
        $sponsor->page->delete();

        return redirect()->route('sponsors.index')->with('success', 'De sponsor is verwijderd.');
    }

    public function restore($id)
    {
        $model = $this->model::withTrashed()->find($id);
        if ($model) {
            $model->restore();
            $model->page()->withTrashed()->restore();
        }

        return redirect()->route('trash.index');
    }

    public function destroyPermanently($id)
    {
        $model = $this->model::withTrashed()->find($id);
        if ($model) {
            $model->forceDelete();
            $model->page()->withTrashed()->forceDelete();
        }

        return redirect()->route('trash.index')->with('success', 'Je hebt de gegevens permanent verwijderd!');
    }
}
