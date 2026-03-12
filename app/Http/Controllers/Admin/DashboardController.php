<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch all data for the dashboard tables
        $categories = Category::all();
        $users = User::all();

        return view('admin.dashboard', compact('categories', 'users'));
    }
}