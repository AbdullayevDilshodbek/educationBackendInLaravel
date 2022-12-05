<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Interfaces\PositionInterface;

/**
 * @group Position
 */
class PositionController extends Controller implements PositionInterface
{
    public function __construct(private PositionInterface $positionRepository)
    {
    }

    /**
     * Lavozimlarni paginatsiya bilan olib chiqish
     * @authenticated
     * @queryParam search string
     */
    public function index()
    {
        if (!$this->authCan('show_positions'))
            return $this->forbidden();
        return $this->positionRepository->index();
    }

    /**
     * Lavozim yaratish
     * @authenticated
     * @bodyParam title string required Lavozim nomi Example: O'qituvchi
     */
    public function store(PositionRequest $request)
    {
        if (!$this->authCan('add_positions'))
            return $this->forbidden();
        return $this->positionRepository->store($request);
    }

    /**
     * Lavozim nomini o'zgartirish
     * @authenticated
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PositionRequest $request, $id)
    {
        if (!$this->authCan('update_positions'))
            return $this->forbidden();
        return $this->positionRepository->update($request, $id);
    }

    /**
     * Lavozim statusini faol yoki nofaol qilish
     * @authenticated
     * @param  int  $id
     */
    public function changeActive($id)
    {
        if (!$this->authCan('update_positions'))
            return $this->forbidden();
        return $this->positionRepository->changeActive($id);
    }

    /**
     * AutoComplete u-n barcha lavozimlarni olish
     * @authenticated
     */
    public function getAllForAutoComplete()
    {
        return $this->positionRepository->getAllForAutoComplete();
    }
}
