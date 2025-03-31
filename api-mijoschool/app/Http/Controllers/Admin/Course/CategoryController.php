<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Http\Resources\Course\Category\CategoryCollection;
use App\Http\Resources\Course\Category\CategoryResource;
use App\Models\Course\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $state = $request->state;

        $categories = Category::filterAdvance($search, $state)->orderby("id", "desc")->get();

        return response()->json([
            "categories" => CategoryCollection::make($categories),
        ]);
    }


    public function store(Request $request)
    {
        if ($request->hasFile("portada")) {
            $path = Storage::putFile("categories", $request->file("portada"));
            $request->request->add(["image" => $path]);
        }
        $category = Category::create($request->all());
        return response()->json(["category" => CategoryResource::make($category)]);
    }


    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($request->hasFile("portada")) {
                if ($category->image) {
                    Storage::delete($category->image);
                }
                $path = Storage::putFile("categories", $request->file("portada"));
                $request->request->add(["image" => $path]);
            }

            $category->update($request->all());
            return response()->json(["category" => CategoryResource::make($category)]);
        } catch (ModelNotFoundException $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            if ($category->image) {
                Storage::delete($category->image);
            }
            $category->delete();
            return response()->json(["message" => 200]);
        } catch (ModelNotFoundException $th) {
            //throw $th;
        }
    }
}
