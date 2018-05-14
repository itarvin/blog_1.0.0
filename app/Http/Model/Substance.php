<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
class Substance extends Model
{
    //
    protected $table='substance';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];
}
