<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Template;
use App\Models\TemplateCategory;
use Illuminate\Validation\Rule;
use App\Observers\LogObserver;

class PageController extends SoftDeletesController
{

    public function __construct()
    {
        parent::__construct(Page::class);
    }

    public function show(string $slug = null)
    {
        if (auth()->user()) {
            $page = Page::slug($slug)->first();
        } else {
            $page = Page::slug($slug)->active()->first();
        }

        if (!$page) {
            return view('errors.404');
        }

        $page->templates->each(function ($template) {
            $template->pivot->data = json_decode($template->pivot->data);
        });

        return view('page.show', compact('page'));
    }

    public function savePreviewData(Page $page)
    {
        session()->put('page_preview_data', json_encode(request()->data));

        if (session()->has('page_preview_data')) {
            return response()->json(['status' => 'success', 'message' => 'Preview data saved!', 'url' => route('page.preview', $page)]);
        }

        return response()->json(['status' => 'error'], 500);
    }

    public function preview(Page $page)
    {
        $data = json_decode(session()->get('page_preview_data'), true);

        if (!$data) {
            return view('errors.404', ['message' => 'Er zijn geen preview gegevens gevonden. Voeg een template toe en probeer het opnieuw.']);
        }

        $page->templates->each(function ($template) use ($data) {
            $data[$template->pivot->id] = (object) ($data[$template->pivot->id] ?? []);

            $template->pivot->data = $data[$template->pivot->id] ?? json_decode($template->pivot->data);
        });

        return view('page.show', compact('page'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $newPage = Page::create($this->validatePage());

        if (!Page::where('isHomepage', true)->exists()) {
            $newPage->isHomepage = true;
            $newPage->save();
        }

        return redirect()->route('page.edit', $newPage)->with('success', 'De pagina is succesvol aangemaakt.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $page->templates->each(function ($template) {
            $template->pivot->data = json_decode($template->pivot->data);
        });

        $urls = $this->extractUrl($page);

        $categories = TemplateCategory::all();

        $extraCategory = new TemplateCategory([
            'id' => $categories->max('id') + 1,
            'name' => 'Overige',
            'templates' => Template::whereNull('template_category_id')->get()
        ]);

        $categories->push($extraCategory);

        return view('page.edit', compact('page', 'categories', 'urls'));
    }

    public static function extractUrl($page)
    {
        $html = view('page.show', compact('page'))->render();

        $regexMain = "/<main.*?>.*?<\/main>/s";
        $regexUrl = '/(?<=href=\").*?(?=\")/';

        preg_match($regexMain, $html, $main);
        preg_match_all($regexUrl, $main[0], $urls);

        if (!$page->isActive) array_shift($urls[0]);

        return $urls[0];
    }

    public function getLinkedPages($id)
    {
        $page = Page::findOrFail($id);

        $page->templates->each(function ($template) use (&$urls) {
            $template->pivot->data = json_decode($template->pivot->data);
        });

        return response()->json(['urls' => $this->extractUrl($page)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Page $page)
    {
        $page->update($this->validatePage($page->id));

        return redirect()->route('page.edit', ['page' => $page])->with('success', 'De pagina is succesvol aangepast.');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Page::findOrFail($id)->delete();
        return redirect()->route('page.index')->with('success', 'De pagina is succesvol verwijderd.');
    }

    /**
     * Set the specified page as homepage.
     */
    public function setHomepage(string $pageId)
    {
        Page::where('isHomepage', true)->update(['isHomepage' => false]);

        $page = Page::findOrFail((int) $pageId);
        $page->isHomepage = true;
        $page->save();

        return response()->json(['status' => 'success', 'message' => 'De landingspagina is aangepast.']);
    }

    public function addTemplateToPage()
    {
        $page = Page::find(request()->pageId);
        $template = Template::find(request()->templateId);

        $data = [];
        foreach ($template->inputNames as $input_name) {
            $data[$input_name] = '';
        }

        $order = $page->templates()->count() > 0 ? $page->templates()->max('order') + 1 : 1;

        $page->templates()->attach($template, ['order' => $order, 'data' => json_encode($data)]);

        $pageTemplateId = $page->templates()->wherePivot('template_id', $template->id)->get()->last()->pivot->id;

        LogObserver::logPivotAction('page_templates', $pageTemplateId, 'created', [], [
            'order' => $order,
            'page_id' => $page->id,
            'template_id' => $template->id,
            'data' => $data,
        ]);

        return response()->json(['message' => 'Added template succesfully to page!']);
    }

    public function updateTemplateData(Page $page)
    {
        $requestData = request()->except(['_token', 'page_template_id']);

        $template = $page->templates()->wherePivot('id', request()->page_template_id)->first();

        $data = [];
        foreach ($template->inputNames as $input_name) {
            $data[$input_name] = $requestData[$input_name] ?? "";
        }

        LogObserver::logPivotAction(
            'page_templates',
            $template->pivot->id,
            'updated',
            json_decode($template->pivot->data),
            $data
        );

        $template->pivot->data = $data;
        $template->pivot->save();

        return response()->json(['status' => 'success', 'message' => 'Template succesvol geupdatet!']);
    }

    public function moveTemplate()
    {
        $page = Page::find(request()->page_id);
        $template = $page->templates()->wherePivot('id', request()->pivot_id)->first();

        $templateOrder = $template->pivot->order;
        $direction = request()->direction;
        $toTemplate = $page->templates()->wherePivot('order', ($direction == 'up' ? $templateOrder - 1 : $templateOrder + 1))->first();

        if (!$toTemplate) {
            return response()->json(['message' => "Template can't be moved $direction"]);
        }

        $template->pivot->order = $toTemplate->pivot->order;
        $template->pivot->save();

        LogObserver::logPivotAction(
            'page_templates',
            $template->pivot->id,
            'updated',
            [
                'order' => $templateOrder,
            ],
            [
                'order' => $toTemplate->pivot->order,
            ]
        );

        $toTemplate->pivot->order = $templateOrder;
        $toTemplate->pivot->save();


        return response()->json(['to_pivot' => $toTemplate->pivot->id]);
    }

    public function removeTemplate()
    {
        $page = Page::find(request()->page_id);
        $template = $page->templates()->wherePivot('id', request()->pivot_id)->first();

        $deletedOrder = $template->pivot->order;

        $template->pivot->delete();

        $page->templates()->wherePivot('order', '>', $deletedOrder)->decrement('order');

        LogObserver::logPivotAction(
            'page_templates',
            $template->pivot->id,
            'deleted',
            [
                'order' => $deletedOrder,
                'page_id' => $page->id,
                'template_id' => $template->id,
                'data' => json_decode($template->pivot->data)
            ],
            []
        );

        return response()->json(['message' => 'Removed template successfully!']);
    }
}
