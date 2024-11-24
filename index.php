<?php
// Inclure Faker (assure-toi d'avoir extrait Faker dans le dossier "faker")
require_once 'faker/src/autoload.php'; // Chemin vers Faker

// Connexion à la base de données
$host = 'localhost'; // Nom de l'hôte
$dbname = 'nom_de_votre_base'; // Remplace par le nom de ta base de données
$username = 'root'; // Par défaut sur WAMP
$password = ''; // Par défaut sur WAMP

try {
    // Établir la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base réussie !<br>";

    // Initialiser Faker
    $faker = Faker\Factory::create();

    // Exemple : Insertion de données aléatoires dans une table "Users"
    for ($i = 0; $i < 10; $i++) { // Générer 10 utilisateurs
        $nom = $faker->lastName;
        $prenom = $faker->firstName;
        $email = $faker->unique()->email;
        $date_naissance = $faker->date('Y-m-d');

        // Requête SQL d'insertion
        $sql = "INSERT INTO Users (nom, prenom, email, date_naissance) 
                VALUES (:nom, :prenom, :email, :date_naissance)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'date_naissance' => $date_naissance,
        ]);

        echo "Utilisateur ajouté : $nom $prenom ($email)<br>";
    }

    echo "Insertion des données terminée !";

} catch (PDOException $e) {
    // En cas d'erreur, afficher le message
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
