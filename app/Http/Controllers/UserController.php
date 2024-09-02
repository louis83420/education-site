<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::all(); // 查詢所有用戶
    }

    public function show($id)
    {
        return User::find($id); // 查詢某個用戶
    }

    public function store(Request $request)
    {
        return User::create($request->all()); // 新增用戶
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return $user; // 更新用戶
    }

    public function destroy($id)
    {
        User::find($id)->delete(); // 刪除用戶
        return response()->json(['message' => 'User deleted']);
    }
} {
    //
}
