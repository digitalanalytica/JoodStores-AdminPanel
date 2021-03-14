<?php

namespace App\Http\Controllers;

use App\Country;
use App\DataTables\CountryDataTable;
use App\Repositories\UploadRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Validator\Exceptions\ValidatorException;

class CountryController extends Controller
{
    /**
     * @var UploadRepository
     */
    private $uploadRepository;

    public function __construct(UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->uploadRepository = $uploadRepo;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CountryDataTable $countryDataTable)
    {
        //
        return $countryDataTable->render('countries.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view ('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //
        $country_object = new Country();
        $input = $request->all();
        try {
            $request->validate([
                'country_name' => 'required|max:30',
                'country_description' => 'required|max:60',
                'image' => 'required'
            ]);
            $country_object->country_name =$request->country_name;
            $country_object->country_description =$request->country_description;
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
//                $mediaItem->copy($request,'image');
            }
            $country_object->save();
            return redirect(route('country.index'));
        }catch (ValidatorException $e ){
            Flash::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $country = Country::findOrFail($id);

        if (empty($country)) {
            Flash::error('Country not found');

            return redirect(route('country.index'));
        }

        return view('countries.edit')->with('country', $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $country_object = Country::findOrFail($id);
        try {
            $request->validate([
                'country_name' => 'required|max:30',
                'country_description' => 'required|max:60',
            ]);
            $country_object->country_name =$request->country_name;
            $country_object->country_description =$request->country_description;
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
//                $mediaItem->copy($request,'image');
            }
            $country_object->save();
            return redirect(route('country.index'));
        }catch (ValidatorException $e ){
            Flash::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        if (empty($country)) {
            Flash::error('country not found');

            return redirect(route('country.index'));
        }
        $country = country::findOrFail($id)->delete();


        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.country')]));

        return redirect(route('country.index'));
    }
}
