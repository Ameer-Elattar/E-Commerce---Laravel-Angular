<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Authenticatable implements JWTSubject
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all();

        return response()->json($admins, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $image = $request->file("image");
        $imageName = time() . '_' . $image->getClientOriginalName();
        $hashedPassword = Hash::make($request->password);
        $admin = Admin::create([
            "name" => $request->name,
            "password" => $hashedPassword,
            "email" => $request->email,
            "image" => $imageName
        ]);
        $image->move("images/admins", $imageName);
        return response()->json($admin, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }
        return response()->json($admin, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, string $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }
        $imageName = $admin->image;
        if ($request->hasFile('image')) {
            if ($admin->image && File::exists(public_path("images/admins/{$admin->image}"))) {
                File::delete(public_path("images/admins/{$admin->image}"));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move('images/admins', $imageName);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'image' => $imageName
        ];
        $admin->update($data);
        return response()->json(["message" => "Admin updated", "admin" => $admin], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }
        if ($admin->image && File::exists(public_path("images/admins/{$admin->image}"))) {
            File::delete(public_path("images/admins/{$admin->image}"));
        }
        $admin->delete();
        return response()->json(["message" => "Admin Deleted"]);
    }
}

