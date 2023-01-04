<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
      public function index()
      {
        $products= Product::all();
       // dd($products);
       return view('products.index',compact('products'));
      }
       public function create()
       {
        return view('products.create');
       }

       public function show($product)
      {
        $product=  Product::where('id',$product)->get();
        return view('products.show',compact('product'));
      }
       public function edit( $product)
       {
      $product=  Product::where('id',$product)->get();
        // dd($product);

        return view('products.edit',compact('product'));
       }
       public function store(Request $request)
       {
             // dd($request->image->extension());
              $request->validate([
                'name'=>'required',
                'detail'=>'required',
                'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
              ]);

              $newImageName= time().'.'.$request->image->extension();
              $request->image->move(public_path('images'),$newImageName);

              Product::create([
                'name'=>$request->input('name'),
                'detail'=>$request->input('detail'),
                'image'=>$newImageName
              ]);

              return redirect()->route('products.index')->with('success','Product created successfully');

       }
       public function update(Request $request,$product)
       {
            //dd($product);
            $request->validate([
                'name'=>'required',
                'detail'=>'required',
                'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
              ]);




                $newImageName= time().'.'.$request->image->extension();
              $request->image->move(public_path('images'),$newImageName);




            Product::where('id',$product)->update(array(
                'name' => $request->input('name'),
                'detail'=>$request->input('detail'),
                'image'=>$newImageName

                        ));

            return redirect()->route('products.index')
            ->with('success','Product updated successfully');
       }
       public function destroy( $product)
       {

        Product::where('id',$product)->delete();


           return redirect()->route('products.index')
                           ->with('success','Product deleted successfully');
       }
}
