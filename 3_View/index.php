<?php require_once '../2_Controller/searchController.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Home</title>
</head>
<style>
    body {
    background-color: #f9f9f9;
    color: #333;
    font-family: Arial, sans-serif;
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

header {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: stretch;
    gap: 10px;
    background-color: #ffffff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

form {
    display: flex;
    gap: 10px;
}

form input[type="text"],
form input[type="number"] {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fff;
}

form button {
    background-color: #e0e0e0;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
}

.content_type {
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: stretch;
}

.content_type > div {
    background-color: #f2f2f2;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.2s;
}

.content_type > div:hover {
    background-color: #e6e6e6;
}

main {
    width: 100%;
    margin-top: 20px;
}

section {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

footer {
    margin-top: 20px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
}

.footer_container_before,
.footer_container_next {
    flex: 1;
    text-align: center;
}

.footer_container_before .next,
.footer_container_next .next {
    background-color: #eaeaea;
    padding: 10px;
    border-radius: 6px;
    cursor: pointer;
}

.content_type > div > p{
    margin: 0;
}

video{
    width: 100%;
}

.footer_container_before .next:hover,
.footer_container_next .next:hover {
    background-color: #dcdcdc;
}
</style>
<body>
    <header>
        <form method="POST" action="">
            <input type="text" required autocomplete="off" placeholder="Recherche Web" name="search" id="search">
            <input type="text" style="display: none" value="website" name="content_type" id="content_type">
            <input type="number" min="0" max="150" style="display: none" value="0" name="counter_start" id="counter_start">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <div class="content_type" style="display: flex; gap: 10px;">
            <div class="website">
                <p><i class="fa-solid fa-magnifying-glass"></i> Tous</p>
            </div>
            <div class="picture">
                <p><i class="fa-solid fa-image"></i> Images</p>
            </div>
            <div class="clip">
                <p><i class="fa-solid fa-play"></i> Vidéos</p>
            </div>
        </div>
    </header>
    <main>
        <p>Nombres de résultat: <?php echo $dataSize ?? '' ?></p>
        <section>
            <?= isset($contentResult, $dataSize) ? ($dataSize === 0 ? 'Aucun résultat...' : $contentResult) : 'Veuillez effectuer votre recherche...' ?>
            <?php echo isset($counterStart, $dataSize) ? ($counterStart >= $dataSize ? 'Aucun résultat pour cette page...' : '') : '' ?>
        </section>
    </main>
    <footer style="display: flex; gap: 20px">
        <div style="display: <?php echo ($counterStart <= 0) ? 'none' : 'block' ?>;" class="footer_container_before">
            <div class="next"><p style="margin:0;"><i class="fa-solid fa-chevron-left"></i> Avant</p></div>
        </div>
        <div style="display: <?php echo ($counterStart >= $dataSize) ? 'none' : 'block' ?>;" class="footer_container_next">
            <div class="next"><p style="margin:0;">Suivant <i class="fa-solid fa-chevron-right"></i></p></div>
        </div>
    </footer>
</body>
<script src="script.js"></script>
</html>