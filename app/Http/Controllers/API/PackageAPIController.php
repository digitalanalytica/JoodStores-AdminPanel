<?php

namespace App\Http\Controllers\API;


use App\Package;
use App\Repositories\PackageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;

/**
 * Class PackageController
 * @package App\Http\Controllers\API
 */

class PackageAPIController extends Controller
{
    /** @var  PackageRepository */
    private $packageRepository;

    public function __construct(PackageRepository $packageRepo)
    {
        $this->packageRepository = $packageRepo;
    }

    /**
     * Display a listing of the Package.
     * GET|HEAD /Packages
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->packageRepository->pushCriteria(new RequestCriteria($request));
            $this->packageRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $countries = $this->packageRepository->all();

        return $this->sendResponse($countries->toArray(), 'Countries retrieved successfully');
    }

    /**
     * Display the specified Package.
     * GET|HEAD /Countries/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Package $package */
        if (!empty($this->packageRepository)) {
            $package = $this->packageRepository->findWithoutFail($id);
        }

        if (empty($package)) {
            return $this->sendError('Package not found');
        }

        return $this->sendResponse($package->toArray(), 'Packages retrieved successfully');
    }
}
