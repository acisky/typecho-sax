<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div class="col-md-4 sidebar">
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
                    <?php TePostViews_Plugin::outputHotPosts() ?>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="random">
                <div class="side-list">
                    <ul>
                    <?php RandomArticleList::parse(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="sticker">
    <?php if($this->is('index')): ?>
        <?php if($this->options->gameList){ ?>
        <div class="panel">
            <div class="panel-heading">
                <h5>游戏排行榜</h5>
            </div>
            <div class="panel-body">
                <div class="rank-list">
                    <ul>
                    <?php filterLevel($this->options->gameList) ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php }  ?>
    <?php elseif($this->is('post')): ?>
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