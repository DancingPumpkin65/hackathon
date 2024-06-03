<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonial HTML</title>
    
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <style>
        :root {
            --color-dark: rgb(0, 98, 155,0.01);
            --color-light: #2c3e50;
            --color-primary: #3d3d3d;
            --color-text: #2c3e50;
        }
        html {
        scroll-behavior: smooth;
        }
        .container {
            height: 40vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .board {
            max-width: 987px;
            width: 100%;
            background-color: var(--color-dark);
            text-align: center;
            border-radius: 8px;
            padding: 3rem;
            position: relative;
            box-shadow: 1px 1px 15px rgba(0,0,0,0.3);
        }

        .text-light {
            color: var(--color-light);
        }
        .pep {
            display: flex;
            align-items: center;
            justify-content: start;
            margin-bottom: 1rem;
        }
        .pep img {
            width: 40px;
            margin-right: 1rem;
        }
        .profile {
            display: flex;
            align-content: center;
            justify-content: end;
        }
        .flex {
            width: 80%;
            margin: auto;
        }
        .swiper-button-prev, .swiper-button-next {
            color: rgba(230,108,19,1);
        }
        .swiper-pagination {
            --swiper-pagination-color: rgba(230,108,19,1);
        }
        .comments {
            text-align: left;
        }
    </style>
</head>
<body>
    <h2 style="margin-left: 2rem;
            font-weight: 400;
            font-size: 4rem;
            margin-left: 10%;">Avis</h2>
    <div class="container" id="avis__">
        <div class="board">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php 
                        $sqt = 'SELECT * FROM Avis ORDER BY identifiant DESC LIMIT 6';
                        $stmt = $pdo->prepare($sqt);
                        $stmt->execute();
                        $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $listid = [];
                        foreach ($avis as $avi) {
                            $idut = $avi['identifiant']; 
                            array_push($listid, $idut);
                        }

                        if (!empty($listid)) {
                            $sqm = 'SELECT identifiant, nom, Prenom, photo FROM Laureat WHERE identifiant IN (' . implode(',', $listid) . ')';
                            $stmt = $pdo->prepare($sqm);
                            $stmt->execute();
                            $laureats = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $laureatMap = [];
                            foreach ($laureats as $laureat) {
                                $laureatMap[$laureat['identifiant']] = $laureat;
                            }

                            foreach ($avis as $avi) {
                                $identifiant = $avi['identifiant'];
                                if (isset($laureatMap[$identifiant])) {
                                    $laureat = $laureatMap[$identifiant];
                                    echo '<div class="swiper-slide">';
                                    echo '     <div class="flex">';
                                    echo '        <div class="pep">';
                                    echo '            <img src="' . $laureat['photo'] . '" alt="J.K Rowling">';
                                    echo '            <h2 class="text-light">' . $laureat['nom'] . ' ' . $laureat['Prenom'] . '</h2>';
                                    echo '        </div>';
                                    echo '        <div class="comments">' . $avi['Avis'] . '</div>';
                                    echo '        <div class="profile">';
                                    echo '            <span>' . $avi['dateA'] . '</span>';
                                    echo '        </div>';
                                    echo '    </div>';
                                    echo '</div>';
                                }
                            }
                        } else {
                            echo '<div class="comments">Pas encore d avis.</div>';
                        }
                    ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
</body>
</html>

