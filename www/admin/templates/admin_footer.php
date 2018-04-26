<?php defined('MYBOOK') or die('Access denied'); ?>
</div><!-- .page_wrapper -->
<script type="text/javascript" src="lib/js/ajax.js"></script>
<script type="text/javascript" src="lib/js/js_admin.js"></script>
<script type="text/javascript" src="lib/js/leftbar.js"></script>
<script type="text/javascript" src="lib/js/content.js"></script>
<script type="text/javascript" src="lib/js/loadimage.js"></script>
<script>
window.onload = function() {
    var lb = new Leftbar({
        lbId: 'leftbar'
    });
    
    var content = new Content({
        contentId: 'content'
    });
};
</script>
</body>
</html>