<?php
include '../../functions.php';

yimian__header();
yimian__headerEnd();
?>
<?php aplayer__element()?>
<?php aplayer__setup()?>
<?php $rand=rand(0,300);aplayer__netease(808097971,$rand,$rand+10);?>

<?php yimian__footer();?>
