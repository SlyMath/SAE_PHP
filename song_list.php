<h5>Songs list</h5>
<section class="song-list">
<?php
foreach($songs as $song){
    echo "<div><article>";
    echo "<header class='short-text'>";
    echo anchor("songs/view/{$song->id}", "{$song->title}");
    echo "</header>";
    echo "<footer class='short-text'>{$song->artistName} - {$song->albumName}</footer>";
    echo "</article></div>";
}
?>
</section>
