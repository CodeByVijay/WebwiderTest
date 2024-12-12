<?php

namespace App\Repositories;

use App\Models\Branch;
use App\Services\UserService;
use Exception;

class UserRepository implements UserService
{
    public function renderBranchTable($request)
    {
        $pageNumber = ($request->start / $request->length) + 1;
        $pageLength = $request->length;
        $skip = ($pageNumber - 1) * $pageLength;
        $search = $request->search['value'];
        $order = $request->order[0]['column'];
        $dir = $request->order[0]['dir'];
        $column = $request->columns[$order]['data'];

        $branches = Branch::where("created_by", auth()->user()->id)->orderBy($column, $dir);
        if ($search) {
            $branches->where(function ($q) use ($search) {
                $q->orWhere('name', 'like', '%' . $search . '%');
                $q->orWhere('address', 'like', '%' . $search . '%');
                $q->orWhere('latitude', 'like', '%' . $search . '%');
                $q->orWhere('longitude', 'like', '%' . $search . '%');
            });
        }

        $total = $branches->count();
        $branches = $branches->skip($skip)->take($pageLength)->get();
        $return = [];
        foreach ($branches as $key => $branch) {

            // action buttons

            $editBranchBtn = "<button class='btn btn-sm btn-primary mb-2 editBranch' data-id='" . $branch->id . "'>Edit</button>";

            $deleteBtn = "<button class='btn btn-sm btn-danger mb-2 branchDelete' data-id='" . $branch->id . "'>Delete</button>";


            $return[] = [
                "id" => $key + 1,
                "name" => $branch->name,
                "address" => $branch->address,
                "latitude" => $branch->latitude,
                "longitude" => $branch->longitude,
                "action" => $editBranchBtn . " " . $deleteBtn,
            ];
        }
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $return,
        ]);
    }

    public function storeUpdateBranch($request)
    {
        if ($request->has('branch_id') && !empty($request->branch_id)) {
            $branch = Branch::find($request->branch_id);
            $branch->name = $request->branch_name;
            $branch->address = $request->address;
            $branch->latitude = $request->latitude;
            $branch->longitude = $request->longitude;
            $branch->updated_by = auth()->user()->id;
            $branch->update();
            $message = 'Branch updated successfully!';
        } else {
            $branch = new Branch();
            $branch->name = $request->branch_name;
            $branch->address = $request->address;
            $branch->latitude = $request->latitude;
            $branch->longitude = $request->longitude;
            $branch->created_by = auth()->user()->id;
            $branch->save();
            $message = 'Branch added successfully!';
        }

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function getBranch($id)
    {
        try {
            $branch = Branch::find($id);
            return response()->json([
                'status' => true,
                'branch' => $branch
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteBranch($id)
    {
        try {
            $branch = Branch::find($id);
            $branch->deleted_by = auth()->user()->id;
            $branch->update();
            $branch->delete();
            return response()->json([
                'status' => true,
                'message' => 'Branch deleted successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
