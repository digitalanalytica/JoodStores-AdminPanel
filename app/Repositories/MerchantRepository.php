<?php

namespace App\Repositories;
use App\Merchant;
use App\Models\Field;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FieldRepository
 * @package App\Repositories
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @method Field findWithoutFail($id, $columns = ['*'])
 * @method Field find($id, $columns = ['*'])
 * @method Field first($columns = ['*'])
*/
class MerchantRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'full_name',
        'shop_name',
        'email',
        'phone',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Merchant::class;
    }
}
