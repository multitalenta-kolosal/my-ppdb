<?php

namespace Modules\Finance\Repositories;

use App\Repositories\BaseRepository;
use Modules\Finance\Repositories\Contracts\InstallmentRepositoryInterface;
use Modules\Finance\Entities\Installment;

/** @property Installment $model */
class InstallmentRepository extends BaseRepository implements InstallmentRepositoryInterface
{
    public function model()
    {
        return Installment::class;
    }
}
