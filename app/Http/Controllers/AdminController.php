<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\User;

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
        $newUsers = User::select('users.id', 'users.name', 'users.lastname', 'users.created_at')
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
            ->get(0);

        return view('admin.index', ['newUsers' => $newUsers, 'newProducts' => $newProducts]);
    }

    /**
     * Count of users
     */
    public function userCount()
    {
        $usersCount    = User::count();
        return $usersCount;
    }

    /**
     * Count of products
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
    public function create()
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
        //
    }

    /**
     * List all users
     * @return \Illuminate\Http\Response
     */
    public function showUsers()
    {
        $users = User::select('*')->paginate(10);
        return view('admin.showUsers')->with('users', $users);
    }

    /**
     * List all products
     * @return \Illuminate\Http\Response
     */
    public function showProducts()
    {
        $products = Product::select('*')->paginate(10);
        return view('admin.showProducts')->with('products', $products);
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
