<?php

namespace App\Http\Controllers;

use App\DataTables\AdSliderDataTable;
use App\Http\Requests\CreateAdSliderRequest;
use App\Http\Requests\UpdateAdSliderRequest;
use App\Repositories\AdSliderRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\MarketRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UploadRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;
use Laracasts\Flash\Flash;


class AdSliderController extends Controller
{
    /** @var  AdSliderRepository */
    private $slideRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var MarketRepository
     */
    private $marketRepository;

    /**
     * AdSliderController constructor.
     * @param AdSliderRepository $slideRepo
     * @param CustomFieldRepository $customFieldRepo
     * @param UploadRepository $uploadRepo
     * @param ProductRepository $productRepo
     * @param MarketRepository $marketRepo
     */
    public function __construct(AdSliderRepository $slideRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo
        , ProductRepository $productRepo
        , MarketRepository $marketRepo)
    {
        parent::__construct();
        $this->slideRepository = $slideRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
        $this->productRepository = $productRepo;
        $this->marketRepository = $marketRepo;
    }

    /**
     * Display a listing of the AdSlider.
     *
     * @param AdSliderDataTable $slideDataTable
     * @return Response
     */
    public function index(AdSliderDataTable $slideDataTable)
    {
        return $slideDataTable->render('slider.index');
    }

    /**
     * Show the form for creating a new AdSlider.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function create()
    {
        $product = $this->productRepository->pluck('name', 'id');
        $market = $this->marketRepository->pluck('name', 'id');

        $hasCustomField = in_array($this->slideRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->slideRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('slider.create')->with("customFields", isset($html) ? $html : false)->with("product", $product)->with("market", $market);
    }

    /**
     * Store a newly created AdSlider in storage.
     *
     * @param CreateAdSliderRequest $request
     *
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->slideRepository->model());
        try {
            $slide = $this->slideRepository->create($input);
            $slide->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($slide, 'image');
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.slide')]));

        return redirect(route('slider.index'));
    }

    /**
     * Display the specified AdSlider.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function show($id)
    {
        $slide = $this->slideRepository->findWithoutFail($id);

        if (empty($slide)) {
            Flash::error('Ad Slider not found');

            return redirect(route('slider.index'));
        }

        return view('slider.show')->with('slide', $slide);
    }

    /**
     * Show the form for editing the specified AdSlider.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function edit($id)
    {
        $slide = $this->slideRepository->findWithoutFail($id);
        $product = $this->productRepository->pluck('name', 'id')->toArray();
        $market = $this->marketRepository->pluck('name', 'id')->toArray();
        $product = array('' => trans('lang.slide_product_id_placeholder')) + $product;
        $market = array('' => trans('lang.slide_market_id_placeholder')) + $market;


        if (empty($slide)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.slide')]));

            return redirect(route('slider.index'));
        }
        $customFieldsValues = $slide->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->slideRepository->model());
        $hasCustomField = in_array($this->slideRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('slider.edit')->with('slide', $slide)->with("customFields", isset($html) ? $html : false)->with("product", $product)->with("market", $market);
    }

    /**
     * Update the specified AdSlider in storage.
     *
     * @param int $id
     * @param UpdateAdSliderRequest $request
     *
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function update($id, UpdateAdSliderRequest $request)
    {
        $slide = $this->slideRepository->findWithoutFail($id);

        if (empty($slide)) {
            Flash::error('AdSlider not found');
            return redirect(route('slider.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->slideRepository->model());
        try {
            if (!isset($input['product_id'])) {
                $input['product_id'] = null;
            }
            if (!isset($input['market_id'])) {
                $input['market_id'] = null;
            }
            $slide = $this->slideRepository->update($input, $id);

            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($slide, 'image');
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $slide->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.slide')]));

        return redirect(route('slider.index'));
    }

    /**
     * Remove the specified AdSlider from storage.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function destroy($id)
    {
        $slide = $this->slideRepository->findWithoutFail($id);

        if (empty($slide)) {
            Flash::error('AdSlider not found');

            return redirect(route('slider.index'));
        }

        $this->slideRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.slide')]));

        return redirect(route('slider.index'));
    }

    /**
     * Remove Media of AdSlider
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $slide = $this->slideRepository->findWithoutFail($input['id']);
        try {
            if ($slide->hasMedia($input['collection'])) {
                $slide->getFirstMedia($input['collection'])->delete();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
