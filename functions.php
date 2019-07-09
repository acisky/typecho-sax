<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
timer_start();
function themeConfig($form) {
    $bannerId = new Typecho_Widget_Helper_Form_Element_Text('bannerId', NULL, NULL, _t('文章ID'), _t('切换效果的文章id，用,分割'));
    $beian = new Typecho_Widget_Helper_Form_Element_Textarea('beian', NULL, NULL, _t('备案号'), _t('可以放置备案号或者统计'));
    $form->addInput($bannerId);
    $form->addInput($beian);
}

function themeFields($layout) {
    $img = new Typecho_Widget_Helper_Form_Element_Text('img', NULL, NULL, _t('缩略图'), _t('输入缩略图url'));
    $layout->addItem($img);
}

function prev_post($archive)
{
    $db = Typecho_Db::get();
    $content = $db->fetchRow($db->select()
            ->from('table.contents')
            ->where('table.contents.created < ?', $archive->created)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $archive->type)
            ->where('table.contents.password IS NULL')
            ->order('table.contents.created', Typecho_Db::SORT_DESC)
            ->limit(1));
    if ($content) {
        $content = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($content);
        echo '<a href="' . $content['permalink'] . '">' . $content['title'] . '</a>';
    } else {
        echo '<strong>没有了</strong>';
    }
}

function next_post($archive)
{
    $db = Typecho_Db::get();
    $content = $db->fetchRow($db->select()
            ->from('table.contents')
            ->where('table.contents.created > ? AND table.contents.created < ?', $archive->created, Helper::options()->gmtTime)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $archive->type)
            ->where('table.contents.password IS NULL')
            ->order('table.contents.created', Typecho_Db::SORT_ASC)
            ->limit(1));
    if ($content) {
        $content = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($content);
        echo '<a href="' . $content['permalink'] . '">' . $content['title'] . '</a>';
    } else {
        echo '<strong>没有了</strong>';
    }
}

function format_date($time)
{
    $nowtime = time();
    $difference = $nowtime - $time;
    switch ($difference) {
        case $difference <= '60':
            $msg = '刚刚';
            break;
        case $difference > '60' && $difference <= '3600':
            $msg = floor($difference / 60) . '分钟前';
            break;
        case $difference > '3600' && $difference <= '86400':
            $msg = floor($difference / 3600) . '小时前';
            break;
        case $difference > '86400' && $difference <= '2592000':
            $msg = floor($difference / 86400) . '天前';
            break;
        case $difference > '2592000' && $difference <= '7776000':
            $msg = floor($difference / 2592000) . '个月前';
            break;
        case $difference > '7776000':
            $msg = '很久以前';
            break;
    }

    echo $msg;
}

function timer_get(){
	$mtime = explode(' ',microtime());
	return $mtime[1] + $mtime[0];
}

function timer_start(){
	global $timestart;
	$timestart = timer_get();
}

function timer_stop($display = false,$precision = 3){
	global $timestart;
	$timetotal = timer_get()-$timestart;
	$r = number_format( $timetotal, $precision );
	if($display) echo $r;
	return $r;
}

function is_SSL(){
	if(!isset($_SERVER['HTTPS'])) return FALSE;
	if($_SERVER['HTTPS']===1) return TRUE; //Apache
	elseif($_SERVER['HTTPS']==='on') return TRUE; //IIS
	elseif($_SERVER['SERVER_PORT']==443) return TRUE; //其他
	return FALSE;
}

function is_Gzip(){
	return !(strpos(strtolower($_SERVER['HTTP_ACCEPT_ENCODING']),'gzip') === false)?true:false;
}

function tags($widget, $split = ',', $default = NULL){
    if ($widget->tags) {
        $result = array();
        foreach ($widget->tags as $tag) {
            $result[] = '<a href="'.$tag['permalink'].'" class="label label-default">'.$tag['slug'].'</a>';
        }
        echo implode($split, $result);
    } else {
        echo $default;
    }
}

function filterLevel($text) {
    $array = explode("|", $text);
    $arrlength=count($array);
    for($x=0;$x<$arrlength;$x++) {
        $num = $x + 1;
        if($num <= 3) {
            echo '<li><em class="level'.$num.'">'.$num.'</em>'.$array[$x].'</li>';
        } else {
            echo '<li><em>'.$num.'</em>'.$array[$x].'</li>';
        }
    }
}

function getId($id) {
    $getid = explode(',',$id);
    $db = Typecho_Db::get();
    $result = $db->fetchAll($db->select()->from('table.fields')
        ->join('table.contents', 'table.contents.cid = table.fields.cid',Typecho_Db::INNER_JOIN)
        ->where('table.contents.cid in ?',$getid)
        ->where('table.fields.name = ?','img')
        ->where('table.contents.type = ?', 'post')
        ->order('table.contents.cid', Typecho_Db::SORT_DESC)
    );
    return $result;
}

function renderBanner($text,$class='banner',$size=80) {
    $array = getId($text);
    $arrlength=count($array);

    echo '<div id="carousel-example-generic" class="carousel '.$class.'" data-ride="carousel">';
    echo '<ol class="carousel-indicators">';
    for($x=0;$x<$arrlength;$x++) {
        if($x == 0) {
            echo '<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>';
        } else {
            echo '<li data-target="#carousel-example-generic" data-slide-to="0"></li>';
        }
    }
    echo '</ol>';
    echo '<div class="carousel-inner" role="listbox">';

    for($x=0;$x<$arrlength;$x++) {
        if($x == 0) {
            echo '<div class="item active">';
        } else {
            echo '<div class="item">';
        }
        $val = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($array[$x]);
        $post_title = htmlspecialchars($val['title']);
        $desc = mb_substr($val['text'], 0, $size, 'utf-8');
        $permalink = $val['permalink'];
        $img = $val['str_value'];

        echo '<a href="'.$permalink.'">';
        echo '<div class="banner-pic" style="background-image:url('.$img.')"></div>';
        echo '<div class="carousel-caption">';
        echo '<h3>'.$post_title.'</h3>';
        echo '<p>'.$desc.'</p>';
        echo '</div></a></div>';
    }

    echo '</div>';
    echo '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
    </a>';
    echo '<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
    </a>';
    echo '</div>';
}

function getRecentPosts($obj,$pageSize){
    $db = Typecho_Db::get();
    $rows = $db->fetchAll($db->select('cid')
       ->from('table.contents')
       ->where('type = ? AND status = ?', 'post', 'publish')
       ->order('created', Typecho_Db::SORT_DESC)
       ->limit($pageSize));
    foreach($rows as $row){
        $cid = $row['cid'];
        $apost = $obj->widget('Widget_Archive@post_'.$cid, 'type=post', 'cid='.$cid);
        $output = '<li><a href="'.$apost->permalink .'"><span>' . date('Y-m-d', $apost->created) . '</span>'. $apost->title .'</a></li>';
        echo $output;
    }
}

function gethotPosts($obj,$pageSize) {
    $db = Typecho_Db::get();
    $rows = $db->fetchAll($db->select()->from('table.contents')
        ->where('type = ?', 'post')
        ->where('status = ?', 'publish')
        ->limit($pageSize)
        ->order('commentsNum', Typecho_Db::SORT_DESC));
    foreach($rows as $row){
        $cid = $row['cid'];
        $apost = $obj->widget('Widget_Archive@post_'.$cid, 'type=post', 'cid='.$cid);
        $output = '<li><a href="'.$apost->permalink .'"><span>' . date('Y-m-d', $apost->created) . '</span>'. $apost->title .'</a></li>';
        echo $output;
    }
}

function getRandomPosts($obj,$pageSize){
    $db = Typecho_Db::get();
    $rows = $db->fetchAll($db->select()->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'post')
        ->where('created <= unix_timestamp(now())', 'post')
        ->limit($pageSize)
        ->order('RAND()'));
    foreach($rows as $row){
        $cid = $row['cid'];
        $apost = $obj->widget('Widget_Archive@post_'.$cid, 'type=post', 'cid='.$cid);
        $output = '<li><a href="'.$apost->permalink .'"><span>' . date('Y-m-d', $apost->created) . '</span>'. $apost->title .'</a></li>';
        echo $output;
    }
}

function get_postthumb($obj) {
    preg_match_all( "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $obj->content, $matches );
    $thumb = '';
    $attach = $obj->attachments(1)->attachment;
    if($obj->fields->img) {
        $thumb = $obj->fields->img;
    }elseif(isset($attach->isImage) && $attach->isImage == 1){
        $thumb = $attach->url;
    }elseif(isset($matches[1][0])){
        $thumb = $matches[1][0];
    } else {
        $thumb = '';
    }
    return $thumb;
}
