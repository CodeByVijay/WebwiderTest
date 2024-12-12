<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(private AdminService $adminService) {}
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->adminService->renderBranchTable($request);
        }
        return view('admin.dashboard');
    }
}
