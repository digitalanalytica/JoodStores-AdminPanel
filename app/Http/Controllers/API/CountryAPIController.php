<?php

namespace App\Http\Controllers\API;


use App\Country;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;

/**
 * Class CountryController
 * @package App\Http\Controllers\API
 */

class CountryAPIController extends Controller
{
    /** @var  CountryRepository */
    private $countryRepository;

    public function __construct(CountryRepository $countryRepo)
    {
        $this->countryRepository = $countryRepo;
    }

    /**
     * Display a listing of the Country.
     * GET|HEAD /Countrys
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->countryRepository->pushCriteria(new RequestCriteria($request));
            $this->countryRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }
        $countries = $this->countryRepository->all();

        return $this->sendResponse($countries->toArray(), 'Countries retrieved successfully');
    }

    /**
     * Display the specified Country.
     * GET|HEAD /Countries/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Country $country */
        if (!empty($this->countryRepository)) {
            $country = $this->countryRepository->findWithoutFail($id);
        }

        if (empty($country)) {
            return $this->sendError('Country not found');
        }

        return $this->sendResponse($country->toArray(), 'Country retrieved successfully');
    }
}
