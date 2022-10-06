<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Interfaces\OrganizationInterface;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller implements OrganizationInterface
{

    public function __construct(private OrganizationInterface $organizationRepository)
    {}

    /**
     * Tashkilotlarni paginate bilan olib chiqish
     * @authenticated
     */
    public function index()
    {
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
        return $this->organizationRepository->store($request);
    }

    /**
     * Tashkilot ma'lumotlarini yangilash
     * @authenticated
     * @bodyParam title string required Tashkilot nomi
     * @bodyParam parent_id integer yuqori tashkilot
     */
    public function update(OrganizationRequest $request, Organization $organization)
    {
        return $this->organizationRepository->update($request, $organization);
    }

    /**
     * Tashkilot active ligini o'zgartirish
     * @param  int  $id
     */
    public function changeActive(int $id)
    {
        return $this->organizationRepository->changeActive($id);
    }
}
