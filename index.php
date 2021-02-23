<?php
    $results = array();
    $has_search = false;
    $err = false;
    if(isset($_GET["search"])) {
        $search = htmlspecialchars($_GET["search"]);
        $has_search = true;
        $db_con = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db_con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        //Utiliser pour l'affichage dans la page
        $qry = "SELECT name, price_total, quantity from products WHERE name LIKE '%$search%'";
        try {
            $querry = "SELECT name, price_total, quantity from products WHERE name LIKE '%' :search '%'";
            $query_params = array( ':search' => $search );
            $tmp = $db_con->prepare($querry);
            $results = $tmp->execute($query_params);
        } catch (PDOException $exception) {
            $err = true;
        }
        $results = $tmp->fetchAll(PDO::FETCH_ASSOC);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Super Safe Shop</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="assets/script.js"></script>
</head>
<body>
    <header>
        <h1>Super Safe Shop</h1>
        <section class="search">
            <form action="index.php" method="get" autocomplete="none">
                <input type="search" autocomplete="none" id="search-inp" name="search" placeholder="Trouvez nos produits">
                <input type="submit" value="Recherche">
            </form>
        </section>
    </header>
    <main>

        <section class="results">
            <?php if ($err) : ?>
                <span class="error">Une erreur est survenue<span class="smiley">:(</span></span>
            <?php elseif ($has_search && !empty($results)): ?>
                <span class="count"><?= sizeof($results) ?> produits correspondent</span>
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                    </tr>
                    <?php foreach($results as $r): ?>
                        <tr>
                            <?php foreach($r as $val): ?>
                                <td><?= $val ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php elseif ($has_search): ?>
                <span class="warning">Aucun résultat pour votre recherche "<?= $search ?>"</span>
            <?php endif; ?>
        </section>
    </main>
    <button class="toggle-qry">SHOW QRY</button>
    <footer>
        <?php if (isset($qry)): ?>
            <span class="qry">Requête SQL : <?= $qry ?></span>
        <?php endif; ?>
    </footer>
</body>
</html>
