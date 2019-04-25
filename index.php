<?php
/**
 * 根据默认皮肤修改的主题
 *
 * @package Typecho Sax Theme
 * @author Aci
 * @version 1.0
 * @link http://typecho.org
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="container main">
	<div class="row">
		<div class="col-md-8">
			<?php if($this->options->bannerId){ ?>
				<?php renderBanner($this->options->bannerId); ?>
			<?php }  ?>
			<?php while($this->next()): ?>
			<div class="card">
				<a href="<?php $this->permalink() ?>" class="card-thumb">
				<?php if($this->fields->img): ?>
					<div class="thumb-pic lazyload"
					data-original="<?php $this->fields->img(); ?>">
					</div>
				<?php else: ?>
				<div class="thumb-pic lazyload"
					data-original="<?php echo get_postthumb($this) ?>">
					</div>
				<?php endif; ?>
				</a>
				<div class="card-inner">
					<h5><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h5>
					<div class="meta"><span><i class="glyphicon glyphicon-time"
								aria-hidden="true"></i><?php $this->date('Y.m.d'); ?></span><span><i
								class="glyphicon glyphicon-file" aria-hidden="true"></i><?php $this->category(','); ?></span><span><i
								class="glyphicon glyphicon-comment" aria-hidden="true"></i><a itemprop="discussionUrl" href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?></a></span></div>
					<p class="desc"><?php $this->excerpt(160, ' ...'); ?></p>
				</div>
			</div>
			<?php endwhile; ?>
			<div class="pages">
				<?php $this->pageNav('←', '→',1, '...', array('wrapTag' => 'ul', 'wrapClass' => 'pagination', 'itemTag' => 'li', 'textTag' => 'a', 'currentClass' => 'active')); ?>
			</div>
		</div>
		<?php $this->need('sidebar.php'); ?>
	</div>
</div>

<?php $this->need('footer.php'); ?>
