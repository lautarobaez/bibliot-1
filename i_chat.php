<?php
 include("libreria/config.php"); // Solo este archivo contiene la conexión include("config.php");

echo '		
<script>
	function ajax_chat(){
		var req = new XMLHttpRequest();
		req.onreadystatechange = function(){
			if(req.readyState == 4 && req.status == 200){
				document.getElementById("chat_box").innerHTML = req.responseText;
			}
		}
		req.open("GET", "chat.php", true);
		req.send();
	}
	setInterval(function(){ajax_chat()}, 1000);
</script>
';	

include("menu_bs.php");

// Enviar mensaje al presionar el botón
if (isset($_POST['send'])) {
	if (isset($_SESSION['username'])) {
		$name = $_SESSION['username'];
		$message = $_POST['msg'];
		
		if (!empty(trim($message))) {
			$query = "INSERT INTO chat (name, msg) VALUES (?, ?)";
			$stmt = $con->prepare($query);
			$stmt->bind_param("ss", $name, $message);
			$stmt->execute();
			$stmt->close();
		}
	}
}
?>

<div onload="ajax_chat();">
	<div id="container">
		<div class="row">
			<div class="col-sm-8">
				<div id="chat_box"></div>
			</div>
		</div>

		<div class="row" id="envio">
			<div class="col-sm-8">
				<form method="post" action="i_chat.php">
					<input type="hidden" name="name" value="Alguien">
					<div class="form-group">
						<textarea class="form-control" name="msg" placeholder="Escribí un mensaje..."></textarea>	
					</div>	
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<input class="btn btn-primary" name="send" type="submit" value="Enviar" style="position: absolute;top: 20px;">	
				</div>	
			</div>
				</form>
		</div>
	</div>
</div>
</html>
