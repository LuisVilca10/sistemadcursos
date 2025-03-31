<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserGCollection;
use App\Http\Resources\User\UserGResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $state = $request->state;
        $role = $request->role;

        $users = User::filterAdvance($search, $state, $role)->orderby("id", "desc")->get();

        return response()->json([
            "users" => UserGCollection::make($users),
        ]);
    }


    public function store(Request $request)
    {
        if ($request->hasFile("imagen")) {
            $path = Storage::putFile("users", $request->file("imagen"));
            $request->request->add(["profile_photo_path" => $path]);
        }
        if ($request->password) {
            $request->request->add(["password" => bcrypt($request->password)]);
        }
        $user = User::create($request->all());
        return response()->json(["user" => UserGResource::make($user)]);
    }


    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($request->hasFile("imagen")) {
                if ($user->profile_photo_path) {
                    Storage::delete($user->profile_photo_path);
                }
                $path = Storage::putFile("users", $request->file("imagen"));
                $request->request->add(["profile_photo_path" => $path]);
            }
            // if ($request->password) {
            //     $request->request->add(["password" => bcrypt($request->password)]);
            // }
            $user->update($request->all());
            return response()->json(["user" => UserGResource::make($user)]);
        } catch (ModelNotFoundException $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->profile_photo_path) {
                Storage::delete($user->profile_photo_path);
            }
            $user->delete();
            return response()->json(["message" => 200]);
        } catch (ModelNotFoundException $th) {
            //throw $th;
        }
    }
}
