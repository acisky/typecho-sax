<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>


<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
 
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>
 
<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">
    <div id="<?php $comments->theId(); ?>">
        <div class="comment-inner">
            <div class="comment-avatar">
                <?php
                    //头像CDN by Rich
                    $host = 'https://gravatar.loli.net'; //自定义头像CDN服务器
                    $url = '/avatar/'; //自定义头像目录,一般保持默认即可
                    $rating = Helper::options()->commentsAvatarRating;
                    $hash = md5(strtolower($comments->mail));
                    $email = strtolower($comments->mail);
                    $qq=str_replace('@qq.com','',$email);
                    if(strstr($email,"qq.com") && is_numeric($qq) && strlen($qq) < 11 && strlen($qq) > 4)
                    {
                        $avatar = '//q.qlogo.cn/g?b=qq&nk='.$qq.'&s=100';
                    }else{
                        $avatar = $host . $url . $hash . '&r=' . $rating . '&d=mm';
                    }
                ?>
                <img class="lazyload" data-original="<?php echo $avatar ?>" />
            </div>
            <div class="comment-meta">
                <span class="comment-author">
                    <?php $comments->author(); ?>
                </span>
                <span class="comment-time">
                    <a href="<?php $comments->permalink(); ?>" target="_top"><?php $comments->date('Y-m-d H:i'); ?></a>
                </span>
                <span class="comment-reply"><?php $comments->reply(); ?></span>
            </div>
            <div class="comment-content">
                <?php $comments->content(); ?>
            </div>
        </div>
    </div>
<?php if ($comments->children) { ?>
    <div class="comment-children">
        <?php $comments->threadedComments($options); ?>
    </div>
<?php } ?>
</li>
<?php } ?>

<div class="comments" id="comments">
    <?php $this->comments()->to($comments); ?>

    <?php if($this->allow('comment')): ?>
    <div class="comment-title">
        <h3><?php _e('添加新评论'); ?></h3>
    </div>
    <div class="comments-form" id="<?php $this->respondId(); ?>">
        <div class="cancel-comment-reply">
            <?php $comments->cancelReply(); ?>
        </div>
        <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
            <?php if($this->user->hasLogin()): ?>
            <p class="comment-user"><?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
            <?php else: ?>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">昵称</span>
                    <input type="text" class="form-control" name="author" id="author" />
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">邮箱</span>
                    <input type="text" class="form-control" name="mail" id="mail" />
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">网站</span>
                    <input type="text" class="form-control" name="url" id="url" />
                </div>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <textarea class="form-control" rows="3" id="textarea" name="text" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};"
                        placeholder="请在这里输入你的评论内容" required=""></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-default btn-block" type="submit" id="submit">提交评论 (Ctrl + Enter)</button>
            </div>
        </form>
    </div>
    <?php else: ?>
    <!-- 待添加 -->
    <div class="comment-disabled">
        <h3><?php _e('评论已关闭'); ?></h3>
    </div>
    <?php endif; ?>

    <?php if ($comments->have()): ?>
    <div class="comment-title">
        <h3><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h3>
    </div>
    <div class="comments-list">
    <?php $comments->listComments(); ?>
    </div>
    <div class="pages">
    <?php $comments->pageNav('<i class="fa fa-angle-double-left"></i>', '<i class="fa fa-angle-double-right"></i>',1, '...', array('wrapTag' => 'ul', 'wrapClass' => 'pagination', 'itemTag' => 'li', 'textTag' => 'a', 'currentClass' => 'active')); ?>
    </div>
    <?php endif; ?>
</div>
