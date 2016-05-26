<?php

namespace App\Repositories;

use App\Models\Device;
use InfyOm\Generator\Common\BaseRepository;

class DeviceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ip',
        'deviceid',
        'os',
        'osver',
        'rack',
        'vendor',
        'nicinfo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Device::class;
    }
}
