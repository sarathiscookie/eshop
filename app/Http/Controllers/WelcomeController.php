<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Storage;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::select('*')
            ->orderBy('id', 'desc')
            ->get();
        return view('welcome', ['products' => $products]);
    }

    /**
     * List all products
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $directory = 'products';
        $fileLists = Storage::disk('local')->files($directory);
        foreach ($fileLists as $fileList){
            $fileExplodeSlash = explode('/', $fileList); // ProductsImages/35.jpg
            $fileExploded     = end($fileExplodeSlash); //35.jpg
            $fileNameExplode  = explode('.', $fileExploded);
            $extension        = end($fileNameExplode); //jpg
            $image            = '/'.$directory.'/'.$id.'.'.$extension;
            switch( $extension ) {
                case "gif": $ctype="image/gif"; break;
                case "png": $ctype="image/png"; break;
                case "jpeg":
                case "jpg": $ctype="image/jpeg"; break;
                default:
            }
            if (Storage::exists($image)) {
                $file = storage_path('app').$image;
                return response()->file($file, ['Content-Type' => $ctype]);
            }
        }
    }

    /**
     *
     * Functionality for live search
     */
    public function livesearch(Request $request)
    {
        $products = Product::select('*')
            ->where('name', 'like', urldecode($request->keywords) . '%')
            ->orderBy('id', 'desc')
            ->get();

        if(count($products))
        {
            foreach ($products as $product){
                echo '<div><h3>' .$product->name. '</h3>';
                if($product->stock == 'no'){
                    echo '<span class="label label-danger">Out of stock</span></div>';
                }
            }
        }
        else{
            echo '<h3>No product</h3>';
        }


    }
}
