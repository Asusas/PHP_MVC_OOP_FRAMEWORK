<?php require APPROOT . '/views/includes/header.php'?>

<form action="<?php echo URLROOT ?>/page/send" method="POST" enctype="multipart/form-data">
    <div class="col-lg-6 mx-auto bg-light card card-body">
        <div><?php echo success_message() ?></div>
        <h5 class="text-center">If you have any questions, please send us an email</h5>
        <hr>

        <div class="form-group">
            <label for="subject">Subject: <sup>*</sup> </label>
            <input type="text" name="subject"
                class=" form-control form-control-sm <?php echo (!empty($data['subject_error'])) ? 'is-invalid' : ''; ?>"
                value="<?php echo isset($data['subject']) ? $data['subject'] : ''; ?>">
            <span class="invalid-feedback"><?php echo $data['subject_error'] ?></span>
        </div>

        <div class="form-group">
            <label for="subject">Your email: <sup>*</sup> </label>
            <input type="email" name="email"
                class=" form-control form-control-sm <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>"
                value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
            <span class="invalid-feedback"><?php echo $data['email_error'] ?></span>
        </div>

        <div class="form-group">
            <label for="message">Message: <sup>*</sup> </label>
            <textarea name="message" type="textarea"
                class=" form-control form-control-sm <?php echo (!empty($data['message_error'])) ? 'is-invalid' : ''; ?>"
                placeholder="Type your message"
                rows="7"><?php echo isset($data['message']) ? $data['message'] : ''; ?></textarea>
            <span class="invalid-feedback"><?php echo $data['message_error'] ?></span>
        </div>

        <div class="form-group">
            <label for="message">Select file: </label>
            <input type="file" name="file" class=" form-control form-control-sm">
        </div>


        <div class="col">
            <input type="submit" name="submit" value="Send" class="btn btn-success btn-block btn-sm">
        </div>

    </div>
</form>

<?php require APPROOT . '/views/includes/footer.php'?>