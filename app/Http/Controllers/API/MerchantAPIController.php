<?php
/**
 * File name: MarketAPIController.php
 * Last modified: 2020.05.04 at 09:04:19
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Merchant;
use App\Repositories\CustomFieldRepository;
use App\Repositories\MerchantRepository;
use App\Repositories\UploadRepository;
use Flash;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class MerchantController
 * @package App\Http\Controllers\API
 */

class MerchantAPIController extends Controller
{
    /** @var  MerchantRepository */
    private $merchantRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;


    public function __construct(MerchantRepository $merchantRepo,
                                CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->merchantRepository = $merchantRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;

    }
    /**
     * Store a newly created Merchant in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function merchant(Request $request)
    {
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model',
            $this->merchantRepository->model());
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
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($merchant->toArray(), __('lang.saved_successfully', ['operator' => __('lang.merchant')]));
    }
}
