<?php

namespace App\Models;

use Eloquent as Model;

/**
 * @SWG\Definition(
 *      definition="LogicalDevice",
 *      required={},
 *      @SWG\Property(
 *          property="ip",
 *          description="ip",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="username",
 *          description="username",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="password",
 *          description="password",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="os",
 *          description="os",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="os_version",
 *          description="os_version",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="service",
 *          description="service",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="nicinfo",
 *          description="nicinfo",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="physicaldevice",
 *          description="physicaldevice",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="adminuser",
 *          description="adminuser",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="note",
 *          description="note",
 *          type="string"
 *      )
 * )
 */
class LogicalDevice extends Model
{

    public $table = 'logical_devices';
    

    protected $primaryKey = 'ip';

    public $fillable = [
        'ip',
        'type',
        'username',
        'password',
        'os',
        'details',
        'service',
        'nicinfo',
        'device',
        'note',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'ip' => 'string',
        'type' => 'string',
        'username' => 'string',
        'password' => 'string',
        'os' => 'string',
        'os_version' => 'string',
        'service' => 'string',
        'nicinfo' => 'string',
        'device' => 'string',
        'adminuser' => 'integer',
        'note' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'ip' => 'unique:logical_devices'
    ];
    
    /**
     * Validation rules for update
     *
     * @var array
     */
    public static $updaterules = [
        //'ip' => 'unique:logical_devices'
    ];
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    public function device() {
        return $this->belongsTo('App\Models\Device');
    }
    
    public function setOsAttribute($value)
    {
        $this->attributes['os'] = json_encode($value);
    }
    
    public function getOsAttribute($value)
    {
        return json_decode($value,true);
    }
    
    public function setNicinfoAttribute($value)
    {
        $this->attributes['nicinfo'] = json_encode($value);
    }
    
    public function getNicinfoAttribute($value)
    {
        return json_decode($value,true);
    }
}
