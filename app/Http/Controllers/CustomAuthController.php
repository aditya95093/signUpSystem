<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CustomAuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function register(Request $request)
    {

        $user = new User();
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function loginUser(Request $request)
    {
        /* $validator = Validator::make($request->all(), [
             'email' => 'required|email',
             'password' => 'required|min:8',
         ]);

         if ($validator->fails()) {
             return redirect()->back()->withErrors($validator)->withInput();
         }*/

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->with('success', 'Login successful.');
        }

        return redirect()->back()->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', "You have been logged out.");
    }

    public function index()
    {
        $users = User::all();
        $data = [
            'status' => 200,
            'users' => $users
        ];

        return response()->json($data, 200);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'mobile' => 'required|digits:10',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 422,
                'message' => $validator->messages()
            ];
            return response()->json($data, 422);
        } else {
            $user = new User;
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $data = [
                'status' => 200,
                'message' => 'Data uploaded successfully'
            ];

            return response()->json($data, 200);
        }
    }
    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'mobile' => 'required|digits:10',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 422,
                'message' => $validator->messages()
            ];
            return response()->json($data, 422);
        } else {
            $user = User::find($id);
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $data = [
                'status' => 200,
                'message' => 'Data updated successfully'
            ];

            return response()->json($data, 200);
        }

    }
    public function delete($id)
    {

        $user = User::find($id);
        $user->delete();

        $data = [
            'status' => 200,
            'message' => "Data deleted successfully"
        ];

        return response()->json($data, 200);
    }

}
