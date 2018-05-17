<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Log extends Model
{
    protected $table='addr';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['user_id', 'country','country_id','region', 'area','area_id', 'region_id', 'city','city_id','county', 'isp', 'isp_id', 'ip', 'login_time','useragent','logintype'];


    /**
     * 应用场景：日志添加（静默）
     */
    public function takeNotes()
    {
        // $data = makeIpInfo((new Request)->getClientIp());
        $data = makeIpInfo('223.74.180.50');
        $data['user_id'] = session("uid");
        $data['login_time'] = date('Y-m-d H:i:s',time());
    	$data['useragent'] = $_SERVER['HTTP_USER_AGENT'];
        $this->create($data);
    }
}
