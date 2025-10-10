<nav>
    <select onchange="location = this.value;">
        <option value="">Sort by . . .</option>
        <option value="<?php echo site_url('Songs/sortAZ/'); ?>">sort A-Z</option>
        <option value="<?php echo site_url('Songs/sortZA/'); ?>">sort Z-A</option>
        <?php foreach ($genres as $genre) {
            echo '<option value="' . site_url('songs/sortGenre/' . $genre->id) . '">sort ' . $genre->name . '</option>';
        } ?>
    </select>
</nav>

<h5>Search Songs</h5>
<form action="<?php echo site_url("Songs/search/")?>" method="get">
    <input type="text" name="query" placeholder="Search by song name" required>
    <button type="submit" class="contrast">Search</button>
</form>

<h5>Songs</h5>


<section class="albums-details">
    <div class="albums-content">
        <div class="albums-songs">
            <?php
            // Afficher les noms des chansons sous forme de tableau
            echo "<table>";
            echo "<tr>";
            echo "<th><h6>Titre</h6></th>";
            echo "<th><h6>Artiste</h6></th>";
            echo "<th><h6>Album</h6></th>";
            echo "<th><h6>Durée</h6></th>";
            echo "<th></th>"; // Ajout de la colonne pour la petite croix
            echo "</tr>";

            foreach ($songs as $song) {
                $artistName = $song->artistname;
                $duration = isset($song->duration) ? convertirSecondesEnMinutes($song->duration) : '';

                echo "<tr>";
                echo "<td>{$song->songname}</td>";
                echo "<td>{$artistName}</td>";
                echo "<td>{$song->albumName}</td>";
                echo "<td>{$duration}</td>";
                echo "<td>" . anchor("playlist/addSongPlaylistView/{$song->songId}", "&plus;", ['class' => 'add-link']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";

            function convertirSecondesEnMinutes($secondes) {
                $minutes = floor($secondes / 60);
                $secondesRestantes = $secondes % 60;
                return sprintf('%02d:%02d', $minutes, $secondesRestantes);
            }
            ?>
        </div>
    </div>
<style>
    .add-link {
        color: green;
        text-decoration: none;
        font-size: 1.5em;
        margin-left: 10px;
    }

    .add-link:hover {
        color: lightgreen;
    }
</style>
</section>
