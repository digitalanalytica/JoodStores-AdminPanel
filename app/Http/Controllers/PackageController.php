<?php

namespace App\Http\Controllers;
use App\DataTables\PackageDataTable;
use App\Package;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Validator\Exceptions\ValidatorException;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PackageDataTable $packageDataTable)
    {
        return $packageDataTable->render('packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $package_object = new Package();
        try {
            $request->validate([
                'name' => 'required|max:30',
                'monthly_price' => 'required|numeric',
                'six_month_price' => 'required|numeric',
                'one_year_price' => 'required|numeric',
                'status' => 'required|in:0,1'
            ]);
            $package_object->name =$request->name;
            $package_object->monthly_price = $request->monthly_price;
            $package_object->six_month_price = $request->six_month_price;
            $package_object->one_year_price = $request->one_year_price;
            $package_object->number_of_ads = $request->number_of_ads;
            $package_object->status = $request->status;
            $package_object->save();
            return redirect(route('package.index'));
        }catch (ValidatorException $e ){
            Flash::error($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */

    public function show($id)
    {
        $package = Package::findOrFail($id);

        if (empty($package)) {
            Flash::error('Package not found');

            return redirect(route('packages.index'));
        }

        return view('packages.show')->with('package', $package);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::findOrFail($id);

        if (empty($package)) {
            Flash::error('Package not found');

            return redirect(route('packages.index'));
        }

        return view('packages.edit')->with('package', $package);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $package_object = Package::findOrFail($id);
        if (empty($package_object)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.package')]));
            return redirect(route('package.index'));
        }
        try {
            $request->validate([
                'name' => 'required|max:30',
                'monthly_price' => 'required|numeric',
                'six_month_price' => 'required|numeric',
                'one_year_price' => 'required|numeric',
                'status' => 'required|in:0,1'
            ]);
            $package_object->name =$request->name;
            $package_object->monthly_price = $request->monthly_price;
            $package_object->six_month_price = $request->six_month_price;
            $package_object->one_year_price = $request->one_year_price;
            $package_object->number_of_ads = $request->number_of_ads;
            $package_object->status = $request->status;
            $package_object->save();
            return redirect(route('package.index'));
        }catch (ValidatorException $e ){
            Flash::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        //
        $package = Package::findOrFail($id);
        if (empty($package)) {
            Flash::error('Package not found');

            return redirect(route('package.index'));
        }
        $package = Package::findOrFail($id)->delete();


        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.package')]));

        return redirect(route('package.index'));
    }
}
