<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $loggedUser;
    public function __construct(){
        $this->loggedUser = Auth::guard('api-admins')->user() ?? Auth::guard('api')->user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        // $this->authorize('viewAny',User::class);
        $users= User::all();
        return response()->json($users,200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $imageName= null;
        $defaultImagePath = 'images/default/default_avatat.jpg';

        if($request->hasFile('image')){
            $image=$request->file("image");
            $imageName=time().'_'.$image->getClientOriginalName();
            $image->move("images/users",$imageName);
        }else{
        $imageName = time() . '_default_avatar.jpg';
        File::copy(public_path($defaultImagePath), public_path('images/users/' . $imageName));
        }
        $hashedPassword=Hash::make($request->password);
        $user=User::create([
            "full_name"=>$request->full_name,
            "password"=>$hashedPassword,
            "email"=>$request->email,
            "gender"=>$request->gender,
            "image"=>$imageName
        ]);
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
        $this->authorize("view",  $user);
        return response()->json($user,200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {

        $user = User::find($id);
        $this->authorize('update',$user);
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
            'full_name' => $request->full_name ?? $user->full_name,
            'email' => $request->email ?? $user->email,
            'gender' => $request->gender ?? $user->gender,
            'image' => $imageName
        ];
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
        // $this->authorize('delete',$user);
        if ($user->image && File::exists(public_path("images/users/{$user->image}"))) {
            File::delete(public_path("images/users/{$user->image}"));
        }
        $user->delete();
        return response()->json(["message"=>"User Deleted"]);
    }
}
