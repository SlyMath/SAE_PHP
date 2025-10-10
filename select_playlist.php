<?php if (!$this->Model_user->is_logged_in()) : ?>
    <h1><?= anchor('login', 'Please login to access your playlists'); ?></h1>
<?php else : ?>
    <h5>playlsits</h5>
<?php endif; ?>

<section class="list">
    <?php foreach($playlists as $playlist): ?>
        <div>
            <article>
                <header class='short-name'>
                    <?php echo anchor("playlist/view/{$playlist->id}", "{$playlist->nom}"); ?>
                </header>
                <header class='short-text'>
                    <?php echo anchor("playlist/addSongFromAlbumToPlaylist/{$albumId}/{$playlist->id}/{$songId}", "&plus;", ['class' => 'add-link']); ?>
                </header>
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
