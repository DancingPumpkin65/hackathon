<!DOCTYPE html>
<html lang="en">
<head>
    <title>Simple Footer with Dark Social Icons</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        footer {
            background-color: #fff;
            color: #333; 
            text-align: center;
            font-family: 'Poppins', sans-serif;
            bottom: 0;
            width: 100%;
            border-top: 1px solid rgba(128, 128, 128, 0.212);
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        footer img{
            width: 55px;
            margin-top: 6px;
        }

        footer a{
            height: 0;
            
        }

        .social-icons a {
            color: #00529B; 
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        i {
            font-size:1.3rem;
        }
        footer .ft {
            padding: 0;
        }
    </style>
</head>
<body>

<footer>
    <div class="ft">
        <a href="index.php"><img src="../images/ofppt.png" alt="OFPPT Logo"></a>
    </div>
    <div>
        <p>© Développé par L'OFPPT</p>
    </div>
    <div class="social-icons">
        <a href="https://www.facebook.com" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.twitter.com" title="Twitter"><i class="fab fa-twitter"></i></a>
        <a href="https://www.linkedin.com" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
    </div>
</footer>

</body>
</html>