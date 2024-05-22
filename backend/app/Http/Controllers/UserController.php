<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users= User::all();

        return response()->json($users,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $image=$request->file("image");
        $imageName=time().'_'.$image->getClientOriginalName();
        $user=User::create([
            "full_name"=>$request->full_name,
            "password"=>$request->password,
            "email"=>$request->email,
            "gender"=>$request->gender,
            "image"=>$imageName
        ]);
        $image->move("images/users",$imageName);
        return response()->json($user,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user,200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        dd($request->all());

        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        $imageName=$user->image;;
        if ($request->hasFile('image')) {
            if ($user->image && File::exists(public_path("images/users/{$user->image}"))) {
                File::delete(public_path("images/users/{$user->image}"));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move('images/users', $imageName);
            
        }
        $data = [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'image' => $imageName
        ];
        dd($data);
        $user->update($data);
        return response()->json(["message"=>"User updated","user"=>$user],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->image && File::exists(public_path("images/users/{$user->image}"))) {
            File::delete(public_path("images/users/{$user->image}"));
        }
        $user->delete();
        return response()->json(["message"=>"User Deleted"]);
    }
}
