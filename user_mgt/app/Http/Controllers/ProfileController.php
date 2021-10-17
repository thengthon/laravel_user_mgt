<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Profile::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required|min:3|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1999'
        ]);
        $request->file('image')->store('public/images');
        
        $pro = new Profile();
        $pro->user_id = $request->user_id;
        $pro->city = $request->city;
        $pro->image = $request->file('image')->hashName();

        $pro->save();
        return response()->json(['Message' => 'Profile Created', 'Profile' => $pro], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Profile::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'city' => 'required|min:3|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1999'
        ]);
        $request->file('image')->store('public/images');
        
        $pro = Profile::findOrFail($id);
        $pro->user_id = $request->user_id;
        $pro->city = $request->city;
        $pro->image = $request->file('image')->hashName();

        $pro->save();
        return response()->json(['Message' => 'Profile Updated', 'Updated Profile' => $pro], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = Profile::destroy($id);
        if($isDeleted) {
            return response()->json(['Message' => 'Profile is deleted'], 200);
        } else {
            return response()->json(['Message' => 'PROFILE ID NOT FOUND'], 404);
        }
    }
}