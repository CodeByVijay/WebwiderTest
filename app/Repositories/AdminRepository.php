<?php

namespace App\Repositories;

use App\Models\Branch;
use App\Services\AdminService;

class AdminRepository implements AdminService
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

        $branches = Branch::withTrashed()->orderBy($column, $dir);
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

            $return[] = [
                "id" => $key + 1,
                "name" => $branch->name,
                "address" => $branch->address,
                "latitude" => $branch->latitude,
                "longitude" => $branch->longitude,
                "created_by" => $branch->createdBy?->name ?? "-",
                "updated_by" => $branch->updatedBy?->name ?? "-",
                "deleted_by" => $branch->deletedBy?->name ?? "-",
            ];
        }
        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $return,
        ]);
    }
}
