
<?php
include "config.php";
echo "ferme la";
$password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
echo "ferme la2";

$req = $db->prepare('SELECT id FROM account WHERE username = :username AND password = :password');
echo "ferme la3";
$req->execute(array(
    'pseudo' => $_POST['username'],
    'pass' => $password_hash));

echo "ferme la4";


echo "<p>tg</p>";
if (!$resultat)
{
    echo '<p>Mauvais identifiant ou mot de passe !</p>';
}
else
{
    echo 'A la bien zincou';
}

$db->close();
?>
