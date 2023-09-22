<?php
namespace Code\MongoDb\Models;

use Code\MongoDb\Eloquent\Model as MongoModel;
use App\Utils\Consts;
use Illuminate\Support\Facades\Crypt;

class Model extends MongoModel
{
    const CREATED_AT = 'c_at';
    const UPDATED_AT = 'u_at';
    const DELETED_AT = 'd_at';

    protected $hidden = [
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];

    public function getKeyAttribute()
    {
        return Crypt::encrypt($this->primaryKey);
    }
}