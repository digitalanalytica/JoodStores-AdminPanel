<?php
/**
 * File name: SlideAPIController.php
 * Last modified: 2020.09.12 at 20:01:58
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers\API;
use App\Slider3;
use App\Repositories\Slider3Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Laracasts\Flash\Flash;


/**
 * Class SlideController
 * @package App\Http\Controllers\API
 */

class Slider3APIController extends Controller
{
    /** @var  Slider3Repository */
    private $slideRepository;

    public function __construct(Slider3Repository $slideRepo)
    {
        $this->slideRepository = $slideRepo;
    }

    /**
     * Display a listing of the Slide.
     * GET|HEAD /slides
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->slideRepository->pushCriteria(new RequestCriteria($request));
            $this->slideRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            Flash::error($e->getMessage());
        }
        $slider3 = $this->slideRepository->all();

        return $this->sendResponse($slider3->toArray(), 'Slides retrieved successfully');
    }

    /**
     * Display the specified Slide.
     * GET|HEAD /slides/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Slide $slide */
        if (!empty($this->slideRepository)) {
            $slider3 = $this->slideRepository->findWithoutFail($id);
        }

        if (empty($slider3)) {
            return $this->sendError('Slide not found');
        }

        return $this->sendResponse($slider3->toArray(), 'Slide retrieved successfully');
    }
}
