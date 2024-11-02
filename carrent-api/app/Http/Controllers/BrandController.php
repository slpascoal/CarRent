<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

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

        $brand = $this->brand->create($request->all());
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

        $brand->update($request->all());
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

        $brand->delete();
        return response()->json(['message' => 'The brand has been removed successfully!'], 200);
    }
}
