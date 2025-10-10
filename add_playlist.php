<body>
    <div class="container">
        <h2>Add Playlist</h2>
        <ul class="menu">
            <li><?=anchor('playlist','Go Back');?></li>
        </ul>
        <?php if(isset($error) && !empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="<?php echo site_url('playlist/addNewPlaylist'); ?>" method="post" enctype="multipart/form-data">
            <label for="playlist_name">Playlist name:</label>
            <input type="text" id="Playlist_name" name="Playlist_name">
            <label for="playlist_image">Playlist image (JPG only):</label>
            <input type="file" id="Playlist_image" name="Playlist_image" accept=".jpg, .jpeg">
            <input type="submit" value="Add">
        </form>
    </div>

    <?php
    // Vérifier si un fichier a été téléchargé
    if(!isset($_FILES['playlist_image']) || $_FILES['playlist_image']['error'] == UPLOAD_ERR_NO_FILE) {
        // Chemin de l'image par défaut
        $defaultImage = 'assets/images/default_cover.jpg';
        ?>
    <?php } ?>
</body>
</html>
