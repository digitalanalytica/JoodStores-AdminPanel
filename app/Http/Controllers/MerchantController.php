<?php

namespace App\Http\Controllers;

use App\DataTables\MerchantDataTable;
use App\Merchant;
use App\Repositories\CustomFieldRepository;
use App\Repositories\MerchantRepository;
use App\Repositories\UploadRepository;
use App\Repositories\PackageRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Prettus\Validator\Exceptions\ValidatorException;

class MerchantController extends Controller
{
    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;
    /**
     * @var UploadRepository
     */
    private $uploadRepository;

    /**
     * @var MerchantRepository
     */
    private $merchantRepository;
    /**
     * @var PackageRepository
     */
    private $packageRepository;

    public function __construct(UploadRepository $uploadRepo, 
    MerchantRepository $merchantRepo,
     CustomFieldRepository $customFieldRepo,
     PackageRepository $packageRepo)
    {
        parent::__construct();
        $this->uploadRepository = $uploadRepo;
        $this->merchantRepository = $merchantRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->packageRepository = $packageRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MerchantDataTable $merchantDataTable)
    {
        //
        return $merchantDataTable->render('merchants.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        //
        $package = $this->packageRepository->pluck('name','id');
     $hasCustomField = in_array($this->merchantRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->merchantRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('merchants.create')
        ->with("customFields", isset($html) ? $html : false)
        ->with('package',$package);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $input = $request->all();
        if (auth()->user()->hasRole(['manager','client'])) {
            $input['users'] = [auth()->id()];
        }
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->merchantRepository->model());
        try {
            $merchant = $this->merchantRepository->create($input);
            $merchant->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image_id']) && $input['image_id']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image_id']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($merchant, 'image_id');
            }
            if (isset($input['image_cr']) && $input['image_cr']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image_cr']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($merchant, 'image_cr');
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.merchant')]));

        return redirect(route('merchants.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
        $merchant = Merchant::findOrFail($id);
        $package = $merchant->package->name;

        if (empty($merchant)) {
            Flash::error('merchant not found');

            return redirect(route('merchants.index'));
        }

        return view('merchants.show')
        ->with('merchant', $merchant)
        ->with('package', $package);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function edit($id)
    {
        //
        $package = $this->packageRepository->pluck('name','id');

        $merchant = Merchant::findOrFail($id);
        if (empty($merchant)) {
            Flash::error('Merchent not found');

            return redirect(route('merchants.index'));
        }

        return view('merchants.edit')
        ->with('merchant', $merchant)
        ->with('package', $package);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $oldmerchant = $this->merchantRepository->findWithoutFail($id);

        if (empty($oldmerchant)) {
            Flash::error('merchant not found');
            return redirect(route('merchants.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->merchantRepository->model());
        try {

            $merchant = $this->merchantRepository->update($input, $id);
            if (isset($input['image_id']) && $input['image_id']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image_id']);
                $mediaItem = $cacheUpload->getMedia('image_id')->first();
                $mediaItem->copy($merchant, 'image_id');
            }
            if (isset($input['image_cr']) && $input['image_cr']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image_cr']);
                $mediaItem = $cacheUpload->getMedia('image_cr')->first();
                $mediaItem->copy($merchant, 'image_cr');
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $merchant->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.merchant')]));

        return redirect(route('merchants.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Merchant  $merchant
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        //
        $merchant = Merchant::findOrFail($id);
        if (empty($merchant)) {
            Flash::error('merchant not found');

            return redirect(route('merchants.index'));
        }
        $merchant = Merchant::findOrFail($id)->delete();


        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.merchant')]));

        return redirect(route('merchants.index'));
    }
}
