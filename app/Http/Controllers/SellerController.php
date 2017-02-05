<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use Storage, Auth;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ProductRequest;
use Carbon\Carbon;

class SellerController extends Controller
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
        return view('seller.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('seller.createSellerProduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product              = new Product();
        $product->name        = $request->productname;
        $product->description = $request->description;
        $product->stock       = $request->stock;
        $product->amount      = $request->amount;
        $product->save();

        if($product->id > 0)
        {
            if (!empty($_FILES)) {
                $foldername  = 'products';
                $file        = $request->file('file');
                $extension   = $file->getClientOriginalExtension();
                $filename    = $product->id;
                if($extension =='gif' || $extension =='png' || $extension =='jpeg' || $extension =='jpg'){
                    if($filename > 0){
                        Storage::disk('local')->makeDirectory($foldername, 0777);
                        Storage::disk('local')->put($foldername.'/'.$filename.'.'.$extension,  File::get($file));
                    }
                }
                else{
                    $request->session()->flash('filestatus', trans('messages.adminProductImageFormatMessage'));
                }
            }
        }

        $request->session()->flash('status', trans('messages.adminProductCreatedMessage'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = User::find(Auth::user()->id);

        return view('seller.editSellerProfile', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        $user           = User::find(Auth::user()->id);
        $user->name     = $request->name;
        $user->lastname = $request->lastname;
        $user->address  = $request->address;
        $user->pincode  = $request->pincode;
        $user->phone    = $request->phone;
        $user->alias    = str_slug($request->name.' '.$request->lastname.' '.Carbon::now());
        $user->save();
        return response()->json(['profileSellerUpdated' => trans('messages.sellerProfileUpdatedStatus'), 'user' => $user]);
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
