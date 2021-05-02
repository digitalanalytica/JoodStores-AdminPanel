<?php
/**
 * File name: SlideAPIController.php
 * Last modified: 2020.09.12 at 20:01:58
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers\API;


use App\Repositories\AdSliderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Laracasts\Flash\Flash;


/**
 * Class SlideController
 * @package App\Http\Controllers\API
 */

class AdSliderAPIController extends Controller
{
    /** @var  AdSliderRepository */
    private $slideRepository;

    /**
     * AdSliderAPIController constructor.
     * @param AdSliderRepository $slideRepo
     */
    public function __construct(AdSliderRepository $slideRepo)
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
        $slides = $this->slideRepository->all();

        return $this->sendResponse($slides->toArray(), 'Slides retrieved successfully');
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
            $slide = $this->slideRepository->findWithoutFail($id);
        }

        if (empty($slide)) {
            return $this->sendError('Slide not found');
        }

        return $this->sendResponse($slide->toArray(), 'Slide retrieved successfully');
    }
}
