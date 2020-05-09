<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * _page-links
 *
 * @package custom
 *
 */$this->need('header.php');
?>

<div class="container main">
    <div class="link-list">
        <div class="row grid">
            <?php Links_Plugin::output($pattern='<div class="col-md-3"><div class="item"><a href="{url}"><i class="favicon"><img src="{image}" /></i><p>{name}</p><span>{title}</span></a></div></div>', $links_num=0, $sort=NULL); ?>
        </div>
    </div>
</div>

<?php $this->need('footer.php'); ?>
