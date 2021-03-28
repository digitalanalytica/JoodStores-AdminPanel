<?php

namespace App\Repositories;

use App\Country;
use App\Models\Field;
use App\Package;
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
class PackageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'monthly_price',
        'six_month_price',
        'one_year_price',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Package::class;
    }
}
