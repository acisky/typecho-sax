<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<footer class="footer">
    <div class="container">
        <p>
            <?php _e('Powered by <a href="https://www.typecho.org" target="_blank">Typecho</a>'); ?>
            <em> · </em>
            <?php _e('Theme <a href="https://www.aciuz.com" target="_blank">Sax</a>'); ?>
            Processed in <?php echo timer_stop(false,4) ?> second(s)
            <em> · </em>
            Gzip <?php echo is_Gzip()?'ON':'OFF' ?>
            <em> · </em>
            SSL <?php echo is_SSL()?'ON':'OFF' ?>
        </p>
        <p>
            &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a> All right reserved.
            <?php if($this->options->beian){ ?>
                <?php $this->options->beian(); ?>
            <?php } ?>
            <em> · </em>
            <a href="<?php $this->options->feedUrl(); ?>"><?php _e('文章 RSS'); ?></a>
            <em> · </em>
            <a href="<?php $this->options->commentsFeedUrl(); ?>"><?php _e('评论 RSS'); ?></a>
        </p>
    </div>
</footer>
<script src="<?php $this->options->themeUrl('js/jquery.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/bootstrap.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/jquery.lazyload.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/sticky.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/lightbox.min.js'); ?>"></script>
<script>
 $(document).ready(function(){
    $(window).scroll(function(){
        if($(window).scrollTop() > 50) {
            $("body").addClass("header-fixed")
        } else {
            $("body").removeClass("header-fixed")
        }
    })

    $('[data-toggle="tooltip"]').tooltip()
    $(".lazyload").lazyload({
        failurelimit:40
    });
    $("#sticker").sticky({topSpacing:70,bottomSpacing: 120,});

    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
    
});
    
</script>
<?php $this->footer(); ?>
</body>
</html>
