<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class Config extends Model
{
    protected $table='config';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['title', 'name','content', 'sort_num', 'field_value', 'field_type', 'is_system'];

    //表单验证规则
    public $rules = [
        'name'    => 'required',
        'field_type'  => 'required',
    ];

    //自定义消息显示
    protected $messages = [
        'name.required'      => '名称不能为空',
        'field_type.required'=> '类型字段不能为空',
    ];

    /**
     * 应用场景：新增 || 修改
     * @return json
     */
    public function store($data)
    {

        $validator = Validator::make($data, $this->rules, $this->messages);

        if ($validator->passes()) {

            if(isset($data['id'])){

                if($this->where('id', $data['id'])->update($data)){

                    return ['code' => returnCode("SUCCESS"), 'msg'=>'更新成功！'];
                }

            }else {

                if($this->create($data)){

                    return ['code' => returnCode("SUCCESS"), 'msg'=>'添加成功！'];
                }
            }
            return ['code' => returnCode("ERROR"), 'msg'=>'操作失败！'];
        }else {

            return ['code' => returnCode("ERROR"), 'msg'=> $validator];
        }
    }


    public function search()
    {
        $data = $this->orderBy('sort_num','asc')->get();
        $count = $this->count();

        foreach ($data as $k => $v) {

            switch ($v->field_type) {
                case 'input':

                    $data[$k]->_html = '<input type="text" class="layui-input" name="content[]" value="'.$v->content.'">';

                    break;

                case 'textarea':

                    $data[$k]->_html = '<textarea type="text" class="layui-textarea" name="content[]">'.$v->content.'</textarea>';
                    break;

                case 'radio':

                    $arr = explode('，',$v->field_value);

                    $str = '';

                    foreach($arr as $m=>$n){

                        $r = explode('|',$n);

                        $c = $v->content==$r[0]?' checked ':'';

                        $str .= '<input type="radio" name="content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';

                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }
        $result['data'] = $data;
        $result['count'] = $count;
        return $result;
    }


    /**
     * 应用场景：检测删除
     * @return json
     */
    public function checkDelete($cid)
    {
        if($cid){

            $isSys = $this->select('is_system')->find($cid);

            if($isSys['is_system'] == '0'){

                if($this->where('id', $cid)->delete()){

                    return ['code' => returnCode("SUCCESS"), 'msg'=>'操作成功！'];
                }else {

                    return ['code' => returnCode("ERROR"), 'msg'=>'操作失败！'];
                }
            }
            return ['code' => returnCode("ERROR"), 'msg'=>'系统字段，禁止删除！'];
        }
    }
}
