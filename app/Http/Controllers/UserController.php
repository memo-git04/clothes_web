<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
        /**
        * Display a listing of the resource.
        */
        public function index()
        {
            $users = \App\Models\User::all();
            return view('admin.modules.user.index_user', [
                'users' => $users
            ]);
        }

        /**
        * Show the form for creating a new resource.
        */
        public function create()
        {
            return view('admin.modules.user.add_user');
        }

        /**
        * Store a newly created resource in storage.
        */
        public function store(Request $request)
        {
             //validate
            $request->validate([
                'user_name' => 'required|max:100|unique:users,user_name',
                'full_name' => 'required|max:100',
                'email' => 'required|email|max:100|unique:users,email',
                'password' => 'required|min:12|confirmed',
                'phone' => 'nullable|max:20',
                'gender' => 'nullable|in:male,female',
                'date_of_birth' => 'nullable|date',
                'address' => 'nullable',
            ]);
            $users = User::create([
                'user_name' => $request->user_name,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
            ]);
            dd($users);
            return redirect()->route('users.index')->with('success', 'Thêm user thành công!');
        }

        /**
        * Display the specified resource.
        */
        public function show($id)
        {
            //
        }

        /**
        * Show the form for editing the specified resource.
        */
        public function edit($id)
        {
            //
        }

        /**
        * Update the specified resource in storage.
        */
        public function update(Request $request, $id)
        {
            //
        }

        /**
        * Remove the specified resource from storage.
        */
        public function destroy($id)
        {
            //
        }
}
