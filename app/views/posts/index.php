<?php require APPROOT . '/views/includes/header.php'?>

<div><?php echo success_message() ?></div>
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Posts</h1>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT ?>/posts/addPost" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i>
            Add
            post</a>
    </div>
</div>
<?php foreach ($data['posts'] as $post): ?>
<div class="card card-body mb-3">
    <h4><?php echo $post->title; ?></h4>
    <div class="bg-light p-2 mb-3">
        Written by <?php echo $post->name ?>
    </div>
    <p class="card-text"><?php echo $post->body ?></p>
    <a href="<?php echo URLROOT ?>/posts/showPost/<?php echo $post->id ?>" class="btn btn-dark btn-sm">More</a>
</div>
<?php endforeach;?>

<?php require APPROOT . '/views/includes/footer.php'?>