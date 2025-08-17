<?php

namespace App\Http\Controllers;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function storeMultiple(Request $request)
        {
            $validated = $request->validate([
                'departments' => 'required|array',
                'departments.*' => 'required|string|max:255|unique:departments,name'
            ]);
            $saved = collect($validated['departments'])->map(function ($name) {
                return Department::create(['name' => $name]);
            });

            return response()->json($saved);
        }

}
