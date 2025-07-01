# Univ Paris CAS Proof of concept

## Comment tester cette POC ?

On nous a donné des identifiant de test avec un "service" qui est une URL inexistante.

- Modifier ses fichiers etc/hosts et ajouter une ligne `51.210.1.107 test.u-paris.fr` pour dire à son ordi que `test.u-paris.fr` va sur le serveur de développement.
- Modifier les vhosts de vader7:

  - Modifier le fichier `/etc/nginx/sites-enabled/univ-paris.conf` et ajouter mettre à jour le `root` pour pointer sur le bon dossier local

    ```
    server_name oauth2.jdeniau.dev.mapado.com accounts.jdeniau.dev.mapado.com test.u-paris.fr;
    ```

  - recharger nginx : `sudo systemctl reload nginx`

Aller sur l'url [https://autht1.app.u-paris.fr/idp/profile/cas/login?service=https://test.u-paris.fr/](https://autht1.app.u-paris.fr/idp/profile/cas/login?service=https://test.u-paris.fr/)
Se connecter avec les identifiants user.mapado. Le mot de passe se trouve dans passpack : https://app.passpack.com/passwords/detail/17469516

On doit être redirigé sur la page "test.u-paris.fr" qui doit afficher le contenu de debug:

```
Successfull Authentication!

Current dir
    /home/jdeniau/code/univ-paris-cas
Current script
    index.php
session_name():
    session_for-index_php
session_id():
    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

the user's login is mapado1.

/home/jdeniau/code/univ-paris-cas/index.php:95:
array (size=5)
  'uid' => string 'mapado1' (length=7)
  'mail' => string 'prenommapado.nommapado@etu.u-paris.fr' (length=37)
  'displayName' => string 'PrénomMapado NOMMAPADO' (length=23)
  'givenName' => string 'PrénomMapado' (length=13)
  'sn' => string 'NomMapado' (length=9)

uid: mapado1
mail: prenommapado.nommapado@etu.u-paris.fr
displayName: PrénomMapado NOMMAPADO
givenName: PrénomMapado
sn: NomMapado

phpCAS version is 1.6.1.

Logout
```
