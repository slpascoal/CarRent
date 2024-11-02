<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules () {
        return [
            'nome' => 'required|unique:brands',
            'imagem' => 'required'
        ];
    }

    public function feedback() {
        return  [
            'required' => 'the attribute field is required',
            'nome.unique' => 'the brand name already exists'
        ];
    }
}
