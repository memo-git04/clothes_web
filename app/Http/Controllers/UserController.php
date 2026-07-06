<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    //admin login-logout
    public function login()
    {
        return view('admin.login.page-login');
    }
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải ít nhất 6 ký tự'
        ]);
        $accounts = $request->only(['email', 'password']);
        //        dd($accounts);
        if (Auth::attempt($accounts)){
            $user = Auth::user();

            // Kiểm tra status
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đã bị khóa'
                ]);
            }
            $request->session()->regenerate(true);
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Chúc mừng bạn đã đăng nhập thành công!');
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
            $users = \App\Models\User::with('roles')->get();
            return view('admin.modules.user.index_user', [
                'users' => $users,
            ]);
        }

        /**
        * Show the form for creating a new resource.
        */
        public function create()
        {
            $roles = Role::where('name', '!=', 'customer')->get();
            return view('admin.modules.user.add_user', [
                'roles' => $roles,
            ]);
        }

        /**
        * Store a newly created resource in storage.
        */
        public function store(Request $request)
        {
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
            $users->assignRole($request->role);
//            dd($users);
            return redirect()->route('admin.users.index')->with('success', 'Thêm tài khoản thành công!');
        }

        public function createAccountByAdmin(Request $request){

            $validated = $request->validate([
                'user_name' => [
                    'required',
                    'string',
                    'regex:/^[a-zA-Z0-9_]+$/',
                    'min:3',
                    'max:50',
                    Rule::unique('users', 'user_name')->whereNull('deleted_at')
                ],
                'full_name' => [
                    'required',
                    'string',
                    'regex:/^[\pL\s\-]+$/u',
                    'min:3',
                    'max:100'
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'max:100',
                    Rule::unique('users', 'email')->whereNull('deleted_at')
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                    'confirmed'
                ],
                'password_confirmation' => 'required|string',
                'phone' => [
                    'required',
                    'string',
                    'regex:/^(0[3|5|7|8|9])+([0-9]{8})$/',
                    Rule::unique('users', 'phone')->whereNull('deleted_at')
                ],
                'gender' => [
                    'required',
                    'string',
                    'in:male,female'
                ],
                'date_of_birth' => [
                    'required',
                    'date',
                    'before:today',
                    'after:01/01/1900',
                    'date_format:d/m/Y'
                ],
                'address' => [
                    'required',
                    'string',
                    'min:10',
                    'max:255'
                ],
                'role' => [
                    'required',
                    'string',
                    Rule::exists('roles', 'name')->whereNull('deleted_at')
                ]
            ], [
                // Custom messages (tiếng Việt)
                'user_name.required' => 'Tên đăng nhập không được để trống.',
                'user_name.string' => 'Tên đăng nhập phải là chuỗi ký tự.',
                'user_name.regex' => 'Tên đăng nhập chỉ chứa chữ cái, số và dấu gạch dưới.',
                'user_name.min' => 'Tên đăng nhập phải có ít nhất 3 ký tự.',
                'user_name.max' => 'Tên đăng nhập không được vượt quá 50 ký tự.',
                'user_name.unique' => 'Tên đăng nhập đã tồn tại.',

                'full_name.required' => 'Họ và tên không được để trống.',
                'full_name.string' => 'Họ và tên phải là chuỗi ký tự.',
                'full_name.regex' => 'Họ và tên không chứa ký tự đặc biệt.',
                'full_name.min' => 'Họ và tên phải có ít nhất 3 ký tự.',
                'full_name.max' => 'Họ và tên không được vượt quá 100 ký tự.',

                'email.required' => 'Email không được để trống.',
                'email.string' => 'Email phải là chuỗi ký tự.',
                'email.email' => 'Định dạng email không hợp lệ.',
                'email.regex' => 'Định dạng email không hợp lệ.',
                'email.max' => 'Email không được vượt quá 100 ký tự.',
                'email.unique' => 'Email đã tồn tại.',

                'password.required' => 'Mật khẩu không được để trống.',
                'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
                'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',

                'password_confirmation.required' => 'Vui lòng xác nhận mật khẩu.',
                'password_confirmation.string' => 'Xác nhận mật khẩu phải là chuỗi ký tự.',

                'phone.required' => 'Số điện thoại không được để trống.',
                'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
                'phone.regex' => 'Số điện thoại không hợp lệ (bắt đầu bằng 0, 3-5 số tiếp theo và 8 số cuối).',
                'phone.unique' => 'Số điện thoại đã tồn tại.',

                'gender.required' => 'Vui lòng chọn giới tính.',
                'gender.string' => 'Giới tính phải là chuỗi ký tự.',
                'gender.in' => 'Giới tính không hợp lệ.',

                'date_of_birth.required' => 'Ngày sinh không được để trống.',
                'date_of_birth.date' => 'Định dạng ngày không hợp lệ.',
                'date_of_birth.before' => 'Ngày sinh phải trước ngày hôm nay.',
                'date_of_birth.after' => 'Ngày sinh không hợp lệ.',
                'date_of_birth.date_format' => 'Định dạng ngày phải là dd/mm/yyyy.',

                'address.required' => 'Địa chỉ không được để trống.',
                'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
                'address.min' => 'Địa chỉ phải có ít nhất 10 ký tự.',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

                'role.required' => 'Vui lòng chọn vai trò.',
                'role.string' => 'Vai trò phải là chuỗi ký tự.',
                'role.exists' => 'Vai trò không hợp lệ.'
            ]);

            // ==================== TẠO USER ====================
            $user = User::create([
                'user_name'     => $validated['user_name'],
                'full_name'     => $validated['full_name'],
                'email'         => $validated['email'],
                'password'      => bcrypt($validated['password']),
                'phone'         => $validated['phone'],
                'gender'        => $validated['gender'],
                'date_of_birth' => \Carbon\Carbon::parse($validated['date_of_birth'])->format('Y-m-d'),
                'address'       => $validated['address'],
                'status'        => 'active',
            ]);

            // Gán vai trò
            $user->assignRole($validated['role']);
//            dd($users);
            return redirect()->route('admin.users.index')->with('success', 'Thêm thành công');
        }

        /**
        * Trang thông tin tài khoản của khách hàng đang đăng nhập.
        */
        public function show()
        {
            return view('profile', [
                'customer' => auth()->user(),
            ]);
        }

        /**
        * Cập nhật thông tin tài khoản (khách hàng tự sửa).
        */
        public function updateProfile(Request $request)
        {
            $user = auth()->user();

            $request->validate([
                'full_name'     => 'required|string|max:255',
                'phone'         => 'nullable|string|max:20',
                'address'       => 'nullable|string|max:255',
                'gender'        => 'nullable|in:male,female,other',
                'date_of_birth' => 'nullable|date',
                'img'           => 'nullable|image|max:2048',
                'password'      => 'nullable|string|min:8|confirmed',
            ]);

            $data = $request->only(['full_name', 'phone', 'address', 'gender', 'date_of_birth']);

            // Ảnh đại diện
            if ($request->hasFile('img')) {
                if ($user->img) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->img);
                }
                $data['img'] = $request->file('img')->store('avatars', 'public');
            }

            // Đổi mật khẩu (nếu nhập)
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return redirect()->route('profile')->with('success', 'Cập nhật thông tin thành công!');
        }

        /**
        * Show the form for editing the specified resource.
        */
        public function edit(User $user)
        {

            $roles = \App\Models\Role::where('name', '!=', 'customer')->get();
            return view('admin.modules.user.edit_user', [
                'user' => $user,
                'roles' => $roles
            ]);
        }

        /**
        * Update the specified resource in storage.
        */
        public function update(Request $request, User $user)
        {
            $validated = $request->validate([
                'full_name' => [
                    'required',
                    'string',
                    'regex:/^[\pL\s\-]+$/u',
                    'min:3',
                    'max:255'
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($user->id)->whereNull('deleted_at')
                ],
                'phone' => [
                    'nullable',
                    'string',
                    'max:20',
                    'regex:/^0[0-9]{9,10}$/',
                    Rule::unique('users', 'phone')->ignore($user->id)->whereNull('deleted_at')
                ],
                'address' => [
                    'nullable',
                    'string',
                    'min:10',
                    'max:255'
                ],
                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                    'confirmed'
                ],
                'password_confirmation' => 'nullable|string',

                'roles' => 'nullable|array',
                'roles.*' => 'string|exists:roles,name',
            ], [
                'full_name.required' => 'Họ và tên không được để trống.',
                'full_name.string' => 'Họ và tên phải là chuỗi ký tự.',
                'full_name.regex' => 'Họ và tên không chứa ký tự đặc biệt.',
                'full_name.min' => 'Họ và tên phải có ít nhất 3 ký tự.',
                'full_name.max' => 'Họ và tên không được vượt quá 255 ký tự.',

                'email.required' => 'Email không được để trống.',
                'email.string' => 'Email phải là chuỗi ký tự.',
                'email.email' => 'Định dạng email không hợp lệ.',
                'email.regex' => 'Định dạng email không hợp lệ.',
                'email.max' => 'Email không được vượt quá 255 ký tự.',
                'email.unique' => 'Email đã tồn tại.',

                'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
                'phone.regex' => 'Số điện thoại không hợp lệ (bắt đầu bằng 0, 3-5 số tiếp theo và 8 số cuối).',
                'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
                'phone.unique' => 'Số điện thoại đã tồn tại.',

                'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
                'address.min' => 'Địa chỉ phải có ít nhất 10 ký tự.',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

                'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
                'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',

                'password_confirmation.string' => 'Xác nhận mật khẩu phải là chuỗi ký tự.',

                'roles.array' => 'Định dạng vai trò không hợp lệ.',
                'roles.*.exists' => 'Vai trò được chọn không tồn tại trong hệ thống.',

            ]);
            $user->update([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);

            if (isset($validated['password']) && !empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
                $user->save();
            }

            $user->syncRoles($request->input('roles', []));
            return redirect()->back()->with('success', 'Cập nhật tài khoản thành công!');
        }
        //add permissions
        public function addPermissions(User $user){
            $permissions = Permission::all();

            return view('admin.modules.user.add_permission', [
                'user' => $user,
                'permissions' => $permissions,
            ]);
        }
        public function addPermissionsPost(User $user, Request $request){
            $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,name',
            ]);
            $permissions = $request->input('permissions');
            $user->syncPermissions($permissions);

            return redirect()->back()->with('success', 'Permissions updated successfully!');
        }
        public function showPermissions(User $user){
            $allPermissions = $user->getAllPermissions();
            return view('admin.modules.user.show_permission', [
                'user' => $user,
                'allPermissions' => $allPermissions,
            ]);
        }
        /**
        * Remove the specified resource from storage.
        */
        public function destroy($id)
        {
            $user = User::findOrFail($id);
            $user->syncRoles([]); // Remove all roles associated with the user
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
        }
}
