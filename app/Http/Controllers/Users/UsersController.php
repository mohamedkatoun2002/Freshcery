<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\Product\Order;
use App\Models\User;

class UsersController extends Controller
{
    //MyOrders
    public function myOrders()
    {
        $orders = Order::select()->where('user_id', Auth::user()->id)->get();


        return view('users.myorders', compact('orders'));
    }

    //Settings
    public function settings()
    {
        $users = User::find(Auth::user()->id);

        return view('users.settings', compact('users'));
    }


    //updateUsersSettings
    public function updateUsersSettings(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,',
        ]);



        $users = User::find(Auth::user()->id);
        $users->update($request->all());

        if ($users) {
            return Redirect::route('users.settings')->with('update', 'Settings updated successfully');
        }
    }
}
