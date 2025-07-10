# Univ Paris CAS Proof of concept

## Comment tester cette POC ?

On nous a donné des identifiant de test avec un "service" qui est une URL inexistante.

- Modifier les vhosts de vader7:

  - Modifier le fichier `/etc/nginx/sites-enabled/univ-paris.conf` et ajouter mettre à jour le `root` pour pointer sur le bon dossier local

    ```
    server_name oauth2.cas.dev.mapado.com;
    root /home/jdeniau/code/univ-paris-cas; # modifier cette ligne
    ```

  - recharger nginx : `sudo systemctl reload nginx`

Aller sur l'url [https://autht1.app.u-paris.fr/idp/profile/cas/login?service=https://oauth2.cas.dev.mapado.com/](https://autht1.app.u-paris.fr/idp/profile/cas/login?service=https://oauth2.cas.dev.mapado.com/)
Se connecter avec les identifiants user.mapado. Le mot de passe se trouve dans passpack : https://app.passpack.com/passwords/detail/17469516

On doit être redirigé sur la page "oauth2.cas.dev.mapado.com" qui doit afficher le contenu de debug:

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
  'eduPersonPrimaryAffiliation' => string 'student' (length=7)
  'supannCodeINE' => string '123456789AB' (length=11)
  'mail' => string 'prenommapado.nommapado@etu.u-paris.fr' (length=37)
  'displayName' => string 'PrénomMapado NOMMAPADO' (length=23)
  'givenName' => string 'PrénomMapado' (length=13)
  'sn' => string 'NomMapado' (length=9)

uid: mapado1
eduPersonPrimaryAffiliation: student
supannCodeINE: 123456789AB
mail: prenommapado.nommapado@etu.u-paris.fr
displayName: PrénomMapado NOMMAPADO
givenName: PrénomMapado
sn: NomMapado

phpCAS version is 1.6.1.

Logout
```
