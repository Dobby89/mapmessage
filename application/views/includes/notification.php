<div class="notification_block <?php echo $class ? $class : 'info'; ?>">
    <p class="message"><?php echo $message; ?> <a class="close" href="#" onClick="$(this).parents('.notification_block').fadeOut(300); return false;">Click to close.</a></p>
</div>