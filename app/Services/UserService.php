<?php

namespace App\Services;

interface UserService
{
    public function renderBranchTable($request);
    public function storeUpdateBranch($request);
    public function getBranch($id);
    public function deleteBranch($id);
}
