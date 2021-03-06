<?php
namespace Common\Model;
use Think\Model;

class ColumnModel extends  Model {
    private $_db = '';
    public function __construct() {
        $this->_db = M('Columns');
    }

    public function insert($data = array()) {
        if(!$data || !is_array($data)) {
            return 0;
        }
        return $this->_db->add($data);
    }

    public function getMenus($data,$page,$pageSize=10) {
        $data['status'] = array('neq',-1);
        $offset = ($page - 1) * $pageSize;
        $list = $this->_db->where($data)->order('columns_id desc')->limit($offset,$pageSize)->select();
        return $list;
    }

    public function getMenusCount($data= array()) {
        $data['status'] = array('neq',-1);
        return $this->_db->where($data)->count();
    }
    
    //根据id得到栏目
    public function find($id){
        if(!$id || !is_numeric($id)) {
            return array();
        }
        return $this->_db->where('column_id='.$id)->find();
    }

    public function updateMenuById($id, $data) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }

        if(!$data || !is_array($data)) {
            throw_exception('更新的数据不合法');
        }

        return $this->_db->where('column_id='.$id)->save($data);

    }

    public function updateStatusById($id, $status) {
        if(!is_numeric($id) || !$id) {
            throw_exception("ID不合法");
        }
        if(!is_numeric($status) || !$status) {
            throw_exception("状态不合法");
        }

        $data['status'] = $status;
        return $this->_db->where('column_id='.$id)->save($data);
    }

    public function getAdminMenus() {
        $data = array(

        );

        return $this->_db->where($data)->order('column_id desc')->select();
    }

    public function getColumn() {
        $data = array(
            'column_type'=>1,
            'column_parentid' => array('neq',0)
        );

        $res = $this->_db->where($data)->order('column_id')->select();
        return $res;
    }


    //获取主栏目法；
    public function getParentColumn($data){
        $conditions = $data;
        // if(isset($data['title']) && $data['title']) {
        //     $conditions['title'] = array('like','%'.$data['title'].'%');
        // }
        
        if(isset($data['columnid']) && $data['columnid'])  {
            $conditions['columnid'] = intval($data['columnid']);
        }
//        $conditions['status'] = array('neq',-1);

        $list = $this->_db->where($conditions)
            ->order('columnid')
            ->select();

        return $list;
    }

    //获取子栏目
    public function getChildColumns($columnid) {

        $list = $this->_db->where('column_parentid = '.$columnid)->select();

        return $list;
    }
}