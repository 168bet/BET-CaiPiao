<?php
/**
 * 头像处理类
 *
 * @author tangkh<tangkh@yeah.net>
 * @time 20160401
 */

class avatar
{
    /**
     * 根据uid获取头像url
     *
     * @param int $uid 用户id
     * @return array 四个尺寸用户头像数组
     */
    public function getavatar($uid)
    {
        $dir1 = ceil($uid / 10000);
        $dir2 = ceil($uid % 10000 / 1000);
        $upload_url = pc_base::load_config('system', 'upload_url');
        $url = $upload_url.'avatar/'.$dir1.'/'.$dir2.'/'.$uid.'/';
        $avatar = array('180'=>$url.'180x180.jpg', '90'=>$url.'90x90.jpg', '45'=>$url.'45x45.jpg', '30'=>$url.'30x30.jpg');
        return $avatar;
    }

    /**
     *  上传头像处理
     *  传入头像压缩包，解压到指定文件夹后删除非图片文件
     *
     * @param int $uid 用户ID
     */
    public function uploadavatar($uid)
    {
        //根据用户id创建文件夹
        $postStr = file_get_contents("php://input");
        if($postStr) {
            $this->uid = intval($uid);
            $this->avatardata = $postStr;
        } else {
            exit('0');
        }

        $dir1 = ceil($this->uid / 10000);
        $dir2 = ceil($this->uid % 10000 / 1000);

        //创建图片存储文件夹
        $avatarfile = pc_base::load_config('system', 'upload_path').'avatar/';
        $dir = $avatarfile.$dir1.'/'.$dir2.'/'.$this->uid.'/';
        if(!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        //存储flashpost图片
        $filename = $dir.'180x180.jpg';

        $fp = fopen($filename, 'w');
        fwrite($fp, $this->avatardata);
        fclose($fp);

        $avatararr = array('180x180.jpg', '30x30.jpg', '45x45.jpg', '90x90.jpg');
        $files = glob($dir."*");
        foreach($files as $_files) {
            if(is_dir($_files)) dir_delete($_files);
            if(!in_array(basename($_files), $avatararr)) @unlink($_files);
        }
        if($handle = opendir($dir)) {
            while(false !== ($file = readdir($handle))) {
                if($file !== '.' && $file !== '..') {
                    if(!in_array($file, $avatararr)) {
                        @unlink($dir.$file);
                    } else {
                        $info = @getimagesize($dir.$file);
                        if(!$info || $info[2] !=2) {
                            @unlink($dir.$file);
                        }
                    }
                }
            }
            closedir($handle);
        }

        pc_base::load_sys_class('image','','0');
        $image = new image(1,0);
        $image->thumb($filename, $dir.'30x30.jpg', 30, 30);
        $image->thumb($filename, $dir.'45x45.jpg', 45, 45);
        $image->thumb($filename, $dir.'90x90.jpg', 90, 90);

        $this->db = pc_base::load_model('member_model');
        $this->db->update(array('avatar'=>1), array('userid'=>$this->uid));
        exit('1');
    }

    /**
     *  删除用户头像
     *
     *  @param int $uid 用户ID
     *  @return bool {0:失败;1:成功}
     */
    public function deleteavatar($uid)
    {
        //根据用户id创建文件夹
        $this->uid = $uid;

        $dir1 = ceil($this->uid / 10000);
        $dir2 = ceil($this->uid % 10000 / 1000);

        //图片存储文件夹
        $avatarfile = pc_base::load_config('system', 'upload_path').'avatar/';
        $dir = $avatarfile.$dir1.'/'.$dir2.'/'.$this->uid.'/';
        $this->db = pc_base::load_model('member_model');
        $this->db->update(array('avatar'=>0), array('userid'=>$this->uid));
        if(!file_exists($dir)) {
            //如果是ajax请求才执行exit，其他内部调用返回布尔值,下同   edit by lxt 2016.04.13
            if (is_ajax()) {
                exit('1');
            }else{
                return true;
            }
        } else {
            if($handle = opendir($dir)) {
                while(false !== ($file = readdir($handle))) {
                    if($file !== '.' && $file !== '..') {
                        @unlink($dir.$file);
                    }
                }
                closedir($handle);
                @rmdir($dir);
                if (is_ajax()) {
                    exit('1');
                }else{
                    return true;
                }
            }
        }
    }


}

