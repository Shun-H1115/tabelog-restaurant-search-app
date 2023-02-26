<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function mypage()
    {
            $user = Auth::user();

            return view('users.mypage', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::user();

        $user->name = $request->input('name') ? $request->input('name') : $user->name;
        $user->email = $request->input('email') ? $request->input('email') : $user->email;
        if($request->img){
            if($request->img->extension() == 'jpeg' || $request->img->extension() == 'jpg' || $request->img->extension() == 'png'){
                $request->file('img')->storeAs('public/img/icon', $user->id.'.'.$request->img->extension());
                $user->img_path = 'public/img/icon/'.$user->id.'.'.$request->img->extension();
            }else{
                $flash_message = '投稿可能なファイルは jpeg / jpg / png のみです。';
                $user->img_path = NULL;
            }
        }
        $user->img_path = $request->input('img_path') ? $request->input('img_path') : $user->img_path;
        $user->update();

        return redirect()->route('mypage', 'user');
    }
}
