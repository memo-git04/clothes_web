<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            //
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
