<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="container main">
    <div class="row">
        <div class="col-md-8">
            <?php
                $categories = $this->categories;
                foreach($categories as $cate) {
                    $catename = $cate['name'];
                    $catelink = $cate['permalink'];
                }
            ?>
            <ol class="breadcrumb current">
                <li><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                <li><a href="<?php echo $catelink; ?>"><?php echo $catename; ?></a></li>
                <li class="active"><?php $this->title() ?></li>
            </ol>
            <div class="post">
                <h3 class="post-title"><?php $this->title() ?></h3>
                <div class="post-meta"><span><i class="glyphicon glyphicon-time"
                            aria-hidden="true"></i><?php $this->date('Y.m.d'); ?></span><span><i class="glyphicon glyphicon-eye-open"
                            aria-hidden="true"></i> 次阅读</span><span><i class="glyphicon glyphicon-comment"
                            aria-hidden="true"></i><?php $this->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?></span></div>
                <div class="post-body">
                    <?php
                        $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
                        $replacement = '<a href="$1" data-lightbox="lightbox" /><img src="$1" /></a>';
                        $content = preg_replace($pattern, $replacement, $this->content);
                        echo $content;
                    ?>
                </div>
                <div class="post-tags">
                    <i class="glyphicon glyphicon-tags"></i><span><?php tags($this); ?></span>
                </div>
            </div>
            <?php $this->need('comments.php'); ?>
        </div>
        <?php $this->need('sidebar.php'); ?>
    </div>
</div>

<?php $this->need('footer.php'); ?>
