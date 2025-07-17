<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssueCategory;
use App\Models\IssueType;
use Illuminate\Support\Facades\Auth;

class SupportDropdownController extends Controller
{
    public function getCategories($departmentId)
    {
        return IssueCategory::where('department_id', $departmentId)
            ->select('id', 'name')
            ->get();
    }

    public function getTypes($categoryId)
    {
        return IssueType::where('issue_category_id', $categoryId)
            ->select('id', 'name')
            ->get();
    }
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        if (Auth::user()->isAdmin()) {
            $category = IssueCategory::create($validated);
            return response()->json(['id' => $category->id, 'name' => $category->name]);
        }

        return response()->json(['message' => 'Not saved, only local use.'], 200);
    }

    public function storeType(Request $request)
    {
        $validated = $request->validate([
            'issue_category_id' => 'required|integer',
            'name' => 'required|string|max:255',
        ]);

        if (Auth::user()->isAdmin()) {
            $type = IssueType::create($validated);
            return response()->json(['id' => $type->id, 'name' => $type->name]);
        }

        return response()->json(['message' => 'Not saved, only local use.'], 200);
    }
}