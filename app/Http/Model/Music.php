<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class Music extends Model
{
    //
    protected $table='music';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];

    protected $fillable = ['title', 'url','author','smallimg','description','addtime'];

    //表单验证规则
    public $rules = [
        'title' => 'required',
        'url' => 'required',
        'smallimg' => 'required',
        'description' => 'required',
    ];

    //自定义消息显示
    protected $messages = [
        'title.required' => '标题不能为空',
        'url.required'   => '链接地址不能为空',
        'smallimg.required'    => '图片不能为空',
        'description.required'    => '简介不能为空',
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

                $data['addtime'] = date('Y-m-d H:i:s',time());

                if($this->create($data)){

                    return ['code' => returnCode("SUCCESS"), 'msg'=>'添加成功！'];
                }
            }
            return ['code' => returnCode("ERROR"), 'msg'=>'操作失败！'];
        }else {

            return ['code' => returnCode("ERROR"), 'msg'=> $validator];
        }
    }

    /**
     * 应用场景：检测删除
     * @return json
     */
    public function checkDelete($nid)
    {
        if($nid){

            $imgInfo = $this->select('pictures')->find($nid);
            unlink("./".$imgInfo['pictures']);

            if($this->where('id', $nid)->delete()){

                return ['code' => returnCode("SUCCESS"), 'msg'=>'操作成功！'];
            }else {

                return ['code' => returnCode("ERROR"), 'msg'=>'操作失败！'];
            }
        }
    }

}
