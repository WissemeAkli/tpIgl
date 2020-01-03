# TP-IGL Backend 

## Lancer l'application Localement : 

### Exigences 
| Exigence                                 | Version |
| ------------------------------------------- | ------- |
| [PHP](https://www.php.net)                | `7.2+`  |
| [Composer](https://getcomposer.org) | `1.9+`  |
| [Git](https://git-scm.com/downloads) | `2.0+`  |

Exécutez les commandes suivantes pour vérifier les versions installées actuelles:

```bash
php --version
git --version
composer --version
```
1. Cloner le repository :

```bash
git clone https://github.com/WissemeAkli/tpIgl
```

2. Installer les dépendances nécessaires :

```bash
composer install
```

3. Créez votre fichier `.env` à partir de` .env.example` et générez une clé d'application (n'oubliez pas de le configurer avec la base de données):

```bash
cp .env .env.example
php artisan key:generate  
```

4. Migrer la base de données 
```bash
php artisan migrate 
```

5. Enfin, exécuter le serveur :

```bash
php artisan serve
```

6. Accéder à l'application via : `http://127.0.0.1:8000`

## Lancer l'application en utilisant Docker : 

Obtenir une instance locale de ce projet est très rapide en utilisant [docker-compose](https://docs.docker.com/compose/) et [docker](https://www.docker.com/products/docker-desktop) :

1. Cloner le repository :

```bash
git clone https://github.com/WissemeAkli/tpIgl
```

2. Créer l'image de l'application et exécuter les services (Nginx,MySQL,app) :

```bash
docker-compose build && docker-compose up -d 
```

3. Assurer vous que vous êtes entrain d'exécuter cette commande dans le dossier racine de votre application laravel. Cette commande crée vos images de conteneur et les démarre enfin. Si tout se déroule comme prévu, vous devrier pouvoir accéder à votre application laravel exécutée à l'intérieur de votre conteneur à: `http://127.0.0.1:80`

## Les Tests Unitaires 

Dans cette application on a testé notre api avec `phpunit`  on a tester seulement afficher les modules et groupe d un enseignant 
## Tests Avec Selenium 

### Exigences 

| Exigence                                 | Version |
| ------------------------------------------- | ------- |
| [Python](https://www.python.org/downloads/) | `3.6+`  |
| [Pip](https://pypi.org/project/pip/) | `9.0+`  |

Avant de commancer vérifier bien que l'application est en cours d'éxecution (Front-end et Back-end) et lancer ces commandes :

```bash
cd Selenium-Test
pip install selenium
python script.py
```

## Documentation des API 


