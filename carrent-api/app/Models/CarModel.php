<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarModel extends Model
{
    use HasFactory;
    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];

    public function rules () {
        return [
            'marca_id' => 'exists:brands,id',
            'nome' => 'required|unique:brands|min:3',
            'imagem' => 'required|file|mimes:png,jpeg,jpg'
        ];
    }

    public function feedback() {
        return  [
            'required' => 'the attribute field is required',
            'nome.unique' => 'the brand name already exists',
            'imagem.file' => 'the brand image must be a file',
            'imagem.mimes' => 'the brand image must be a png, jpeg or jpg',
            'nome.min' => 'the brand name must have 3 caracters minimiun'
        ];
    }
}
