<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // raw sql
        // $categories = DB::select('SELECT * FROM categories');

        //Query Buidker 
        // $categories = DB::table('categories')->get();
        
        //Eloquent ORM
        // $categories = Category::all();
        $categories = Category::orderBy('id', 'desc')->get();

        // dd($categories);
        return view('categories.list', compact('categories'));
    }

   
    public function create()
    {

        return view('categories.create');
    }

 
    public function store()
    {
    
        Category::create(
            [
                'name' => request()->name,
                'desc' => request()->desc,
                'is_active' => request()->has('is_active') ? true : false,
            ]
        );
        return redirect('/categories');
    }


    public function edit(string $id)
    {

        $category = category::find($id);
        // dd($category);
        return view('categories.edit', compact('category'));
    }

    public function update($id)
    {
        // dd($id);
        // dd(request()->all());
        $category = Category::find($id);
        $category->update(
            [
                'name' => request()->name,
                'desc' => request()->desc,
                'is_active' => request()->has('is_active') ? true : false,
            ]
        );
        return redirect('categories');
        
    }
    public function destroy($id)
    {
        // dd($id);
        $category = Category::find($id);
        $category ->delete();
        return redirect('/categories');
    }


    
}
