<nav>
    <select onchange="location = this.value;">
        <option value="">Trier par</option>
        <option value="<?php echo site_url('playlist/sortAZ'); ?>">De A-Z</option>
        <option value="<?php echo site_url('playlist/sortZA'); ?>">De Z-A</option>
    </select>
</nav>

<h5>Search Playlist</h5>
<form action="<?php echo site_url("playlist/search")?>" method="get">
    <input type="text" name="query" placeholder="Search by playlist name" required>
    <button type="submit" class="contrast">Search</button>
</form>

<nav>
    <a href="<?php echo site_url('playlist/addPlaylist'); ?>">Add playlist</a>
</nav>

<h5>playlsits</h5>

<section class="list">
    <?php foreach($playlists as $playlist): ?>
        <div>
            <article>
                <header class='short-name'>
                    <?php echo anchor("playlist/view/{$playlist->id}", "{$playlist->nom}"); ?> 
                    <a href="<?php echo site_url("playlist/deletePlaylist/{$playlist->id}"); ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this playlist ?');">&times;</a>
                </header>
                <header>
                    <nav>
                        <select onchange="location = this.value;">
                        <option value="">Generate songs . . .</option>
                        <option value="<?php echo site_url("playlist/generatePlaylist/{$playlist->id}/10"); ?>">generate 10 random songs</option>
                            <?php foreach ($genres as $genre) {
                                echo '<option value="' . site_url("playlist/generatePlaylistByGenre/{$genre->id}/{$playlist->id}/10") . '">genreate 10 ' . $genre->name . '</option>';
                            } ?>
                        </select>
                    </nav>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($playlist->jpeg); ?>" />
            </article>
        </div>
    <?php endforeach; ?>
</section>

<style>
    .short-name,
    .short-text {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

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
