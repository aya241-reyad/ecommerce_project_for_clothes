<?php

namespace App\Http\Controllers\Admin;

use App\helpers\Attachment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subcategory;
use App\Models\Category;
use App\Models\SubCat;
use Illuminate\Http\Request;

class SubCatController extends Controller
{
    public function index()
    {
        $categories = SubCat::all();
        return view('subcategory.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Subcategory $request)
    {
        $category = SubCat::create($request->validated());

        if ($request->hasFile('attachment')) {
            Attachment::addAttachment($request->file('attachment'), $category, 'subcategories/image', ['save' => 'original', 'usage' => 'image']);
        }

        return redirect('/subCategories')->with(
            'success',
            'Product Added Successfully'
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $category = SubCat::find($id);
        $categories = Category::all();
        return view('subcategory.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $category = SubCat::find($id);
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,

        ]);
        $old = $category->attachmentRelation[0] ?? null;

        if ($request->hasFile('attachment')) {
            Attachment::updateAttachment($request->attachment, $old, $category, 'categories/image', ['save' => 'original', 'usage' => 'image']);
        }

        return redirect('/subCategories')->with(
            'success',
            'category Edited Successfully'
        );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $category = SubCat::find($id);
        $attachment = $category->attachmentRelation[0];
        $category->delete();
        $attachment->delete();
        return redirect('/subCategories')->with(
            'success',
            'category deleted Successfully'
        );
    }

}