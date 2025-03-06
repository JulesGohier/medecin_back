# API Documentation

## Création de fausses données

Pour générer des fausses données dans l'application, suivez les étapes suivantes :

1. Exécutez le conteneur Symfony en mode interactif :
   ```sh
   docker exec -it symfony /bin/bash
   ```
2. Lancez la commande de chargement des fixtures :
   ```sh
   php bin/console doctrine:fixtures:load
   ```
3. Confirmez l'opération en répondant "yes".
4. Sortez du conteneur :
   ```sh
   exit
   ```

## Connexion à pgAdmin

Pour accéder à pgAdmin, suivez les étapes suivantes :

1. Accédez à pgAdmin via l'URL suivante : [http://localhost:8080](http://localhost:8080)
2. Utilisez les identifiants suivants pour vous connecter :
  - **Login** : `admin@admin.com`
  - **Mot de passe** : `admin`

### Ajouter un serveur dans pgAdmin

1. Cliquez sur "Ajouter un nouveau serveur".
2. Remplissez les champs comme suit :
  - **Nom** : Choisissez un nom (exemple : `MonServeur`)
  - **Nom d'hôte** : `postgres`
  - **Port** : `5432`
  - **Nom de la base de données** : `my_database`
  - **Identifiant** : `admin`
  - **Mot de passe** : `admin`
3. Validez pour enregistrer le serveur.

Vous êtes maintenant connecté à votre base de données via pgAdmin.



## Authentication

### Login Token
**POST** `api/login_token`
- Authentification d'un utilisateur.
- **Paramètres JSON :**
  ```json
  {
      "email": "medecin1@medecin.com",
      "password": "password123"
  }
  ```

## Register Patient  
**POST** `api/register/patient`  
- Inscription d'un utilisateur de type **Patient**.  
- **Paramètres JSON :**  

```json
{
    "email": "jean.dupont@gmail.com",
    "password": "password123",
    "nom": "DUPONT",
    "prenom": "Jean",
    "sexe": "homme",
    "num_tel": "0789686352",
    "date_naissance": "2004-04-06",
    "num_secu_sociale": "125235438241"
}
```

---

## Register Médecin  
**POST** `api/register/medecin`  
- Inscription d'un utilisateur de type **Médecin**.  
- Accessible seulement avec le role **Admin**
- **Paramètres JSON :**  

```json
{
    "email": "arthur.durand@medecin.com",
    "password": "password123",
    "nom": "DURAND",
    "prenom": "Arthur",
    "num_rpps": "018254763",
    "num_tel": "0612345678",
    "specialite": "Médecin Généraliste"
}
```

## Patients

### Récupérer tous les patients
**GET** `api/patients`
- Renvoie la liste de tous les patients.

### Ajouter un patient
**POST** `api/patients`
- Ajoute un nouveau patient.

### Récupérer un patient par numéro de sécurité sociale
**GET** `api/patients/{num_secu_sociale}`
- Renvoie les informations du patient correspondant.

### Supprimer un patient
**DELETE** `api/patients/{num_secu_sociale}`
- Supprime le patient correspondant.

### Modifier un patient
**PATCH** `api/patients/{num_secu_sociale}`
- Modifie les informations d'un patient.
- **Paramètres JSON :**
  ```json
  {
      "nom": "Durant",
      "numtel": "0124367859"
  }
  ```

## Médecins
Les mêmes opérations que pour `api/patients` s'appliquent à `api/medecins`.

## Rendez-vous
Les mêmes opérations que pour `api/patients` s'appliquent à `api/rendez_vouses`.

# Nouvelles Routes pour les Rendez-vous

## Récupérer les rendez-vous d'un patient par son numéro de sécurité sociale

### GET `api/rendez_vouses/patient/{num_secu_sociale}`

Renvoie l'ensemble des rendez-vous associés à un patient donné.

**Paramètres :**

- `num_secu_sociale` : Numéro de sécurité sociale du patient.

**Exemple de réponse :**

```json
[
    {
        "id": 1,
        "date": "2025-03-10T10:00:00",
        "medecin": {
            "id": 1,
            "nom": "Lemoine",
            "prenom": "Luc"
        }
    }
]
```

---

## Récupérer les rendez-vous d'un médecin par son numéro RPPS

### GET `api/rendez_vouses/medecin/{num_rpps}`

Renvoie l'ensemble des rendez-vous pris auprès d'un médecin spécifique.

**Paramètres :**

- `num_rpps` : Numéro RPPS du médecin.

**Exemple de réponse :**

```json
[
    {
        "id": 1,
        "date": "2025-03-10T10:00:00",
        "patient": {
            "id": 1,
            "nom": "DUPONT",
            "prenom": "Jean"
        }
    }
]
```

---

Ces nouvelles routes permettent d'améliorer l'accès aux rendez-vous en fonction du numéro de sécurité sociale du patient ou du numéro RPPS du médecin, optimisant ainsi la gestion et l'organisation des consultations.