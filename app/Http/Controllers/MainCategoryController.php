<?php

namespace App\Http\Controllers;

use App\DataTables\MainCategoryDataTable;
use App\Http\Requests\CreateMainCategoryRequest;
use App\Http\Requests\UpdateMainCategoryRequest;
use App\Repositories\MainCategoryRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\UploadRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;
use Laracasts\Flash\Flash;

class MainCategoryController extends Controller
{
    /** @var  MainCategoryRepository */
    private $categoryRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;

    public function __construct(MainCategoryRepository $categoryRepo, CustomFieldRepository $customFieldRepo , UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->categoryRepository = $categoryRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param MainCategoryDataTable $categoryDataTable
     * @return Response
     */
    public function index(MainCategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('maincategories.index');
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function create()
    {
        $hasCustomField = in_array($this->categoryRepository->model(),setting('custom_field_models',[]));
        if($hasCustomField){
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->categoryRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('maincategories.create')->with("customFields", isset($html) ? $html : false);
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateMainCategoryRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function store(CreateMainCategoryRequest $request)
    {
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->categoryRepository->model());
        try {
            $category = $this->categoryRepository->create($input);
            $category->customFieldsValues()->createMany(getCustomFieldsValues($customFields,$request));
            if(isset($input['image']) && $input['image']){
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($category, 'image');
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully',['operator' => __('lang.category')]));

        return redirect(route('maincategories.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('maincategories.index'));
        }

        return view('maincategories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);



        if (empty($category)) {
            Flash::error(__('lang.not_found',['operator' => __('lang.category')]));

            return redirect(route('maincategories.index'));
        }
        $customFieldsValues = $category->customFieldsValues()->with('customField')->get();
        $customFields =  $this->customFieldRepository->findByField('custom_field_model', $this->categoryRepository->model());
        $hasCustomField = in_array($this->categoryRepository->model(),setting('custom_field_models',[]));
        if($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('maincategories.edit')->with('category', $category)->with("customFields", isset($html) ? $html : false);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateMainCategoryRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function update($id, UpdateMainCategoryRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');
            return redirect(route('maincategories.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->categoryRepository->model());
        try {
            $category = $this->categoryRepository->update($input, $id);

            if(isset($input['image']) && $input['image']){
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($category, 'image');
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value){
                $category->customFieldsValues()
                    ->updateOrCreate(['custom_field_id'=>$value['custom_field_id']],$value);
            }
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully',['operator' => __('lang.category')]));

        return redirect(route('maincategories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('Category not found');

            return redirect(route('categories.index'));
        }

        $this->categoryRepository->delete($id);

        Flash::success(__('lang.deleted_successfully',['operator' => __('lang.category')]));

        return redirect(route('maincategories.index'));
    }

    /**
     * Remove Media of Category
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $category = $this->categoryRepository->findWithoutFail($input['id']);
        try {
            if($category->hasMedia($input['collection'])){
                $category->getFirstMedia($input['collection'])->delete();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
