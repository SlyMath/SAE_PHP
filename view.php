<section class="albums-details">
    <div class="albums-content">
        <div class="albums-image">
            <?php
            echo '<img src="data:image/jpeg;base64,' . base64_encode($playlist->jpeg) . '" style="width: 300px; height: 300px;" />';
            ?>
            <br>
            <br>
            <h4><?php echo  $playlist->nom . ' ' . anchor("playlist/duplicatePlaylist/{$playlist->id}", "&plus; Duplicate", ['class' => 'add-link', 'style' => 'font-size: 1em;']); ?></h4>
        </div>
        <div class="albums-songs">
            <?php
            // Afficher les noms des chansons sous forme de tableau
            echo "<table>";
            echo "<tr>";
            echo "<th><h6>Titre</h6></th>";
            echo "<th><h6>Artiste</h6></th>";
            echo "<th><h6>Durée</h6></th>";
            echo '<th></th>';
            echo "</tr>";

            foreach ($songs as $song) {
                $artistName = $song->artistName;
                $duration = isset($song->track_duration) ? convertirSecondesEnMinutes($song->track_duration) : '';

                echo "<tr>";
                echo "<td>{$song->songName}</td>";
                echo "<td>{$artistName}</td>";
                echo "<td>{$duration}</td>";
                ?>
                <td>
                <a href="<?php echo site_url("playlist/deleteSongPlaylist/{$playlist->id}/{$song->songId}"); ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this song from your playlist ?');">&times;</a>
                </td>
                <?php
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
    .delete-link {
        color: red;
        text-decoration: none;
        font-size: 1.5em;
        margin-left: 10px;
    }

    .delete-link:hover {
        color: darkred;
    }

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
