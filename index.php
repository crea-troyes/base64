<?php
// Traitement PHP
$base64 = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageUrl = trim($_POST['image_url'] ?? '');

    if (!empty($imageUrl)) {
        if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            $imageData = @file_get_contents($imageUrl);
            if ($imageData !== false) {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($imageData);
                $base64 = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
            } else {
                $error = "Impossible de récupérer l'image depuis l'URL fournie.";
            }
        } else {
            $error = "L'URL fournie n'est pas valide.";
        }
    } else {
        $error = "Veuillez entrer une URL.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Convertir une image en Base64</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Convertisseur d'image en Base64</h1>

    <form method="post" action="">
        <label for="image_url">URL de l'image :</label><br><br>
        <input type="text" name="image_url" id="image_url" value="<?= htmlspecialchars($_POST['image_url'] ?? '') ?>">
        <input type="submit" value="Convertir">
    </form>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($base64): ?>
        <h2>Image Encodée en Base64 :</h2>
        <div class="textarea-container">
            <button class="copy-btn" onclick="copyToClipboard()">Copier</button>
            <textarea id="base64text" readonly><?= $base64 ?></textarea>
        </div>
        <div id="copySuccess" class="copy-success" style="display:none;">Texte copié !</div>

        <h2>Prévisualisation :</h2>
        <img src="<?= $base64 ?>" alt="Image encodée">
    <?php endif; ?>
</div>
<script src="copy.js"></script>

<script>

</script>

</body>
</html>
