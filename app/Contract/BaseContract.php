<?php

namespace App\Contract;

use Czim\Repository\Contracts\BaseRepositoryInterface;

interface BaseContract extends BaseRepositoryInterface
{    
    public function trashed();

    public function restore($id);

    public function purge($id);

    public function purgeAll();
}
