<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if ($search) {
            $categories = Category::where('name', 'like', '%' . $search . '%')->whereNull('deleted_at')->get();
        } else {
            $categories = Category::whereNull('deleted_at')->get();
        }
        return $this->sendResponse(CategoryResource::collection($categories), 'Category Record Get SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::whereNull('deleted_at')->find(base64_decode($id));
        if ($category) {
            return $this->sendResponse(new CategoryResource($category), 'Category Record Show SuccessFully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
    }

    public function userCategory(Request $request)
    {
        $categories = explode(',', $request->category_id);
        $user = User::find(auth()->id());
        $user->category()->sync($categories);
        return $this->sendResponse([], 'User Category Added SuccessFully.');
    }
}
