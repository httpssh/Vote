<!DOCTYPE html>
<html>
<head>
	<title>Vote Counting App</title>
</head>
<body>
	<h2>Vote for your favorite color</h2>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input type="radio" name="color" value="red"> Red<br>
		<input type="radio" name="color" value="green"> Green<br>
		<input type="radio" name="color" value="blue"> Blue<br>
		<input type="submit" name="submit" value="Vote">
	</form>

	<?php
		session_start();
		$db = new mysqli("localhost", "Shivam", "1", "database");

		// Check if the user has already voted
		if (isset($_SESSION["has_voted"]) && $_SESSION["has_voted"] == true) {
			echo "<p>You have already voted. Thank you for your vote!</p>";
		} 
		// Check if the user has submitted a vote
		elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["color"])) {
			$color = $_POST["color"];
			$user_id = $_SESSION["user_id"];

			// Insert the vote into the database
			$stmt = $db->prepare("INSERT INTO votes (user_id, color) VALUES (?, ?)");
			$stmt->bind_param("is", $user_id, $color);
			$stmt->execute();

			// Set a session variable to indicate that the user has voted
			$_SESSION["has_voted"] = true;

			echo "<p>Thank you for voting!</p>";
		}
	?>
</body>
</html>
