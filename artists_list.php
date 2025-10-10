<h5>Artists list</h5>
<section class="artist-list">

<nav>
    <select onchange="location = this.value;">
        <option value="">Sort by . . .</option>
        <option value="<?php echo site_url('artistes/sortAZ'); ?>">sort A-Z</option>
        <option value="<?php echo site_url('artistes/sortZA'); ?>">sort Z-A</option>
    </select>
</nav>

<h5>Search Artists</h5>
<form action="<?php echo site_url("artistes/search")?>" method="get">
    <input type="text" name="query" placeholder="Search by artist name" required>
    <button type="submit" class="contrast">Search</button>
</form>

<h5>Artists</h5>


<section class="artist-list">
<?php
foreach($artists as $artist){
    echo "<div><article>";
    echo "<header class='short-text'>";
    echo anchor("artistes/view/{$artist->id}", "{$artist->name}");
    echo "</header>";
    echo "</article></div>";
}
?>
</section>
</body>
</html>