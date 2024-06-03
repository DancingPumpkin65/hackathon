<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['isUserLoggedIn']) || $_SESSION['isUserLoggedIn'] !== true) {
    header('Location: login.php');
    exit;
}

$user_data = $_SESSION['user_data'];
?>

<!DOCTYPE html>
<html lang="en">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 0.625rem 1.25rem; 
            color: black;
            position: relative; 
            width: 100vw;
            border-bottom: 1px solid rgba(128, 128, 128, 0.212);
        }

        #part1 {
            display: flex;
            align-items: center;
        }

        .active {
            color: #00529B;
        }

        #part1 img {
            height: 3.125rem;
            margin-right: 1.25rem;
        }

        #part1 ul {
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.25rem;
            margin-bottom: 0;
        }

        #part1 ul li {
            margin-left: 2rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        #part1 ul li:hover {
            color: #047de7;
        }

        #part1 ul li a {
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: color 0.3s;
            color: #00529B;
        }

        #part1 ul li:hover {
            color: #047de7;
        }

        #part2 {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            position: relative;
        }

        #part2 .connect {
            background: none;
            border: 1px solid white;
            color: #00529B;
            padding: 0rem 0.5rem;
            width: 13rem;
            height: 3rem;
            border-radius: 0.3125rem;
            border: 1px solid rgba(128, 128, 128, 0.212);
            transition: background-color 0.3s, color 0.3s;
            display: flex;
            align-items: center;
            justify-items: center;
        }

        #part2 .insc {
            border: 1px solid white;
            color: white;
            padding: 0.3125rem 0;
            width: 9rem;
            border-radius: 0.3125rem;
            background: rgb(29,122,208);
            background: linear-gradient(330deg, rgba(29,122,208,1) 0%, rgba(17,71,122,1) 100%);
            transition: background-color 0.3s, color 0.3s;
        }

        #part2 .insc:hover {
            cursor: pointer;
        }

        #part2 .connect:hover {
            background-color: rgba(128, 128, 128, 0.212);
            color: #333;
            cursor: pointer;
        }

        #part2 .toggle {
            display: none;
            position: absolute;
            top: 105%;
            left: 0;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 0.3125rem;
            flex-direction: column;
            width: 13rem;
            
        }

        #part2 .toggle a {
            margin: 0.125rem;
            padding: 0.1875rem 0.8125rem;
            font-size: 0.8rem;
            color: #00529B;
            background-color: white;
            text-decoration: none;
            border-radius: 0.3125rem;
            transition: background-color 0.3s;
        }

        #part2 .toggle a:hover {
            background-color: rgba(128, 128, 128, 0.212);
            color: #333;
        }

        #part1 a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #menuIcon {
            display: none;
            font-size: 1.5rem;
            color: #00529B;
            cursor: pointer;
            position: absolute;
            top: 50%;
            right: 1.25rem;
            transform: translateY(-50%);
        }

        @media (max-width: 800px) {
            #part1 ul, #part2 {
                display: none;
            }

            #menuIcon {
                display: block;
            }

            nav.expanded #part1 ul, nav.expanded #part2 {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                position: absolute;
                top: calc(100% + 0.625rem);
                left: 0;
                width: 100%;
                background-color: white;
                padding: 1rem;
                gap: 1rem;
            }
        }

        .show {
            display: none;
        }
        #connectBtn {
            display: flex;
            align-items: center;
            justify-content: space-around;
            position: relative;
        }
        #connectBtn img {
            width: 3rem;
            height: 3rem;
            border: 1px solid black;
            border-radius: 5px;
            border: none;
        }
    </style>
</head>
<body>
    <nav>
        <div class="hide" id="part1">
            <a href="souvenirs.php"><img src="../ofppt.png" alt="Logo"></a>
            <ul>
                <li class="active"><a href="souvenirs.php" style="text-decoration:none;color:black;">SOUVENIR</a></li>
                <li><a href="../avis/sabmit-avis.php" style="text-decoration:none;color:black;">AVIS</a></li>
                <li><a href="../recherche/search.php" style="text-decoration:none;color:black;">RECHERCHER</a></li>
            </ul>
        </div>
        <div id="part2">
            <button id="connectBtn" class="connect" style="font-size:0.83rem;">
                <?php echo htmlspecialchars($user_data['nom'] . ' ' . $user_data['Prenom']); ?>
                <img src="../<?php echo htmlspecialchars($user_data['photo']); ?>" alt="User Photo">
            </button>
            <div class="toggle">
                <a href="../profil/profil.php">Profile</a>
                <a href="add_souvenir.php">Souvenir</a>
                <a href="logout.php">Deconnexion</a>
            </div>
        </div>
        <div id="menuIcon" onclick="toggleMenu()">&#9776;</div>
    </nav>

    <nav class="show">
        <ul>
            <li>HOME</li>
            <li>REPONSE</li>
            <li>AVIS</li>
            <li>FAQ</li>
            <li>Se connecter</li>
            <li>S'inscrire</li>
        </ul>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const connectBtn = document.getElementById('connectBtn');
            const toggleMenu = document.querySelector('.toggle');

            connectBtn.addEventListener('click', () => {
                if (toggleMenu.style.display === 'flex') {
                    toggleMenu.style.display = 'none';
                } else {
                    toggleMenu.style.display = 'flex';
                }
            });

            document.addEventListener('click', (event) => {
                if (!connectBtn.contains(event.target) && !toggleMenu.contains(event.target)) {
                    toggleMenu.style.display = 'none';
                }
            });
        });

        function toggleMenu() {
            const nav = document.querySelector('nav');
            nav.classList.toggle('expanded');
        }
    </script>
</body>
</html>