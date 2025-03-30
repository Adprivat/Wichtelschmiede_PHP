<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wichtelschmiede Hofgeismar</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="/">Wichtelschmiede Hofgeismar</a>
            <div id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/materials.php">Materialien</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/casting_powders.php">Gießpulver</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/molds.php">Gießformen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/workpieces.php">Werkstücke</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>
        
        <!-- Hier wird der Inhalt der Seite eingefügt -->
        <?php echo $content ?? ''; ?>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>
