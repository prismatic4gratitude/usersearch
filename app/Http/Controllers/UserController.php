<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAll(Request $request) {
        $query = $request->q;

        if ($query) {
            $users = User::where('name', 'like', '%' . $query . '%')->orWhere('email', 'like', '%' . $query . '%')->orderBy('name')->get();
        }

        else {
            $users = User::orderBy('name')->get();
        }

        $message = count($users) === 0 ? 'No users found matching the query' : 'Found '. count($users) . ' users matching the query';

        if ($query) $message .= ' "' . $query .'"';

        return view('users', compact('users','message'));
    }

    public function getSingle($id) {
        $user = User::find($id);

        $message = $user ? 'Found one user' : 'User Not Found';

        return response()->json(compact('user','message'));
    }

    public function create(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'phone_number' => 'required|unique:users',
            'gender' => 'required|in:male,female'
        ]);

        $user = new User; //the new user instance
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;

        $user->save();
        $message = "User created successfully";

        return response()->json(compact('user','message'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|max:255',
            'email'  =>  'required|unique:users,id,'.$id,
            'phone_number' => 'required|unique:users,id,'.$id,
            'gender' => 'required|in:male,female'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;

        $user->save();
        $message = "User details updated successfully";

        return response()->json(compact('user','message'));
    }

    public function delete($id) {
        $user = User::findOrFail($id);

        $user->delete();

        $message = "User deleted successfully";
        return response()->json(compact('message'));
    }
}
