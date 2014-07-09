<?php $this->load->view('includes/header'); ?>

<h1><?php echo $thread['title']; ?></h1>
<p><?php echo $thread['content']; ?></p>

<?php if($comments) { ?>

    <h2>Comments</h2>

    <?php foreach($comments as $comment) { ?>

        <div>
            <p><?php echo $comment['content']; ?></p>
        </div>
    <?php } ?>
<?php } ?>

<?php $this->load->view('includes/footer'); ?>