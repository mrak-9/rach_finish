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
        // Загружаем связанные проекты и мероприятия
        $branch->load(['projects', 'events']);
        
        return view('branches.show', compact('branch'));
    }
}
