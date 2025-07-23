<?php

namespace App\Repository\Interfaces;

interface IVariantRepository extends IBaseRepository
{
    //
    public function getVariantByProductId($id);
}
