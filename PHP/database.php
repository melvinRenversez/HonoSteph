<?php
$host = "91.168.244.154";   // 🔹 IP du serveur MySQL
$port = "51336";             // 🔹 Port MySQL (par défaut : 3306)
$dbname = "honoStephDB";
$username = "honoSteph";
$password = "honoSteph_MDP_123";

try {
   $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",$username, $password);

   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
   // echo "Connexion réussie !";

} catch (PDOException $e) {
   die("Erreur de connexion : " . $e->getMessage());
}
?>
