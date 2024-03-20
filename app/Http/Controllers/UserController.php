<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos');

            $image = Image::create([
                'url' => $photoPath,
                'imageable_id' => $user->id,
                'imageable_type' => User::class,
            ]);
        }

        return response()->json(['message' => 'User created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        $photo = $user->images()->first();

        // Siapkan data respons
        $responseData = [
            'user' => $user,
            'photo' => $photo ?? null,
        ];

        // Mengembalikan respons dalam bentuk JSON
        return response()->json($responseData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos');

            // Delete old photo if it exists
            if ($user->photo) {
                Storage::delete($user->photo->url);
                $user->photo->delete();
            }

            $image = Image::create([
                'url' => $photoPath,
                'imageable_id' => $user->id,
                'imageable_type' => User::class,
            ]);
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        return $user->createToken('user login')->plainTextToken;
    }
}
