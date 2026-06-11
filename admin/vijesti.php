<?php
	#Dodaj vijesti	
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'dodaj_vijesti') {
		$_SESSION['message'] = '';
		# htmlspecialchars — Convert special characters to HTML entities
		# http://php.net/manual/en/function.htmlspecialchars.php
		$query  = "INSERT INTO news (title, description, archive)";
		$query .= " VALUES ('" . htmlspecialchars($_POST['naslov'], ENT_QUOTES) . "', 
		'" . htmlspecialchars($_POST['opis'], ENT_QUOTES) . "','" . $_POST['archive'] . "')";
		$result = @mysqli_query($MySQL, $query);
		
		$ID = mysqli_insert_id($MySQL);

		# picture
        if($_FILES['slika']['error'] == UPLOAD_ERR_OK && $_FILES['slika']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['slika']['name'], "."));
			
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['slika']['tmp_name'], "vijesti/".$_picture);

			# test if format is picture
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif' || $ext == '.avif' || $ext=='.jpeg') { 
				$_query  = "UPDATE news SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . $ID . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>Uspješno ste dodali sliku!</p>';
				$_SESSION['message_type']='success';
			} 
			else{
				$_SESSION['message'] = '<p>Odaberite ispravnu sliku (dozvoljeni formati: .jpg, .jpeg, .png, .gif, .avif).</p>';
				$_SESSION['message_type'] = 'error';
			}
        }
		$_SESSION['message'] .= '<p>Uspješno ste dodali vijest!</p>';
		$_SESSION['message_type']='success';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}

	# Kraj dodavanja vijesti

	# Uredi vijesti
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'uredi_vijesti') {
		$query  = "UPDATE news SET title='" . htmlspecialchars($_POST['naslov'], ENT_QUOTES) . "', 
		description='" . htmlspecialchars($_POST['opis'], ENT_QUOTES) . "', 
		archive='" . $_POST['archive'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
		
		# picture
        if($_FILES['slika']['error'] == UPLOAD_ERR_OK && $_FILES['slika']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['slika']['name'], "."));
            
			$_picture = (int)$_POST['edit'] . '-' . rand(1,100) . $ext;
			copy($_FILES['slika']['tmp_name'], "vijesti/".$_picture);
			
			# test if format is picture
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif' || $ext == 'avif' || $ext == 'jpeg') { 
				$_query  = "UPDATE news SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . (int)$_POST['edit'] . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>Uspješno ste dodali sliku!</p>';
				$_SESSION['message_type']='success';
			} else{
				$_SESSION['message'] = '<p>Odaberite ispravnu sliku (dozvoljeni formati: .jpg, .jpeg, .png, .gif, .avif).</p>';
				$_SESSION['message_type'] = 'error';
			}
        }
		
		$_SESSION['message'] = '<p>Uspješno ste uredili vijest</p>';
		$_SESSION['message_type']='success';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# Kraj uređivanje vijesti

	# Brisanje vijesti
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
		
		# Delete picture
        $query  = "SELECT picture FROM news";
        $query .= " WHERE id=".(int)$_GET['delete']." LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result);
        @unlink("vijesti/".$row['picture']); 
		
		# Delete news
		$query  = "DELETE FROM news";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);

		$_SESSION['message'] = '<p>Uspješno ste obrisali vijest!</p>';
		$_SESSION['message_type']='success';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# Kraj brisanja vijesti
	?>

<!DOCTYPE HTML>
<html>
    <head>
    </head>
    <body>
        <main>
		<?php
		# Pokazi vijesti info
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$query  = "SELECT * FROM news";
			$query .= " WHERE id=".$_GET['id'];
			$query .= " ORDER BY date DESC";
			$result = @mysqli_query($MySQL, $query);
			$row = @mysqli_fetch_array($result);
			print '
			<h2>Pregled vijesti</h2>
			<div class="pojedinacna-vijest">
				<img src="vijesti/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
				<h2>' . $row['title'] . '</h2>
				<p>' . $row['description'] . '</p><br>
				<time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
				<hr>
			</div>
			<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'" class="BackLink">Natrag</a></p>';
	} 
	# Dodaj vijesti 
	else if (isset($_GET['add']) && $_GET['add'] != '') {
		
		print '
		<div class="vijesti">
		<h2>Dodaj vijesti</h2>
		<form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="dodaj_vijesti">
			
			<label for="naslov">Naslov *</label><br>
			<input type="text" id="naslov" name="naslov" placeholder="Naslov vijesti..." required><br>

			<label for="opis">Opis*</label><br>
			<textarea id="opis" name="opis" placeholder="Opis vijesti..." required></textarea><br>
				
			<label for="slika">Slika</label><br>
			<input type="file" id="slika" name="slika"><br>
						
			<label for="archive">Archive:</label><br>
            <input type="radio" name="archive" value="Y"> YES &nbsp;&nbsp;
			<input type="radio" name="archive" value="N" checked> NO
			
			<hr>
			
			<input type="submit" value="Pošalji">
		</form>
		</div>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'" class="BackLink">Natrag</a></p>';
	}
	# Uredi vijesti
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		$checked_archive = false;

		print '
		<div class="vijesti">
		<h2>Uredi vijesti</h2>
		<form action="" id="news_form_edit" name="news_form_edit" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="uredi_vijesti">
			<input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">
			
			<label for="naslov">Naslov *</label><br>
			<input type="text" id="naslov" name="naslov" value="' . $row['title'] . '" placeholder="Naslov vijesti..." required><br>

			<label for="opis">Opis *</label><br>
			<textarea id="opis" name="opis" placeholder="Opis vijesti..." required>' . $row['description'] . '</textarea><br>
				
			<label for="slika">Slika</label><br>
			<input type="file" id="slika" name="slika"><br>
						
			<label for="archive">Archive:</label><br />
            <input type="radio" name="archive" value="Y"'; if($row['archive'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> YES &nbsp;&nbsp;
			<input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NO
			
			<hr>
			
			<input type="submit" value="Pošalji">
		</form>
		</div>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'" class="BackLink">Natrag</a></p>';
	}
		else {
		print '
		<h2 style="margin:0.5em;">Vijesti</h2>
		<a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;add=true" class="AddLink">Dodaj vijest</a>
		<div class="vijesti">
			<table>
				<thead>
					<tr>
						<th width="16"></th>
						<th width="16"></th>
						<th width="16"></th>
						<th>Naslov</th>
						<th>Opis</th>
						<th>Datum</th>
						<th width="16">Status</th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM news";
				$query .= " ORDER BY date DESC";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td class="actions"><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="user"></a></td>
						<td class="actions"><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="uredi"></a></td>
						<td class="actions"><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="obriši"></a></td>
						<td data-label="naslov"><strong>' . $row['title'] . '</strong></td>
						<td data-label="opis">';
						if(strlen($row['description']) > 160) {
                            echo substr(strip_tags($row['description']), 0, 160).'...';
                        } else {
                            echo strip_tags($row['description']);
                        }
						print '
						</td>
						<td data-label="datum">' . pickerDateToMysql($row['date']) . '</td>
						<td data-label="status">';
							if ($row['archive'] == 'Y') { print '<img src="img/inactive.png" alt="" title="" />'; }
                            else if ($row['archive'] == 'N') { print '<img src="img/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
			
		</div>';
	}
	
	
	# Close MySQL connection
	@mysqli_close($MySQL);
	?>
        </main>
    </body>

	<script>
    const opis = document.getElementById('opis');
    
    if (opis) {
        // Kreiraj element za brojač
        const brojac = document.createElement('small');
        brojac.id = 'brojar';
        brojac.style.color = '#888';
        opis.parentNode.insertBefore(brojac, opis.nextSibling);

        const maxZnakova = 1500;

        function osvjezibrojac() {
            const preostalo = maxZnakova - opis.value.length;
            brojac.textContent = preostalo + ' znakova preostalo';

            if (preostalo < 100) {
                brojac.style.color = 'orange';
            }
            if (preostalo < 0) {
                brojac.style.color = 'red';
                brojac.textContent = Math.abs(preostalo) + ' znakova previše!';
            }
            if (preostalo >= 100) {
                brojac.style.color = '#888';
            }
        }

        // Pokreni odmah (za edit formu gdje već postoji tekst)
        osvjezibrojac();

        opis.addEventListener('input', osvjezibrojac);
    }
</script>
</html>