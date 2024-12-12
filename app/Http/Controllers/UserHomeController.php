<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserHomeController extends Controller
{

    public function __construct(private UserService $userService) {}
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->userService->renderBranchTable($request);
        }
        return view('users.dashboard');
    }


    public function storeUpdateBranch(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'branch_name' => 'required|string|max:255',
                'address' => 'required|string|max:500',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            return $this->userService->storeUpdateBranch($request);
        } catch (\Exception $e) {
            // If something goes wrong, catch the exception and return a generic error message
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while adding the branch. Please try again later.'
            ], 500);  // 500 Internal Server Error
        }
    }

    public function getBranch($id)
    {
        return $this->userService->getBranch($id);
    }

    public function deleteBranch($id)
    {
        return $this->userService->deleteBranch($id);
    }
}
