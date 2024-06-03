<?php
session_start();
if (isset($_SESSION['isUserLoggedIn']) && $_SESSION['userType'] === 'gestionnaire') {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Header</title>
        <?php include "need.php"; ?>
    </head>
    
    <body>
        <?php include "head_main.php"; ?>
        
        <div class="content" class="home">
            
        </div>

        <script>
            const body = document.querySelector('body'),
                  sidebar = body.querySelector('nav'),
                  toggle = body.querySelector(".toggle"),
                  searchBtn = body.querySelector(".search-box"),
                  modeSwitch = body.querySelector(".toggle-switch"),
                  modeText = body.querySelector(".mode-text");

            toggle.addEventListener("click", () => {
                sidebar.classList.toggle("close");
                if (sidebar.classList.contains("close")) {
                    document.querySelector('.content').style.marginLeft = '78px';
                } else {
                    document.querySelector('.content').style.marginLeft = '250px';
                }
            });

            searchBtn.addEventListener("click", () => {
                sidebar.classList.remove("close");
                document.querySelector('.content').style.marginLeft = '250px';
            });

            modeSwitch.addEventListener("click", () => {
                body.classList.toggle("dark");

                if (body.classList.contains("dark")) {
                    modeText.innerText = "Light mode";
                } else {
                    modeText.innerText = "Dark mode";
                }
            });
        </script>
        <?php include "footer.php"; ?>

    </body>
    
    </html>
    <?php
} else {
    header("Location: login.php");
    exit();
}
?>
        <style>
            .conteur_gestioner {
                height: 15rem;
                width: 15rem;
                background-color: aqua;
                display: flex;
                align-items: center;
                justify-content: center;
            }
    
            .main_gestioner {
                padding: 3vw;
                height: 45vh;
                width: 75vw;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .content {
                margin-left: 250px; /* Adjust this margin to fit the sidebar width */
                height: 100vh;
               
            }

            body.dark .content {
                margin-left: 78px; 
            }
            @media only screen and (max-width: 600px){
                .main_gestioner {
                padding: 0;
                height: 0rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: space-around;
                background-color: green;
                
            }
            .content {
                margin-left: 100px; /* Adjust this margin to fit the sidebar width */
                height: 100vh;
                width: 30vw;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: space-around;
                background-color: black;

                
            }
            #dash1{
                font-size: 1rem;

            }
            #dash1_div{
                
                height: fit-content;
            }
            }
            .card-body div {
                display: flex;
                align-items: center;
                justify-content: center;
            }

        </style>