<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display change password page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.auth.change_password');
    }

    /**
     * Change password.
     *
     * @return \Illuminate\Http\RedirectResponse
     **/
    public function changePassword()
    {
        request()->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed|different:current_password',
        ]);

        $admin = Auth::guard('admin')->user();

        if (Hash::check(request('current_password'), $admin->password)) {
            $admin->password = bcrypt(request('new_password'));
            $admin->save();

            return back()
                ->with(['type' => 'success', 'message' => 'Password updated successfully.'])
            ;
        }

        return back()
            ->with(['type' => 'error', 'message' => 'Incorrect current password.'])
        ;
    }
}
