<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * _page-archive
 *
 * @package custom
 *
 */$this->need('header.php');
?>

<div class="container main">
    <div class="row grid">
        <div class="col-md-8">
            <ol class="breadcrumb current">
                <li><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                <li class="active"><?php $this->title() ?></li>
            </ol>
            <div class="post">
                <div class="timeline">
                    <?php
                        $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);   
                        $year=0; $mon=0; $i=0; $j=0;
                        $output ='';
                        $commentText = '';
                        while($archives->next()):   
                            $year_tmp = date('Y',$archives->created);   
                            $mon_tmp = date('m',$archives->created);   
                            $y=$year; $m=$mon;
                            if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';   
                            if ($year != $year_tmp && $year > 0) $output .= '</ul>';   
                            if ($year != $year_tmp) {   
                                $year = $year_tmp;   
                                $output .= '<ul class="al_mon_list">'; //输出年份   
                            }
                            if ($mon != $mon_tmp) {   
                                $mon = $mon_tmp;
                                $output .= '<li><span class="al_mon" data-toggle="tooltip" title="' .$year. ' 年 '. $mon .' 月"><i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i></span><ul class="al_post_list">'; //输出月份   
                            }
                            if($archives->commentsNum > 0) {
                                $commentText = $archives->commentsNum .'条评论';
                            } else {
                                $commentText = '暂无评论';
                            }
                            $output .= '<li><span class="label label-default">'.date('d日 ',$archives->created).'</span><a href="'.$archives->permalink .'">'. $archives->title .'</a> <span class="nums"><i
                            class="glyphicon glyphicon-comment" aria-hidden="true"></i> '. $commentText.'</span></li>'; //输出文章日期和标题   
                        endwhile;   
                        $output .= '</ul></li></ul>';
                        echo $output;
                    ?>
                </div>
            </div>
        </div>
        <?php $this->need('sidebar.php'); ?>
    </div>
</div>

<?php $this->need('footer.php'); ?>
