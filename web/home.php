<?php
    require_once('./web/header.php');
?>
<div class="container center">
    <form action="index.php?action=overlay" method="post" enctype="multipart/form-data">
        <h2>
            First, upload an image.
            <br />
            (Supports PNG, JPG / JPEG, GIF)
        </h2>

        <input type="file" name="image" id="image">

        <br />

        <h2>
            Then, choose a flag
        </h2>

        <select name="flag">
            <option value="france">France</option>
            <option value="netherlands">Netherlands</option>
            <option value="germany">Germany</option>
            <option value="japan">Japan</option>
            <option value="england">England</option>
            <option value="scotland">Scotland</option>
            <option value="canada">Canada</option>
        </select>

        <br /><br />

        <input type="submit" value="Overlay Image" name="submit">
    </form>
    <br /><br /><br />
    Please note, some flags are "buggy" and will have additional overlaying / missing pixels.
    <br />
    I will fix this in the future, just working on getting more flags up first as this is a pretty fun project.
</div>