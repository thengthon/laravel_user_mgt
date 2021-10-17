<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::latest()->get();
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
            'role' => 'required',
            'status' => 'required'
        ]);
        
        $role = new Role();
        $role->user_id = $request->user_id;
        $role->role = $request->role;
        $role->status = $request->status;

        $role->save();
        return response()->json(['Message' => 'Role Created', 'Role' => $role], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Role::findOrFail($id);
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
            'role' => 'required',
            'status' => 'required'
        ]);
        
        $role = Role::findOrFail($id);
        $role->user_id = $request->user_id;
        $role->role = $request->role;
        $role->status = $request->status;

        $role->save();
        return response()->json(['Message' => 'Role Updated', 'Upated Role' => $role], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = Role::destroy($id);
        if($isDeleted) {
            return response()->json(['Message' => 'Role is deleted'], 200);
        } else {
            return response()->json(['Message' => 'ROLE ID NOT FOUND'], 404);
        }
    }
}