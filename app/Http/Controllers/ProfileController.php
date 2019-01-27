<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileModel;
use App\Models\SettingModel;
use App\Models\TaskModel;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    // Menampilkan tampilan edit profile
    public function edit()
    {
        $data['task'] = TaskModel::get_task();
        $data['setting'] = SettingModel::get_setting();
        $data['user'] = ProfileModel::get_user_login();
        return view('admin.profile.profile', $data);
    }

    // Proses update profile
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'avatar' => 'image',
            'address' => 'required',
            'user_about' => 'required',
            'contact_number' => 'required',
            'contact_email' => 'required|email|max:2048',
            'instagram' => 'required|url',
            'facebook' => 'required|url',
            'twitter' => 'required|url',
            'linkedin' => 'required|url',
            'avatar' => 'image|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $avatar_name = time() . $avatar->getClientOriginalName();
            $avatar->move('images/avatars', $avatar_name);
            ProfileModel::update_avatar($avatar_name);
        }

        $request = $request->all();
        ProfileModel::update_user($request);
        Session::flash('success', 'Profile Updated');

        return redirect()->route('profile');
    }

    // Menampilkan halaman edit password
    public function edit_password()
    {
        $data['task'] = TaskModel::get_task();
        $data['setting'] = SettingModel::get_setting();
        return view('admin.profile.change_password', $data);
    }

    // Proses ganti password
    public function update_password(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6'
        ]);

        $request = $request->all();
        if (ProfileModel::update_password($request) == 'success') {
            Session::flash('success', 'Password Changed');
        } elseif (ProfileModel::update_password($request) == 'error_confirm') {
            Session::flash('error', 'Wrong Confirm Password');
        } else {
            Session::flash('error', 'Wrong Old Password');
        }

        return redirect()->route('password');
    }

}
