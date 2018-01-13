<?php
namespace Common\Model;
use Think\Model;

/**
 * 文章内容content model操作
 * @author  singwa
 */
class NewsContentModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('content');
    }
    public function insert($data=array()){
        if(!$data || !is_array($data)) {
            return 0;
        }s
        public function insert($data=array()){
            if(!$data || !is_array($data)) {
                return 0;
            }
        $data['create_time'] = time();
        if(isset($data['content']) && $data['content']) {
            $data['content'] = htmlspecialchars($data['content']);
        }
        return $this->_db->add($data);

    }
    public function find($id) {
        return $this->_db->where('news_id='.$id)->find();
    }
    public function updateNewsById($id, $data) {
        if(!$id || !is_numeric($id) ) {
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)) {
            throw_exception('更新数据不合法');
        }
        if(isset($data['content']) && $data['content']) {
            $data['content'] = htmlspecialchars($data['content']);
        }

        return $this->_db->where('content_id='.$id)->save($data);
    }

    public function getBarMenus() {
        $data = array();

        $res = $this->_db->where($data)
//            ->order('content_id desc')
            ->select();
        return $res;
    }
    public function getContent($post) {
        $data = array(
           'content_id'=> $post,
        );
        $res = $this->_db->where($data)
//            ->order('content_id desc')
            ->select();
        return $res;
    }
}
