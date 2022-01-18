# TP - Quiz

> Membre : François BONNIN

## 1. Installation :
- composer : `composer install`
- créer le fichier .env : `cp .env.example .env`

## 2. Database :
- `php artisan migrate:fresh`
- `php artisan db:seed`

## 3. Requêtes :

#### Liste de tous les quiz disponibles :
GET :`/api/quiz`

#### Affichage d'un quiz :
GET :`/quiz/{quizId}`

<hr>

### Authentication :

#### Se connecter :
POST :`/api/auth/login`

#### S'enregistrer :
POST :`/api/auth/registrer`

<hr>

### Administrateur :
#### Ajouter un quiz (passer un quiz en paramètre, format JSON):
POST :`/api/quiz`

#### Modifier un quiz :
PUT :`/api/quiz/{quizId}`

#### Supprimer un quiz :
DELETE :`/api/quiz/{quizId}`

#### Publier un quiz :
POST :`/api/quiz/{quizId}/publish`

#### Dépublier un quiz  :
POST :`/api/quiz/{quizId}/unpublish`

#### Obtenir les scores :
GET :`/api/score`

<hr>

### Participants :

#### Afficher les questions :
GET :`/api/quiz/{quizId}/questions`

#### Afficher les choix de la question :
GET :`/api/quiz/{questionId}/choices`

#### Envoyer un quiz (mettre en paramètre la réponse et l'Id du quiz):
POST :`/api/score`

#### Obtenir les informations d'un utilisateur :
GET :`/user/{userId}`

