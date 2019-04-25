<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="container main">
    <div class="row">
        <div class="col-md-8">
            <ol class="breadcrumb current">
                <li><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                <li class="active"><?php $this->title() ?></li>
            </ol>
            <div class="post">
                <h3 class="post-title"><?php $this->title() ?></h3>
                <div class="post-body">
                    <?php $this->content(); ?>
                </div>
            </div>
            <?php $this->need('comments.php'); ?>
        </div>
        <?php $this->need('sidebar.php'); ?>
    </div>
</div>

<?php $this->need('footer.php'); ?>
