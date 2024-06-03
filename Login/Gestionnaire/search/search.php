<?php
session_start();
if (isset($_SESSION['isUserLoggedIn']) && $_SESSION['userType'] === 'gestionnaire') {
    include('header_search.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher</title>
</head>
<body>
<section class="home">
        <div class="text">Rechercher</div>
        <div class="main_gestioner mt-2">
        <form id="searchForm" style="margin-left: 5%;">
                <input type="text" id="search" name="search" placeholder="Enter your search term">
                <label for="field">trouver par:</label>
                <select id="field" name="field">
                    <option value="Identifiant">Identifiant</option>
                    <option value="nom">Nom</option>
                    <option value="Prenom">Prénom</option>
                    <option value="email">Email</option>
                    <option value="Tel">Tel</option>
                    <option value="promotion">Promotion</option>
                    <option value="Filiere">Filière</option>
                    <option value="Etablissement">Etablissement</option>
                    <option value="Fonction">Fonction</option>
                    <option value="Employeur">Employeur</option>
                </select>
            </form>
            <div id="searchResults"></div>
            <button onclick="saveAsExcel()" style="margin-left: 5%">Save as Excel</button>
            </div>
        </section>
        

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <script>
        function search() {
            var searchValue = document.getElementById('search').value;
            var field = document.getElementById('field').value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("searchResults").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "search2.php?search=" + searchValue + "&field=" + field, true);
            xhttp.send();
        }

        window.onload = function() {
            search();
        };

        document.getElementById('search').addEventListener('input', function() {
            search();
        });

        document.getElementById('field').addEventListener('change', function() {
            search();
        });

        function saveAsExcel() {
            var table = document.querySelector('table');
            if (!table) {
                alert("No table found. Please ensure that search results are loaded.");
                return;
            }
            
            var tableCopy = table.cloneNode(true);

            var actionCells = tableCopy.querySelectorAll('td:last-child, th:last-child');
            actionCells.forEach(function(cell) {
                cell.parentNode.removeChild(cell);
            });

            var wb = XLSX.utils.table_to_book(tableCopy, {sheet: "Sheet1"});
            XLSX.writeFile(wb, 'search_results.xlsx');
        }
    </script>
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
           
        }

        .main_gestioner {
            padding: 5rem 2rem ;
            padding-top: 5rem;
            width: 100%;
            padding-left: 1rem
        }
    </style>