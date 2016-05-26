<?php

namespace App\Repositories;

use App\Models\LogicalDevice;
use InfyOm\Generator\Common\BaseRepository;

class LogicalDeviceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ip',
        'type',
        'username',
        'password',
        'os',
        'os_version',
        'service',
        'nicinfo',
        'physicaldevice',
        'note'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LogicalDevice::class;
    }
}
