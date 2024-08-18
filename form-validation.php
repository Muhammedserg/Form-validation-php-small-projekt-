<?php
    // Serverseitige Validierung
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $gender = $_POST["gender"];
        $country = $_POST["country"];
        $agreement = isset($_POST["agreement"]);

        $errors = [];

        // Nutzername validieren
        if (strlen($username) < 4 || strlen($username) > 16 || preg_match('/\s/', $username)) {
            $errors["username"] = "Nutzername muss 4-16 Zeichen lang sein und keine Leerzeichen enthalten";
        }

        // E-Mail Adresse validieren
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Ungültige E-Mail Adresse";
        }

        // Passwort validieren
        if (strlen($password) < 8 ||
            !preg_match("/[a-z]/", $password) ||
            !preg_match("/[A-Z]/", $password) ||
            !preg_match("/\d/", $password) ||
            !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $password) ||
            preg_match('/\s/', $password)) {
            $errors["password"] = "Passwort muss mindestens 8 Zeichen lang sein und mindestens einen Kleinbuchstaben, einen Großbuchstaben, eine Zahl und ein Sonderzeichen enthalten";
        }

        // Geschlecht validieren
        if (empty($gender)) {
            $errors["gender"] = "Geschlecht muss ausgewählt werden";
        } else if ($gender !== "male" && $gender !== "female") {
            $errors["gender"] = "Ungültiges Geschlecht";
        }

        // Land validieren
        $valid_countries = ["germany", "france", "Ägypten", "Sweden"];
        if (empty($country) || !in_array($country, $valid_countries)) {
            $errors["country"] = "Land muss ausgewählt werden";
        }

        // AGBs akzeptieren
        if (!$agreement) {
            $errors["agreement"] = "AGBs müssen akzeptiert werden";
        }

        // Fehlermeldungen ausgeben
        if (!empty($errors)) {
            echo "<div style='color: red;'>Folgende Fehler sind aufgetreten:<br>";
            foreach ($errors as $error) {
                echo "- $error<br>";
            }
            echo "</div>";
        } else {
            echo "<div style='color: green;'>Registrierung erfolgreich!</div>";
            // Hier könnte die Weiterleitung zur nächsten Seite erfolgen
        }
    }
    ?>