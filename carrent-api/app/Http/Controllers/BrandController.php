<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facedes\Storage;

class BrandController extends Controller
{
    public function __construct(Brand $brand){
        $this->brand = $brand;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = $this->brand->all();
        return response()->json($brands, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->brand->rules(), $this->brand->feedback());

        $image = $request->file('imagem')->store('images', 'public');

        $brand = $this->brand->create([
            'nome' => $request->nome,
            'imagem' => $image
        ]);

        return response()->json($brand, 201);
    }

    /**
     * Display the specified resource.
     * *
     * @param Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = $this->brand->find($id);
        if($brand === null){
            return response()->json(['error' => 'ID does not exist'], 404);
        }
        return response()->json($brand, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Integer
     * @param \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand = $this->brand->find($id);
        if($brand === null){
            return response()->json(['error' => 'ID does not exist'], 404);
        }

        if ($request->method() === 'PATCH') {
            $dynamicRules = array();

            foreach ($brand->rules() as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                   $dynamicRules[$input] = $rule;
                }
            }

            $request->validate($dynamicRules, $this->brand->feedback());
        }else{
            $request->validate($this->brand->rules(), $this->brand->feedback());
        }

        //remove arquivo antigo, caso um novo seja enviado
        if ($request->file('imagem')) {
            Storage::disk('public')->delete($brand->imagem);
        }

        $image = $request->file('imagem')->store('images', 'public');

        $brand->update([
            'nome' => $request->nome,
            'imagem' => $image
        ]);
        return response()->json($brand, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = $this->brand->find($id);
        if($brand === null){
            return response()->json(['error' => 'ID does not exist'], 404);
        }

        Storage::disk('public')->delete($brand->imagem);

        $brand->delete();
        return response()->json(['message' => 'The brand has been removed successfully!'], 200);
    }
}
