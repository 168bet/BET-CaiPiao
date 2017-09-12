<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/20
 * Time: 15:47
 */
class validate {
    //验证是否通过
    private $failed = false;
    //错误信息预设值
    private $message = array(
        'required'  =>  ':attribute为必填项',
        'unique'    =>  '该:attribute已被注册',
        'equal'     =>  ':attribute有误，请重新输入',
        'accept'    =>  '请接受此栏'
    );
    //需要验证的数据
    private $data = array();
    //错误信息
    private $error_message = array();
    //数据库
    private $db;

    /**
     * validate constructor.
     */
    public function __construct()
    {
        $this->db = pc_base::load_model('member_model');
    }

    /**
     * 开始验证
     * @param array $attributes
     * @param array $rules
     */
    public function check (array $attributes, array $rules, array $message = array()) {
        //验证数据
        $this->data = $attributes;
        //自定义错误信息
        if (count($message)) {
            $this->message = array_merge($this->message, $message);
        }
        foreach ($rules as $key => $value) {
            //多个规则通过|分开
            $rule = explode('|', $value);
            foreach ($rule as $str) {
                $this->parse($str, $key);
            }
        }
    }

    /**
     * 验证规则解析
     * @param $string
     */
    private function parse($string, $key)
    {
        list($func, $params) = explode(':', $string);
        $this->{$func}($params, $key);
    }

    /**
     * 必填
     * @param $params
     */
    private function required($params, $key)
    {
        $data = $this->data[$key];
        //空
        if (empty(trim($data)) || is_null($data) || !isset($this->data[$key])) {
            $this->failed($key, __FUNCTION__);
        }
    }

    /**
     * 唯一性验证
     * @param $params
     */
    private function unique($params, $key)
    {
        $data = $this->data[$key];
        list($table, $field, $except_field, $except_value) = explode(',', $params);
        //查询条件
        $where = ($field ? $field : $key) . '="' . $data . '"';
        //例外,用于更新操作
        $where .= ($except_field && $except_value) ? ' AND ' . $except_field . '<>"' . $except_value . '"' : '';
        //sql
        $sql = 'SELECT COUNT(1) AS `count` FROM ' . $table . ' WHERE ' . $where;
        //统计查询
        $tmp = $this->db->query($sql);
        $result = $tmp->fetch_array(MYSQLI_ASSOC);
        if ($result['count']) {
            $this->failed($key, __FUNCTION__);
        }
    }

    /**
     * 相同验证，如确认密码
     * @param $params
     * @param $key
     */
    private function equal($params, $key)
    {
        $data = $this->data[$key];
        if (! isset($this->data[$params]) || $this->data[$params] != $data) {
            $this->failed($key, __FUNCTION__);
        }
    }

    /**
     * 接受验证，如接受协议
     * @param $params
     * @param $key
     */
    private function accept($params, $key)
    {
        $data = $this->data[$key];
        if ($data != 1 && $data != true) {
            $this->failed($key, __FUNCTION__);
        }
    }

    /**
     * 验证过程中，处理验证失败信息
     * @param $key
     * @param $rule
     */
    private function failed($key, $rule)
    {
        $this->failed = true;
        $this->error_message[$key][] = str_replace(':attribute', L($key), $this->message[$rule]);
    }

    /**
     * 验证结束后，判断本次验证是否有失败信息
     * @return bool
     */
    public function is_failed()
    {
        return $this->failed;
    }

    /**
     * 获取本次验证的错误提示
     * @return array
     */
    public function tip()
    {
        return $this->error_message;
    }
}