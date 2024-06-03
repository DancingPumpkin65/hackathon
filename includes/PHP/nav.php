<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Example</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            overflow-x: hidden;
        }
        li a{
            text-decoration: none;
            color: black;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: color 0.3s;
        }
        li a:hover{
            color: #047de7;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 0.625rem 1.25rem; 
            padding-right: 1.8rem;
            color: black;
            position: fixed; 
            z-index: 9999;
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
            gap: 1.25rem; 
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
            padding: 0.3125rem 0; 
            width: 9rem;
            border-radius: 0.3125rem;
            border: 1px solid rgba(128, 128, 128, 0.212);
            transition: background-color 0.3s, color 0.3s;
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
            width: 9rem;
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

        .hide {
            display: flex;
        }

        .show {
            display: none;
        }

        nav.expanded.hide {
            display: none;
        }

        nav.expanded.show {
            display: flex;
        }
        .closeIcon {
            font-size: 2.2rem;
            color: #00529B;
            cursor: pointer;
            right: 1.25rem; 
            font-weight: 400;
            position: absolute;
        }
        .show ul {
            list-style: none;
        }
        .ng {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: start;
            margin:0 40%;
        }
        .df {
            display: flex;
            flex-direction: column;
            align-items: start;
            text-align: start;
            margin-left: 1rem;
            cursor: none;
        }
    </style>
</head>
<body>
    <nav class="hide" id="firstNav">
        <div id="part1">
            <a href="index.php"><img src="images/ofppt.png" alt="Logo"></a>
            <ul>
                <li class="active"><a href="#hero">HOME</a></li>
                <li><a href="#offers__">OFFRES</a></li>
                <li><a href="#avis__">AVIS</a></li>
                <li><a href="#FAQ__">FAQ</a></li>
            </ul>
        </div>
        <div id="part2">
            <button id="connectBtn" class="connect">Se connecter</button>
            <div class="toggle">
                <a href="Login/Laureat/login.php">Lauréat</a>
                <a href="Login/Gestionnaire/login.php">Gestionnaire</a>
            </div>
            <button class="insc" onclick="window.location.href='Signup/signup.php'">S'inscrire</button>
        </div>
        <div id="menuIcon" onclick="toggleMenu()">&#9776;</div>
    </nav>
    <nav class="show" id="secondNav">
        <div class="ng">
            <ul>
                <li class="active"><a href="#hero">HOME</a></li>
                <li><a href="#offers__">OFFRES</a></li>
                <li><a href="#avis__">AVIS</a></li>
                <li><a href="#FAQ__">FAQ</a></li>
                <li style="cursor:default;font-weight:600;">Se connecter
                    <ul class="df">
                        <li><a href="Login/Laureat/login.php" style="font-weight:400;">Lauréat</a></li>
                        <li><a href="Login/Gestionnaire/login.php" style="font-weight:400;">Gestionnaire</a></li>
                    </ul>
                </li>
                <li><a href="Signup/signup.php">S'inscrire</a></li>
            </ul>
        </div>
        <div class="closeIcon" onclick="toggleMenu()">&times;</div>
    </nav>

    <script>
        function toggleMenu() {
            const firstNav = document.getElementById('firstNav');
            const secondNav = document.getElementById('secondNav');
            firstNav.classList.toggle('expanded');
            secondNav.classList.toggle('expanded');
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            const connectBtn = document.getElementById('connectBtn');
            const toggleMenuElement = document.querySelector('.toggle');

            connectBtn.addEventListener('click', () => {
                if (toggleMenuElement.style.display === 'flex') {
                    toggleMenuElement.style.display = 'none';
                } else {
                    toggleMenuElement.style.display = 'flex';
                }
            });

            document.addEventListener('click', (event) => {
                if (!connectBtn.contains(event.target) && !toggleMenuElement.contains(event.target)) {
                    toggleMenuElement.style.display = 'none';
                }
            });
        });
    </script>
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</body>
</html>