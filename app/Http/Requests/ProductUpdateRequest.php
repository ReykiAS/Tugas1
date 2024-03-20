<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required',
            'stock'=> 'required|integer',
            'price'=> 'required|integer',
            'description'=>'required|string',
            'brand_id'=>'required|integer',
            'category_id'=>'required|integer',
            'user_id'=>'required|integer',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
        ];
    }
    public function messages():array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'stock.required' => 'Stok harus diisi',
            'stock.integer' => 'Stok harus berupa angka',
            'price.required' => 'Harga harus diisi',
            'price.integer' => 'Harga harus berupa angka',
            'description.required' => 'Deskripsi harus diisi',
            'description.string' => 'Deskripsi harus berupa teks',
            'brand_id.required' => 'ID Merek harus diisi',
            'brand_id.integer' => 'ID Merek harus berupa angka',
            'category_id.required' => 'ID Kategori harus diisi',
            'category_id.integer' => 'ID Kategori harus berupa angka',
            'user_id.required' => 'ID Pengguna harus diisi',
            'user_id.integer' => 'ID Pengguna harus berupa angka',
            'photo.required' => 'Foto harus diisi',
            'photo.image' => 'Foto harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'photo.max' => 'Ukuran gambar tidak boleh lebih dari 5MB',
        ];


    }
    public function FailedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));

    }
}

