<?php
namespace addons\touPiao\controller;


use addons\touPiao\model\VoteBaoming;
use app\common\controller\Addon;
use think\Controller;

class Admin extends Addon
{
    public $adminLogin=true;//需要管理员登录才可操作本控制器
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        
    }

    public function index(){
        $bmModel = new VoteBaoming();
        if($keyword=input('keyword')){
            $result=$bmModel
                ->where(['mpid'=>$this->mid])
                ->where('bm_id|username','like','%'.$keyword.'%')
                ->order('vote_total DESC')
                ->paginate(20);
        }else{
            $result=$bmModel
                ->where(['mpid'=>$this->mid])
                ->order('vote_total DESC')
                ->paginate(20);
        }
        $this->assign('data',$result);
        $this->fetch();
    }

    public function voteHidden(){
        $bmModel = new VoteBaoming();
        $where['bm_id']=input('id');
        $where['mpid']=$this->mid;
        $bmModel->save(['status'=>input('status')],$where);
        ajaxMsg('1','操作成功');
    }

    public function voteSetinc(){
        if(!is_numeric(input('vote'))){
            ajaxMsg('0','输入的不是数字');
        }
        $bmModel = new VoteBaoming();
        $where['bm_id']=input('id');
        $where['mpid']=$this->mid;
        $bmModel->where($where)->setInc('vote_total',input('vote'));

    }

}