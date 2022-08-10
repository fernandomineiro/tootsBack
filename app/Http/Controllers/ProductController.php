
<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Product as ProductResource;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return $this->sendResponse(ProductResource::collection($products), 'Produtos recuperados com sucesso.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'voltage' => 'required',
            'brand' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());       
        }
   
        $product = Product::create($input);
   
        return $this->sendResponse(new ProductResource($product), 'Produto criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
  
        if (is_null($product)) {
            return $this->sendError('Produto não encontrado.');
        }
   
        return $this->sendResponse(new ProductResource($product), 'Produto recuperado com sucesso!.');
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
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'voltage' => 'required',
            'brand' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());       
        }
        $product = Product::find($id);   
        $product->name = $input['name'];
        $product->description = $input['description'];
        $product->voltage = $input['voltage'];
        $product->brand = $input['brand'];
        $product->save();
   
        return $this->sendResponse(new ProductResource($product), 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
   
        return $this->sendResponse([], 'Produto deletado com sucesso!.');
    }
}