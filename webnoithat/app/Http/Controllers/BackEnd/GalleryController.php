<?php

namespace App\Http\Controllers\BackEnd;

use App\Gallery;
use App\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('BackEnd.Gallery.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $product_id = $request->pro_id;
      $gallery = Gallery::where('pro_id',$product_id)->get();
      $gallery_count = $gallery->count();
      $products = Products::find($product_id);
      $output = '';
      if ($gallery_count>0) {
          $i = 0;
          foreach ($gallery as $key => $value) {
              $i++;
              $output .='

              <tr class="gradeA">
                  <td>'.$i.'</td>
                  <td>
                      <img src="'.url('uploads/gallery/'.$value->gallery_image).'"" width="100px" height="100px" class="img-thumbnail">';
                  if($products->product_image != $value->gallery_image){
              $output .='
                      <input type="file" class="file_image form-control" style="width: 40%;" name="file" data-gal_id="'.$value->gallery_id.'" id="file-'.$value->gallery_id.'" accept="image/*" multiple="">';
                  }
              $output .='
                  </td>
                  <td class="center" style="vertical-align: middle;">
                      <button type="button" data-gal_id="'.$value->gallery_id.'" class="btn btn-danger delete-gallery">Delete</button>
                  </td>
              </tr>';
          }
      }else{
          $output .='
              <tr>
                  <td colspan="4" style="text-align:center;font-size:20px;color:red;font-weight:bold;">
                      Sản phẩm chưa có ảnh
                  </td>
              </tr>
          ';
      }
      $output .='

      ';
      return response()->json(['data'=>$output]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if ($request->gal_text) {
          $gal_id = $request->gal_id;
          $gal_text = $request->gal_text;
          $gallery = Gallery::find($gal_id);
          $gallery->gallery_name = $gal_text;
          $gallery->save();

      }else if($request->del_id){
          $del_id = $request->del_id;
          $gallery = Gallery::find($del_id);
          unlink(public_path('uploads/gallery/').$gallery->gallery_image);
          $gallery->delete();

      }else if ($request->up_id) {

          $get_img = $request->file('file');
          $up_id = $request->up_id;
          if ($get_img) {
              $text = $get_img->getClientOriginalExtension();
              $name = rand(0,99).'_'.time().'_'.$get_img->getClientOriginalName();
              $get_img->move(public_path('uploads/gallery'),$name);
              $gallery = Gallery::find($up_id);
              unlink(public_path('uploads/gallery/').$gallery->gallery_image);
              $gallery->gallery_image = $name;

              $gallery->save();
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

      $pro_id = $id;
      Session::put('gallery_session',$pro_id);
      if (Session::get('gallery_session')) {
        $name_product = Products::where('product_id',Session::get('gallery_session'))->first();
      }
      if ($name_product) {
        return view('BackEnd.Gallery.list',compact('pro_id','name_product'));
      }

      return view('BackEnd.Gallery.list',compact('pro_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

      $image = $request->file('file');
      $text = $image->getClientOriginalExtension();
      $name = uniqid().'_'.time().'_'.$image->getClientOriginalName();
      $image->move(public_path('uploads/gallery'),$name);
      $gallery = new Gallery();
      $gallery->gallery_image = $name;
      $gallery->pro_id = $id;
      $gallery->save();

      return response()->json(['success' => $name]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
