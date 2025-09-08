<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('region')
            ->orderBy('name')
            ->get()
            ->groupBy('region');

        return view('branches.index', compact('branches'));
    }

    public function show(Branch $branch)
    {
        // Загружаем связанные проекты
        $branch->load(['projects']);
        
        return view('branches.show', compact('branch'));
    }

    /**
     * API: Получить список отделений
     */
    public function apiIndex(Request $request)
    {
        $perPage = min($request->get('per_page', 10), 50);
        
        $branches = Branch::orderBy('region')
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json([
            'data' => $branches->items(),
            'current_page' => $branches->currentPage(),
            'per_page' => $branches->perPage(),
            'total' => $branches->total(),
            'last_page' => $branches->lastPage(),
            'has_more_pages' => $branches->hasMorePages(),
        ]);
    }

    /**
     * API: Получить конкретное отделение
     */
    public function apiShow(Branch $branch)
    {
        $branch->load(['projects']);
        return response()->json(['data' => $branch]);
    }
}
