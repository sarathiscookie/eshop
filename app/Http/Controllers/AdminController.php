<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Roleuser;
use App\Http\Requests\AdminUserRequest;
use App\Http\Requests\AdminProductRequest;
use Carbon\Carbon;
use Storage, File;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //new 5 user
        $newUsers = User::select('users.*', 'roles.role', 'roles.id AS roleID')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->orderBy('id', 'desc')
            ->where('roles.role', '<>', 'admin')
            ->take(5)
            ->get();

        //new 5 products
        $newProducts = Product::select('id', 'name', 'amount', 'stock', 'created_at')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('admin.index', ['newUsers' => $newUsers, 'newProducts' => $newProducts]);
    }

    /**
     * Count of users for left sidebar
     */
    public function userCount()
    {
        $usersCount    = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.role', '<>', 'admin')
            ->count();
        return $usersCount;
    }

    /**
     * Count of products for left sidebar
     */
    public function productCount()
    {
        $productsCount    = Product::count();
        return $productsCount;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUsers()
    {
        return view('admin.createUser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUser(AdminUserRequest $request)
    {
        $user = new User();
        $user->name     = $request->name;
        $user->lastname = $request->lastname;
        $user->address  = $request->address;
        $user->pincode  = $request->pincode;
        $user->phone    = $request->phone;
        $user->email    = $request->email;
        $user->alias    = str_slug($request->name.' '.$request->lastname.' '.Carbon::now());
        $user->password = bcrypt($request->password);
        $user->save();

        $roleId = Role::select('id', 'role')
            ->where('role', $request->role)
            ->first();

        Roleuser::create([
            'user_id' => $user->id,
            'role_id' => $roleId->id,
        ]);
        $request->session()->flash('status', trans('messages.adminUserCreatedMessage'));
        return redirect()->back();
    }

    /**
     * List all users
     * @return \Illuminate\Http\Response
     */
    public function showUsers()
    {
        $users = User::select('users.*', 'roles.role', 'roles.id AS roleID')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->orderBy('id', 'desc')
            ->where('roles.role', '<>', 'admin')
            ->paginate(10);

        return view('admin.showUsers')->with('users', $users);
    }

    /**
     * List all products
     * @return \Illuminate\Http\Response
     */
    public function showProducts()
    {
        $products = Product::select('*')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.showProducts')->with('products', $products);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProducts()
    {
        return view('admin.createProduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProduct(AdminProductRequest $request)
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
    public function destroyUser($id)
    {
        Roleuser::where('user_id', $id)->delete();
        User::find($id)->delete();
        return redirect()->route('listUsers')->with('deleteSuccess', trans('messages.adminUserDeleteMessage'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyProduct($id)
    {
        Product::find($id)->delete();

        /* Checking product related images. If images exist it will delete*/
        $directory = 'products';
        $fileLists = Storage::disk('local')->files($directory);
        foreach ($fileLists as $fileList){
            $fileExplodeSlash = explode('/', $fileList); // ProductsImages/35.jpg
            $fileExploded     = end($fileExplodeSlash); //35.jpg
            $fileNameExplode  = explode('.', $fileExploded);
            $extension        = end($fileNameExplode); //jpg
            $image            = 'products/'.$id.'.'.$extension;
            if (Storage::exists($image)) {
                Storage::delete($image);
            }
        }
        
        return redirect()->route('listUsers')->with('deleteSuccess', trans('messages.adminProductDeleteMessage'));
    }
}
