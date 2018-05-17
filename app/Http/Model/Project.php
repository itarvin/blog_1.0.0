<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Project extends Model
{
    protected $table='project';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
