<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * _page-github
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

            </div>
        </div>
        <?php $this->need('sidebar.php'); ?>
    </div>
</div>

<?php $this->need('footer.php'); ?>
