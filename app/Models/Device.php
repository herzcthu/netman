<?php

namespace App\Models;

use Eloquent as Model;

/**
 * @SWG\Definition(
 *      definition="Device",
 *      required={},
 *      @SWG\Property(
 *          property="ip",
 *          description="ip",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="deviceid",
 *          description="deviceid",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="os",
 *          description="os",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="osver",
 *          description="osver",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="rack",
 *          description="rack",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="vendor",
 *          description="vendor",
 *          type="string"
 *      )
 * )
 */
class Device extends Model
{

    public $table = 'devices';
    

    protected $primaryKey = 'ip';

    public $fillable = [
        'ip',
        'deviceid',
        'os',
        'rack',
        'user_id',
        'nicinfo',
        'username',
        'password',
        'vendor',
        'details'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'ip' => 'string',
        'deviceid' => 'integer',
        'os' => 'string',
        'osver' => 'string',
        'rack' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'ip' => 'required|unique:devices'
    ];
    
    /**
     * Validation rules for update
     *
     * @var array
     */
    public static $updaterules = [
        //'ip' => 'unique:devices,ip,'
    ];
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    public function logicalDevices() {
        return $this->hasMany('App\Models\LogicalDevice');
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
