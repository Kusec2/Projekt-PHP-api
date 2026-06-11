<!DOCTYPE HTML>
<html>
    <head>
    </head>
    <body>
        <main>

<?php

	if (isset($action) && $action > 0) {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=" . $_GET['action'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
			echo '
			<div class="pojedinacna-vijest">
				<img src="vijesti/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
				<h2>' . $row['title'] . '</h2>
				<p>'  . $row['description'] . ' </p>
				<time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
				<hr>
			</div>';
    } else {
		print '<h1>Vijesti</h1>';
		$query  = "SELECT * FROM news";
		$query .= " WHERE archive='N'";
		$query .= " ORDER BY date DESC";
		$result = @mysqli_query($MySQL, $query);
		while($row = @mysqli_fetch_array($result)) {
			echo '
			<div class="vijesti">
				<img src="vijesti/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . ' id="naslovna-vijest"">
				<h2>' . $row['title'] . '</h2>';
				if(strlen($row['description']) > 300) {
					echo substr(strip_tags($row['description']), 0, 300).' <a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">Više...</a>';
				} else {
					echo strip_tags($row['description']);
				}
				print ' <br>
				<time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
				<hr>
			</div>';
		}
	} ?>
            
    </main>
       
    </body>
</html>