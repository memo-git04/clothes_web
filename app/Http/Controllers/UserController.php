<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    //admin login-logout
    public function login()
    {
        return view('admin.login.page-login');
    }
    public function loginProcess(Request $request)
    {
        $accounts = $request->only(['email', 'password']);
        //        dd($accounts);
        if (Auth::attempt($accounts)){
            $user = Auth::user();

            if (!$user->hasRole('admin')) {
                Auth::logout();
                return back()->withErrors(['email' => 'Bạn không có quyền Admin.']);
            }

            // Kiểm tra status
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors(['email' => 'Tài khoản của bạn đã bị khóa.']);
            }
            return redirect()->intended(route('admin.users.index'));
        }
        return Redirect::back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('admin.loginAdmin');
    }
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
                'status'        => 'active',
            ]);
            $users->assignRole('admin');
//            dd($users);
            return redirect()->route('admin.users.index')->with('success', 'Thêm user thành công!');
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
        public function edit(User $user)
        {

            $roles = \App\Models\Role::all();
            return view('admin.modules.user.edit_user', [
                'user' => $user,
                'roles' => $roles
            ]);
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
