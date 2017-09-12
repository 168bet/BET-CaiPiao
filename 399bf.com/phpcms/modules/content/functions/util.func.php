<?php
/**
 * 分页函数
 * 
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $pageurls 链接地址
 * @return 分页
 */
function content_pages($num, $curr_page,$pageurls) {
	$multipage = '';
	$page = 5;
	$offset = 1;
	$pages = $num;
	$from = $curr_page - $offset;
	$to = $curr_page + $offset;
	$more = 0;
	if($page >= $pages) {
		$from = 2;
		$to = $pages-1;
	} else {
		if($from <= 1) {
			$to = $page-1;
			$from = 2;
		} elseif($to >= $pages) {
			$from = $pages-($page-2);
			$to = $pages-1;
		}
		$more = 1;
	}
	if($curr_page>0) {
		$perpage = $curr_page == 1 ? 1 : $curr_page-1;
		$multipage .= '<li class="prev"><a class="a1" href="'.$pageurls[$perpage][0].'"><i class="icon-arrow-left arrow-color"></i></a></li>';
		if($curr_page==1) {
			$multipage .= ' <li class="active"><span>1</span></li>';
		} elseif($curr_page>3 && $more) {
			$multipage .= ' <li><a href="'.$pageurls[1][0].'">1</a></li>..';
		} else {
			$multipage .= ' <li><a href="'.$pageurls[1][0].'">1</a></li>';
		}
	}
	for($i = $from; $i <= $to; $i++) {
		if($i != $curr_page) {
			$multipage .= ' <li><a href="'.$pageurls[$i][0].'">'.$i.'</a></li>';
		} else {
			$multipage .= ' <li class="active"><span>'.$i.'</span></li>';
		}
	}
	if($curr_page<$pages) {
		if($curr_page<$pages-5 && $more) {
			$multipage .= ' ...<li><a href="'.$pageurls[$pages][0].'">'.$pages.'</a></li> <li class="next"><a class="a1" href="'.$pageurls[$curr_page+1][0].'"><i class="icon-arrow-right arrow-color"></i></a></li>';
		} else {
			$multipage .= ' <li><a href="'.$pageurls[$pages][0].'">'.$pages.'</a></li> <li class="next"><a class="a1" href="'.$pageurls[$curr_page+1][0].'"><i class="icon-arrow-right arrow-color"></i></a></li>';
		}
	} elseif($curr_page==$pages) {
		$multipage .= ' <li class="active"><span>'.$pages.'</span></li> <li class="next"><a class="a1" href="'.$pageurls[$curr_page][0].'"><i class="icon-arrow-right arrow-color"></i></a></li>';
	}

	$multipage .= ' <li class="ft12"><spna class="page-grey mr5">PAGE</spna><b class="page-cur">'.$curr_page.'</b><spna class="page-grey"><b>/</b>'.$pages.'</spna></li>';

	return $multipage;
}

?>