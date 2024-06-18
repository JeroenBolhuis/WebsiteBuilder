<?php

namespace App\Http\Controllers;

use App\Models\NavItem;
use App\Models\Page;
use Illuminate\Validation\Rule;

class NavController extends Controller
{
    public function index()
    {
        $navItems = NavItem::with('page')->orderBy('order')->get();

        return view('nav.index', [
            'navItems' => $navItems,
        ]);
    }

    public function create(string $id = null)
    {
        return view('nav.create', [
            'pages' => Page::active()->orderBy('isRegularPage', 'desc')->get()->groupBy('isRegularPage'),
            'parent' => $id,
        ]);
    }

    public function store()
    {
        $maxOrder = NavItem::where('parent_id', request()->parent_id)->max('order');
        $maxOrder = $maxOrder === null ? 0 : $maxOrder;

        $data = $this->validateNavItem();
        $data['order'] = $maxOrder + 1;

        NavItem::create($data);

        return redirect()->route('nav.index')->with('success', 'Navigatie item succesvol aangemaakt.');
    }

    public function edit(string $id)
    {
        return view('nav.edit', [
            'navItem' => NavItem::findOrFail($id),
            'pages' => Page::active()->orderBy('isRegularPage', 'desc')->get()->groupBy('isRegularPage'),
        ]);
    }

    public function update(string $id)
    {
        $navItem = NavItem::findOrFail($id);

        $data = $this->validateNavItem($id);

        if ($data['isExternal']) $data['page_id'] = null;
        else $data['url'] = null;

        $navItem->update($data);

        return redirect()->route('nav.index')->with('success', 'Navigatie item succesvol bijgewerkt.');
    }

    public function destroy(string $id)
    {
        NavItem::findOrFail($id)->delete();
        return redirect()->route('nav.index')->with('success', 'Navigatie item succesvol verwijderd.');
    }


    private function validateNavItem($navItemId = null)
    {
        $validator = validator()->make(request()->all(), [
            'name' => ['required', 'string', 'max:55'],
            'isExternal' => ['nullable', 'in:on'],
            'parent_id' => ['nullable', Rule::exists('nav_items', 'id')->where(function ($query) use ($navItemId) {
                $query->where('id', $navItemId)->orWhere('parent_id', null);
            })],
        ]);

        $validator->sometimes('url', ['url'], function ($input) {
            return $input->isExternal;
        });

        $validator->sometimes('page_id', ['nullable', 'exists:pages,id'], function ($input) {
            return !$input->isExternal;
        });

        $validatedData = $validator->validate();

        $validatedData['isExternal'] = isset($validatedData['isExternal']) && $validatedData['isExternal'] ? true : false;

        return $validatedData;
    }

    public function moveNavItem()
    {
        $direction = request()->direction;

        $navItem = NavItem::find(request()->id);
        $maxOrder = NavItem::where('parent_id', $navItem->parent_id)->max('order');

        if ($navItem->order > 1 && $direction == 'up') {
            // Swap orders with the previous item
            $previousNavItem = NavItem::where('parent_id', $navItem->parent_id)
                ->where('order', $navItem->order - 1)
                ->first();

            if ($previousNavItem) {
                $navItem->update(['order' => $navItem->order - 1]);
                $previousNavItem->update(['order' => $previousNavItem->order + 1]);
            }
        } elseif ($navItem->order < $maxOrder && $direction == 'down') {
            // Swap orders with the next item
            $nextNavItem = NavItem::where('parent_id', $navItem->parent_id)
                ->where('order', $navItem->order + 1)
                ->first();

            if ($nextNavItem) {
                $navItem->update(['order' => $navItem->order + 1]);
                $nextNavItem->update(['order' => $nextNavItem->order - 1]);
            }
        }

        return redirect()->route('nav.index')->with('success', 'Navigation item deleted successfully.');
    }
}
