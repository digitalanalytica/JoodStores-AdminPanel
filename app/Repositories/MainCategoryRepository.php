<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\MainCategory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @method Category findWithoutFail($id, $columns = ['*'])
 * @method Category find($id, $columns = ['*'])
 * @method Category first($columns = ['*'])
*/
class MainCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'name_ar',
        'description_ar',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MainCategory::class;
    }
}
