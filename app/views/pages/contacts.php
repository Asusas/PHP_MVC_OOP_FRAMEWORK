<?php require APPROOT . '/views/includes/header.php'?>

<form action="<?php echo URLROOT ?>/page/send" method="POST">
    <div class="col-lg-6 mx-auto">
        <div><?php echo success_message() ?></div>
        <h5 class="text-center">If you have any questions, please send us an email</h5>
        <hr>
        <div class="form-group">
            <label for="subject">Subject: <sup>*</sup> </label>
            <input type="text" name="subject"
                class=" form-control form-control-lg <?php echo (!empty($data['subject_error'])) ? 'is-invalid' : ''; ?>"
                value="<?php echo $data['subject']; ?>">
            <span class="invalid-feedback"><?php echo $data['subject_error'] ?></span>
        </div>


        <div class="form-group">
            <label for="message">Message: <sup>*</sup> </label>
            <textarea name="message" type="textarea"
                class=" form-control form-control-lg <?php echo (!empty($data['message_error'])) ? 'is-invalid' : ''; ?>"
                placeholder="Type your message" rows="7"><?php echo $data['message']; ?></textarea>
            <span class="invalid-feedback"><?php echo $data['message_error'] ?></span>
        </div>


        <div class="col">
            <input type="submit" name="submit" value="Send" class="btn btn-success btn-block btn-sm">
        </div>

    </div>
</form>

<?php require APPROOT . '/views/includes/footer.php'?>