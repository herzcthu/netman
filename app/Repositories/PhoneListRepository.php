<?php

namespace App\Repositories;

use App\Models\PhoneList;
use InfyOm\Generator\Common\BaseRepository;

class PhoneListRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'phone',
        'server',
        'service_type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PhoneList::class;
    }
}
