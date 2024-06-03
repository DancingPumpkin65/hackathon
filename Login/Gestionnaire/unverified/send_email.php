<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<script src="https://cdn.emailjs.com/dist/email.min.js"></script>
<script>
    emailjs.init("vKxMHYKJvJKYG8DeL");

    function sendEmail(email) {
        var templateParams = {
            to_email: email,
            message: "Congratulations! Your application has been accepted."
        };

        emailjs.send("service_fc6af2r", "template_ifz7p24", templateParams)
            .then(function(response) {
                console.log("Notification email sent successfully!", response);
                window.location.href = "unverified.php";
            }, function(error) {
                console.error("Notification email could not be sent", error);
            });
    }

</script>
    
</html>
