<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController
{
    public function index(){
        $products = product::all();
        
     if($products ->count() > 0){
         $data =[ 
             'status' => 200,
             'product' => $products
     
             ];
 
         return response()->json($data, 200);
         // return view('studentInfo.index')->with('studentInfo', $students);
 
     }else{
         return response()->json([
             'status' => 404,
             'message' => 'No Product Found'
         ], 404);
     }
 
     
     }

      
    // public function create()
    // {
    //     return view('studentInfo.create');
    // }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product-name' => 'required|string|max:191',
            'price' => 'required|numeric|min:0',
            'quality' => 'required|string|max:255',
            'expiration-date' => 'required|date_format:Y-m-d',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10000',
            'quantity' => 'nullable|integer|min:0',
        ]);
    
        $validator->sometimes('sales', 'integer|min:0', function ($input) {
            return $input->sales !== null;
        });
    
        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ],422);
        } else {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            try {
                $image->storeAs('public/images/products', $imageName);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Error uploading image file'
                ], 500);
            }
            $imageUrl = url('/'). '/storage/images/products/'.$imageName;
    
            $productData = [
                'product-name' => $request->input('product-name'),
                'price' => $request->input('price'),
                'quality' => $request->input('quality'),
                'expiration-date' => $request->input('expiration-date'),
                'image' => $imageUrl,
                'quantity' => $request->input('quantity', 1), 
            ];
    
            if ($request->has('sales')) {
                $productData['sales'] = $request->input('sales');
            }
    
            $product = Product::create($productData);
    
            if($product){
                return response()->json([
                    'status' => 200,
                    'message' => 'Product added successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong!'
                ], 500);
            }
        }
    }
    
    
    



    
    public function show($id)
    {
        $products = product::find($id);

        if($products){
            return response()->json([
                'status' => 200,
                'product' => $products
            ], 200);
            
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Product Not Found :('
            ], 404);
            

        }

        
    }

    public function edit($id){
        $products = product::find($id);

        if($products){
            return response()->json([
                'status' => 200,
                'product' => $products
            ], 200);
            
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Product Not Found :('
            ], 404);
            

        }

    }


    // Notice: place recheck the Update because it always return the serve status 422 from the Postman.
public function update(Request $request, int $id)
{
   // \Log::info('Request payload:', ['payload' => $request->all()]);

    $validator = Validator::make($request->all(), [
        'product-name' => 'required|string|max:191',
        'price' => 'required|numeric|min:0',
        'quality' => 'required|string|max:255',
        'expiration-date' => 'required|date_format:Y-m-d',
        // 'image' => 'required|image|mimes:jpeg,png,jpg|max:10000',
        'quantity' => 'nullable|integer|min:0',
        'sales' => 'nullable|integer|min:0',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'error' => $validator->messages()
        ], 422);
    }

    $product = product::find($id);

    if (!$product) {
        return response()->json([
            'status' => 404,
            'message' => 'Product Not Found! :(',
        ], 404);
    }

    $product->update($request->only([
        'product-name',
        'quantity',
        'price',
        'quality',
        'expiration-date',
        'sales',
    ]));

    // check if a new image has been uploaded

    // if ($request->hasFile('image')) {
    //     $image = $request->file('image');
    //     $imageName = time() . '.' . $image->getClientOriginalExtension();
    //     $imagePath = public_path('/images/products');
    //     $image->storeAs('public/images/products', $imageName);
    //     $imageUrl = url('/') . 'storage/images/products/' . $imageName;
    //     $product->update(['image' => $imageUrl]);
    // }

    return response()->json([
        'status' => 200,
        'message' => 'Product Updated Successfully',
    ], 200);
}

    

    

public function destroy($id){
    $products = product::find($id);
    if($products){
        $products->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Product deleted successfully'
        ]);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'Product not found'
        ], 404);
    }
}




// Added API for updating the quantity only
public function updatequantity(Request $request, $id) {
    $validator = Validator::make($request->all(), [
        'quantity' => 'required|integer|min:0'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'error' => $validator->messages()
        ], 422);
    } else {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ], 404);
        }

        $product->quantity = $request->input('quantity');
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully'
        ], 200);
    }
}




























}
