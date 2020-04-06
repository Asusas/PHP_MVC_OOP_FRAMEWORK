<?php require APPROOT . '/views/includes/header.php'?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5">
    <h2>Edit post</h2>
    <p>Edit a post</p>
    <form action="<?php echo URLROOT ?>/posts/editPostById/<?php echo $data['post']->id ?>" method="POST">

        <div class="form-group">
            <label for="text">Title: <sup>*</sup> </label>
            <input type="text" name="title"
                class=" form-control form-control-lg <?php echo (!empty($data['title_error'])) ? 'is-invalid' : ''; ?>"
                value="<?php echo $data['post']->title; ?>">
            <span class="invalid-feedback"><?php echo $data['title_error'] ?></span>
        </div>
        <div class="form-group">
            <label for="body">Body: <sup>*</sup> </label>
            <textarea rows="8" name="body"
                class=" form-control form-control-lg <?php echo (!empty($data['body_error'])) ? 'is-invalid' : ''; ?>"><?php echo $data['post']->body; ?></textarea>
            <span class="invalid-feedback"><?php echo $data['body_error'] ?></span>
        </div>
        <input class="btn btn-success" type="submit" value="Update post">
    </form>
</div>

<?php require APPROOT . '/views/includes/footer.php'?>