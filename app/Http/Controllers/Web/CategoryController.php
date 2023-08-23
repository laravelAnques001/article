<?php

namespace App\Http\Controllers\Web;

use App\Common\AzureComponent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryList = Category::whereNull('deleted_at')->get();
        return view('Admin.Category.create', compact('categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'parent_id' => 'nullable|exists:categories,id',
        //     'name' => 'required|string|min:3',
        //     'description' => 'nullable|min:3',
        //     'image' => 'nullable|image',
        // ]);
        // if ($validator->fails()) {
        //     return redirect()->route('category.index')->withErrors($validator)->withInput();
        // }
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            // $validated['image'] = $request->image->store('public/category');
            $azure = new AzureComponent();
            $validated['image'] = $azure->store($request->image);
        }
        Category::create($validated);
        return redirect()->route('category.index')->with('success', 'Category Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find(base64_decode($id)) ?? abort(404);
        $categoryList = Category::with('parent')->whereNull('deleted_at')->get();
        return view('Admin.Category.edit', compact('category', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find(base64_decode($id)) ?? abort(404);
        $validated = $request->validated();
        if ($image = $request->image ?? null) {
            $azure = new AzureComponent();
            $oldImage = isset($category->image) ? $category->image : null;
            if ($oldImage) {
                // $fileCheck = storage_path('app/' . $oldImage);
                // if (file_exists($fileCheck)) {
                //     unlink($fileCheck);
                $azure->delete($oldImage);
            }
            // }
            // $validated['image'] = $image->store('public/category');
            $validated['image'] = $azure->store($image);
        }
        $category->fill($validated)->save();
        return redirect()->route('category.index')->with('success', 'Category Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($category) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getCategoryData()
    {
        $data = Category::with('parent')->whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('category.edit', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('category.show', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('category.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->addColumn('date', function ($data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->addColumn('parent_name', function ($data) {
                return $data->parent->name ?? '';
            })
            ->editColumn('image', function ($data) {
                if ($data->image_url) {
                    return '<img src="' . $data->image_url . '" alt="Category" width="60" height="60" class="img-thumbnail">';
                } else {
                    return;
                }
            })
            ->rawColumns(['date', 'action', 'parent_name', 'image'])
            ->addIndexColumn()
            ->toJson();
    }
}
