<?php

namespace App\Http\Controllers\BackEnd;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Category::whereNull('category_sub')->orderBy('category_sorting','ASC')->get())
                ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="edit" data-category_id="'.$data->category_id.'" class="btn btn-outline btn-primary"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->category_id.'" data-category_id="'.$data->category_id.'" class="btn  btn-outline btn-danger delete"><i class="fa fa-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])->make(true);
        }
        $categories = Category::where('category_status',1)
        ->whereNull('category_sub')
        ->with('childrenCategories')
        ->get();

        return view('BackEnd.Category.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            return datatables()->of(Category::whereNotNull('category_sub')->orderBy('category_sorting','ASC')->get())
                ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="edit" data-category_id="'.$data->category_id.'" class="btn btn-outline btn-primary"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->category_id.'" data-category_id="'.$data->category_id.'" class="btn  btn-outline btn-danger delete"><i class="fa fa-trash"></i></button>';
                        return $button;
                })
                ->addColumn('category_parent', function($data){
                    $span = ' '.$data->cateParent->category_name.' ';
                    return $span;
                })
                ->rawColumns(['action','category_parent'])->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'category_name'=>'required',
                'slug_category_product'=>'required',
                'category_status'=>'required',
                'category_icon'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }
            else{
                $category = new Category();
                if ($category) {
                    $category->category_name = $request->category_name;
                    $category->category_slug  = $request->slug_category_product;
                    $category->category_sub = $request->category_sub;
                    $category->category_status = $request->category_status;
                    $category->category_icon = $request->category_icon;
                    $category->category_sorting = count(Category::all())+1;
                    $category->save();

                    return response()->json([
                        'status'=>200,
                        'message'=>'Update Category Successfully',
                    ]);
                }
                else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'Category Not Found',
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $category = Category::findOrFail($id);
            if ($category) {
                return response()->json([
                    'status'=>200,
                    'category'=>$category,
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Category Not Found',
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'category_name'=>'required',
                'slug_category_product'=>'required',
                'category_status'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }
            else{
                $category = Category::findOrFail($id);
                if ($category) {
                    $category->category_name = $request->category_name;
                    $category->category_slug  = $request->slug_category_product;
                    $category->category_sub = $request->category_sub;
                    $category->category_status = $request->category_status;
                    $category->category_icon = $request->category_icon;
                    $category->save();

                    return response()->json([
                        'status'=>200,
                        'message'=>'Update Category Successfully',
                    ]);
                }
                else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'Category Not Found',
                    ]);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category) {
            $category->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Delete Successfully',
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Category Not Found',
            ]);
        }
    }
}
