<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleItem;
use App\Models\Law;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Law $law, Article $article)
    {
        return view('items.create', compact('law', 'article'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Law $law, Article $article)
    {
        $request->merge(['item_is_informative' => $request->has('item_is_informative')]);
        $valid = $request->validate([
            'item_title' => 'required|string|max:255',
            'item_description' => 'nullable|string|max:255',
            'item_is_informative' => 'required|boolean',
        ]);
        $article->items()->save(new ArticleItem($valid));

        return redirect(route('articles.show', ['law' => $law, 'article' => $article]));
    }

    /**
     * Display the specified resource.
     */
    public function show(ArticleItem $item)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Law $law, Article $article, ArticleItem $item)
    {
        return view('items.edit', compact('law', 'article', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Law $law, Article $article, ArticleItem $item)
    {
        $request->merge(['item_is_informative' => $request->has('item_is_informative')]);
        $valid = $request->validate([
            'item_title' => 'required|string|max:255',
            'item_description' => 'nullable|string|max:255',
            'item_is_informative' => 'required|boolean',
        ]);
        $item->update($valid);
        return redirect(route('articles.show', ['law' => $law, 'article' => $article]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Law $law, Article $article, ArticleItem $item)
    {
        $item->delete();
        return redirect(route('articles.show', ['law' => $law, 'article' => $article]));
    }


    public function validateItems(Request $request, Law $law, Article $article, ArticleItem $item)
    {

        dd($request->all());
        $request->validate([
            'items' => 'required|array',
            'items.*.item_title' => 'required|string|max:255',
            'items.*.item_description' => 'nullable|string|max:255',
            'items.*.item_is_informative' => 'required|boolean',
        ]);


    }



}
