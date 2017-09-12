<?php
//遍历已有图片目录生成缩略图
//缩略图尺寸为150*150(小)、350*350(中)

define('ROOT_PATH', dirname(__DIR__).'/');
define('CMS_PATH', ROOT_PATH.'phpcms/');
define('CORE_PATH', CMS_PATH.'libs/');

require_once CMS_PATH.'base.php';
require_once CORE_PATH.'functions/dir.func.php';
require_once CORE_PATH.'classes/image.class.php';

//上传目录
define('UPLOAD_PATH', dir_path(ROOT_PATH.'uploadfile/'));
//选择缩略图目录
fwrite(STDOUT, 'Tip: At '.UPLOAD_PATH."\n");
fwrite(STDOUT, "The directories you may choose as follows: \n");
$dir_tree = '';
foreach(dir_tree(UPLOAD_PATH) as $dir)
{
    if(preg_match('@uploadfile/(avatar|poster|photo)/@', $dir['dir'])) continue;
    $dir_tree .= str_replace(UPLOAD_PATH, '', $dir['dir']).' ';
}
fwrite(STDOUT, $dir_tree."\n");
fwrite(STDOUT, "Please enter directory name (eg. 2016/0509/): ");
//检查受保护的目录(avatar、poster、photo)
$dirname = trim(fgets(STDIN));
while(preg_match('/^(avatar|poster|photo)/', $dirname))
{
    fwrite(STDOUT, "Warning: The directory $dirname has been protected.\n");
    fwrite(STDOUT, "Please enter directory name again (eg. 2016/0509/): ");
    $dirname = trim(fgets(STDIN));
}
$path = dir_path(UPLOAD_PATH.$dirname);
fwrite(STDOUT, 'The directory you choose is '.$path."\n");

//生成缩略图
$files = dir_list($path);
if(is_array($files) && !empty($files))
{
    //初始化image
    $image = new image(1, 1);
    //缩略图尺寸
    $sizes = array(
        150,    //150*150
        350     //350*350
    );

    fwrite(STDOUT, "Task start...\n");
    foreach($files as $file)
    {
        //过滤掉.或..
        if(is_dir($file)) continue;
        //过滤掉缩略图
        if(strpos($file, 'thumb') !== false) continue;

        $filepath = dir_path(dirname($file));
        $basename = basename($file);
        $filename = $filepath.'thumb_size_'.$basename;
        foreach($sizes as $size)
        {
            if(file_exists(str_replace('size', $size, $filename))) continue;
            $image->thumb($file, str_replace('size', $size, $filename), $size, $size);
            fwrite(STDOUT, str_replace('size', $size, $filename)." has been created.\n");
        }
    }

    exit("Task complete.");
}
else
{
    exit('file not found.');
}



