<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
class Chat extends Model
{
    //
    protected $table='chat';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['send_id', 'receive_id','msg','send_time'];

    /**
     * 应用场景：新增
     * @return json
     */
    public function store($data)
    {
        $data['send_time'] = time();

        if($this->create($data)){
            return ['code' => returnCode("SUCCESS")];
        }else {
            return ['code' => returnCode("ERROR")];
        }
    }

    public function pull($data)
    {
        $where = [];
        $orwhere = [];

        if(isset($data['send_id']) && isset($data['receive_id'])){

            $where[] = ['chat.send_id', $data['send_id']];

            $where[] = ['chat.receive_id', $data['receive_id']];

            $orwhere[] = ['chat.send_id', $data['receive_id']];

            $orwhere[] = ['chat.receive_id', $data['send_id']];

            $result0 = DB::table('chat')->select('admin.username as rename','admin.logo as relogo','chat.*')
            ->leftJoin('admin', 'admin.id', '=', 'chat.receive_id')
            ->where($where)->orderBy('id','desc')->get();

            $result1 = DB::table('chat')->select('admin.username as rename','admin.logo as relogo','chat.*')
            ->leftJoin('admin', 'admin.id', '=', 'chat.receive_id')
            ->where($orwhere)->orderBy('id','desc')->get();

            $result = array_merge($result0,$result1);
            $newRe = [];
            foreach ($result as $key => $value) {

                $values = get_object_vars($value);

                $newRe[$key] = $values;

                $newRe[$key]['send_time'] = date('Y-m-d H:i:s',$values['send_time']);
                $newRe[$key]['relogo'] = "http://".$_SERVER['HTTP_HOST'].$values['relogo'];
            }
            return ['code' => returnCode("SUCCESS"), 'msg' => $newRe];

        }else {
            return ['code' => returnCode("ERROR")];
        }
    }
}
