<?php

namespace App\Http\Controllers;
use App\Models\EmployeeLevel;

use Illuminate\Http\Request;


class EmployeeLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
       //
        $request->validate([
            'levels' => 'required|array',
            'levels.*' => 'required|string|max:255',
        ]);

        $inserted = [];

        foreach ($request->levels as $title) {
            $level = EmployeeLevel::create(['title' => $title]);
            $inserted[] = ['id' => $level->id, 'title' => $level->title];
        }

        return response()->json($inserted);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
