<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $original_img = $request->image->store('/images','s3','public');
            $original_img_url = Storage::disk('s3')->url($original_img);

            $img_resize_lg = Image::make($request->image);
            $img_resize_lg->resize(1024, 600)->stream();

            $large_img = 'large_' . $request->image->getClientOriginalName();
            Storage::disk('s3')->put('images-lg/'.$large_img, $img_resize_lg);
            $large_img_url = Storage::disk('s3')->url('images-lg/'.$large_img);

            $img_resize_md = Image::make($request->image);
            $img_resize_md->resize(800, 400)->stream();

            $medium_img = 'medium_'.$request->image->getClientOriginalName();
            Storage::disk('s3')->put('images-md/'.$medium_img, $img_resize_md);
            $medium_img_url = Storage::disk('s3')->url('images-md/'.$medium_img);

            $img_resize_sm = Image::make($request->image);
            $img_resize_sm->resize(215, 80)->stream();

            $small_img = 'small_' . $request->image->getClientOriginalName();
            Storage::disk('s3')->put('images-sm/'.$small_img, $img_resize_sm);
            $small_img_url = Storage::disk('s3')->url('images-sm/'.$small_img);

          $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'original_img' => basename($original_img),
                'original_img_url' => $original_img_url,
                'large_img' => basename($large_img),
                'large_img_url' => $large_img_url,
                'medium_img' => basename($medium_img),
                'medium_img_url' => $medium_img_url,
                'small_img' => basename($small_img),
                'small_img_url' => $small_img_url,
            ]);

            return response()->json([
                'message' => 'Sukses upload file/image',
                'status' => '200',
                'data' => $product,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed',
                'status' => $th,
            ],400);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
