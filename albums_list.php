<h5>Albums list</h5>

<nav>
    <select onchange="location = this.value;">
        <option value="">Sort by . . .</option>
        <option value="<?php echo site_url('albums/sortAZ'); ?>">sort A-Z</option>
        <option value="<?php echo site_url('albums/sortZA'); ?>">sort Z-A</option>
        <option value="<?php echo site_url('albums/sortNewest'); ?>">sort Newest</option>
        <option value="<?php echo site_url('albums/sortOldest'); ?>">sort Oldest</option>
        <?php foreach ($genres as $genre) {
            echo '<option value="' . site_url('albums/sortGenre/' . $genre->id) . '">sort ' . $genre->name . '</option>';
        } ?>
    </select>
</nav>

<h5>Search Albums</h5>
<form action="<?php echo site_url("albums/search")?>" method="get">
    <input type="text" name="query" placeholder="Search by album name" required>
    <button type="submit" class="contrast">Search</button>
</form>

<h5>Albums</h5>

<section class="list">
<?php
foreach($albums as $album){
	echo "<div><article>";
	echo "<header class='short-text'>";
	echo anchor("albums/view/{$album->id}","{$album->name}");
	echo "</header>";
	echo '<img src="data:image/jpeg;base64,'.base64_encode($album->jpeg).'" />';
	echo "<footer class='short-text'>{$album->year} - {$album->artistName}</footer>
	  </article></div>";
}
?>
</section>
