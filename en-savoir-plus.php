<?php
require_once('includes/form_secure.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/components/head.php'); ?>
<body>
<?php include('includes/components/navbar.php'); ?>

<div class="container">
    <h1 class="mt-4">Pourquoi notre formulaire est bien sécurisé</h1>
    <p>Notre formulaire d'inscription et de connexion utilise plusieurs méthodes pour garantir la sécurité de vos données. Voici un aperçu de ce qui rend notre système sûr :</p>
    
    <h2>1. Validation des Entrées</h2>
    <p>Avant d'accepter les informations soumises par l'utilisateur, nous effectuons une validation rigoureuse des données.</p>
    <ul>
        <li>Les champs tels que l'adresse e-mail sont validés pour s'assurer qu'ils respectent le format standard d'une adresse e-mail.</li>
        <li>Les mots de passe sont vérifiés pour garantir qu'ils répondent à des critères de sécurité stricts, tels qu'une longueur minimale de 13 caractères et la présence de caractères spéciaux et de majuscules.</li>
    </ul>

    <h2>2. Protection contre les Injections SQL</h2>
    <p>Nous utilisons des requêtes préparées et des paramètres liés pour interagir avec la base de données. Cela protège notre application contre les attaques par injection SQL, où un attaquant pourrait tenter d'injecter des commandes malveillantes dans nos requêtes.</p>
    <p>Par exemple, dans la fonction <code>awaitRegisterForm</code>, nous utilisons des requêtes préparées pour rechercher si un e-mail est déjà utilisé, ce qui empêche l'exécution de requêtes malicieuses.</p>

    <h2>3. Hachage des Mots de Passe</h2>
    <p>Les mots de passe sont hachés avant d'être stockés dans la base de données, ce qui signifie que même si un attaquant accédait à la base de données, les mots de passe restent illisibles.</p>
    <p>Nous utilisons la fonction <code>password_hash</code> de PHP, qui applique un algorithme de hachage sécurisé à chaque mot de passe, rendant les données difficiles à compromettre.</p>

    <h2>4. Protection contre les Attaques CSRF (Cross-Site Request Forgery)</h2>
    <p>Bien que nous n'ayons pas vu de code spécifique ici pour la protection CSRF, il est important de souligner que dans une configuration plus avancée, nous pourrions ajouter des jetons CSRF pour protéger nos formulaires des attaques malveillantes provenant d'autres sites.</p>

    <h2>5. Sécurisation des Sessions</h2>
    <p>Les sessions sont sécurisées avec des identifiants uniques, et nous veillons à ce que les utilisateurs soient authentifiés avant d'accéder à des pages sensibles. Par exemple, sur la page de tableau de bord, nous vérifions si l'utilisateur est authentifié avant de lui permettre l'accès.</p>
    <p>De plus, une fois la déconnexion effectuée, nous supprimons toutes les variables de session sensibles pour empêcher toute tentative d'exploitation.</p>

    <h2>6. Messages d'Erreur Securisés</h2>
    <p>Nous veillons à ne pas exposer d'informations sensibles dans les messages d'erreur, afin que les attaquants ne puissent pas obtenir d'indications sur la structure interne de notre base de données ou de notre code.</p>
    <p>Si une erreur se produit, l'utilisateur est simplement averti qu'un problème est survenu, sans détails techniques spécifiques.</p>

    <h2>Conclusion</h2>
    <p class="mb-4">En résumé, nous avons mis en place plusieurs couches de sécurité dans notre formulaire d'inscription et de connexion pour garantir la protection de vos données. De la validation des entrées à la gestion sécurisée des sessions, chaque étape vise à minimiser les risques pour vous et vos informations personnelles.</p>

</div>

<?php include('includes/components/footer.php'); ?>
</body>
</html>
