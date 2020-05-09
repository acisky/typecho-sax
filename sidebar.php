<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php if($this->is('post')): ?>
    <div class="col-md-3 hidden-md hidden-sm hidden-xs sidebar">
        <div class="panel">
            <div class="panel-heading">
                <h5>标签云</h5>
            </div>
            <div class="panel-body">
                <div class="tags-list">
                    <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=30')->to($tags); ?>
                    <?php if($tags->have()): ?>
                    <?php while ($tags->next()): ?>
                        <a href="<?php $tags->permalink(); ?>" rel="tag" class="label label-default" data-toggle="tooltip" title="<?php $tags->count(); ?> 个话题"><?php $tags->name(); ?></a>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <p><?php _e('没有任何标签'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div id="sticker">
            <div class="panel">
                <div class="panel-body">
                    <div class="near-list">
                        <ul>
                            <li class="pre">
                                <p><span class="label label-default">上一篇</span></p>
                                <?php prev_post($this) ?>
                            </li>
                            <li class="next">
                                <p><span class="label label-default">下一篇</span></p>
                                <?php next_post($this) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="col-md-4 hidden-md hidden-sm hidden-xs sidebar">
    <div class="side-tab">
        <ul class="nav nav-justified" role="tablist">
            <li role="presentation" class="active"><a href="#new" aria-controls="home" role="tab" data-toggle="tab"><i class="n1"></i>最新发布</a></li>
            <li role="presentation"><a href="#hot" aria-controls="home" role="tab" data-toggle="tab"><i class="n2"></i>热门文章</a></li>
            <li role="presentation"><a href="#random" aria-controls="home" role="tab" data-toggle="tab"><i class="n3"></i>随机文章</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" role="tabpanel" id="new">
                <div class="side-list">
                    <ul>
                    <?php getRecentPosts($this,8); ?>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="hot">
                <div class="side-list">
                    <ul>
                    <?php gethotPosts($this,8) ?>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="random">
                <div class="side-list">
                    <ul>
                    <?php getRandomPosts($this,8); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="sticker">
    <?php if($this->is('index')): ?>
        <div class="panel">
            <div class="panel-heading">
                <h5>评论列表</h5>
            </div>
            <div class="panel-body">
                <div class="side-comments">
                    <ul>
                    <?php $this->widget('Widget_Comments_Recent','ignoreAuthor=true&pageSize=5')->to($comments); ?>
                    <?php while($comments->next()): ?>
                        <li>
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

                                echo '<img src="' . $avatar . '" class="avatar" />';
                            ?>
                            <p class="author"><a href="<?php $comments->permalink(); ?>" class="label"><?php $comments->author(false); ?></a><small><?php echo date('Y-m-d', $comments->created) ?></small></p>
                            <p class="excerpt"><?php $comments->excerpt(30, '...'); ?></p>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>        
    <?php else: ?>
        <div class="panel">
            <div class="panel-heading">
                <h5>标签云</h5>
            </div>
            <div class="panel-body">
                <div class="tags-list">
                    <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=30')->to($tags); ?>
                    <?php if($tags->have()): ?>
                    <?php while ($tags->next()): ?>
                        <a href="<?php $tags->permalink(); ?>" rel="tag" class="label label-default" data-toggle="tooltip" title="<?php $tags->count(); ?> 个话题"><?php $tags->name(); ?></a>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <p><?php _e('没有任何标签'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>

<?php endif; ?>

