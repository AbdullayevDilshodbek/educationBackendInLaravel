<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Interfaces\OrganizationInterface;
use App\Models\Organization;
use Illuminate\Http\Request;

/**
 * @group Organization
 */
class OrganizationController extends Controller implements OrganizationInterface
{

    public function __construct(private OrganizationInterface $organizationRepository)
    {
    }

    /**
     * Tashkilotlarni paginate bilan olib chiqish
     * @authenticated
     */
    public function index()
    {
        if (!$this->authCan('show_organizations'))
            return $this->forbidden();
        return $this->organizationRepository->index();
    }

    /**
     * Tashkilot qo'shish
     * @authenticated
     * @bodyParam title string required Tashkilot nomi
     * @bodyParam parent_id integer yuqori tashkilot
     */
    public function store(OrganizationRequest $request)
    {
        if (!$this->authCan('add_organizations'))
            return $this->forbidden();
        return $this->organizationRepository->store($request);
    }

    /**
     * Tashkilot ma'lumotlarini yangilash
     * @authenticated
     * @bodyParam title string required Tashkilot nomi
     * @bodyParam parent_id integer yuqori tashkilot
     */
    public function update(OrganizationRequest $request, int $id)
    {
        if (!$this->authCan('update_organizations'))
            return $this->forbidden();
        return $this->organizationRepository->update($request, $id);
    }

    /**
     * Tashkilot active ligini o'zgartirish
     * @param  int  $id
     */
    public function changeActive(int $id)
    {
        if (!$this->authCan('update_organizations'))
            return $this->forbidden();
        return $this->organizationRepository->changeActive($id);
    }

    /**
     * AutoComplete u-n barcha Tashkilotlarni olish
     * @authenticated
     */
    public function getAllForAutoComplete()
    {
        return $this->organizationRepository->getAllForAutoComplete();
    }
}
