<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    protected $table='category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];


    /**
     * 应用场景：获取树状结构数组
     * @return json
     */
    public function tree()
    {
        $categorys = $this->orderBy('cate_order','asc')->get();
        return $this->getTree($categorys,'cate_name','cate_id','cate_pid');
    }

    /**
     * 应用场景：内调函数
     * @return json
     */
    public function getTree($data,$field_name,$field_id='id',$field_pid='pid',$pid=0)
    {
        $arr = [];

        foreach ($data as $k=>$v){

            if($v->$field_pid==$pid){

                $data[$k]["_".$field_name] = $data[$k][$field_name];

                $arr[] = $data[$k];

                foreach ($data as $m=>$n){

                    if($n->$field_pid == $v->$field_id){

                        $data[$m]["_".$field_name] = '├─ '.$data[$m][$field_name];

                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
