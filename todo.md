# Application de gestion de conger employer
    - Faire une application qui permet aux employer de soumettre une demande de conger et que le RH peut approuver ou rejetter

# Cote client
    - [] Faire la page de connexion
    - [] Faire la deconnexion
    - [] Formulaire pour soumettre une demande 
    - [] Page pour verfier sa liste de demande avec statut (valider ou rejetter)
    - [] Page pour voir le reste de conger par type 
    Bonus
    - [] Boutton annuler demande en cours
    - [] Page pour modifier son profil

# Cote RH
    - [] Page pour voir les demandes en attente
    - [] Boutton pour approuver ou rejetter une demande 
    - [] Systeme de mise a jour automatique du solde de l'employe apres approbation
    Bonus
    - [] Filtre les demandes par departement et par statut
    - [] Page pour voir solde de chaque employe

# Cote Admin
    - [] Crud employe
        - [] Ajout
        - [] Modification
        - [] Suppresion
    - [] Crud departement
        - [] Ajout
        - [] Modification
        - [] Suppresion 
    - [] Crud type de conger
        - [] Ajout
        - [] Modification
        - [] Suppresion
    - [] Tableau de bords
        -[] Absence des employees durant le mois en cours
    
    Bonus
    - [] Initialiser solde annuel d'un employe (nb et type de conger)
    - [] Modifier le solde annuel d'un employe
    - [] Page pour voir toute les historiques complet de toutes les demandes 

# Cote Backend
    - [] Faire les cruds 
        - [] Employe ,RH, Admin
            - [] Ajout 
            - [] Modification
            - [] Suppresion

    - [] Connexion (Employe ,RH, Admin)
    - [] Client
        - [] soumettreDemande()
        - [] listeDemande() +statut
        - [] SoldeConger() restant
        - [] AnnulerDemande()
        - [] modifierProfil() ok si crud ok

    - [] Rh
        - [] validerDemande() -> commentaire optionnel
        - [] refuserDemande() -> commentaire optionnel
        - [] updateSolde(Employe)
        - [] listDemande() -> en cours
        - [] filtreDemande() -> Departement ou type
        - [] checkSolde() -> pour chaque employe

    - [] Admin
        - [] crud employer,departement, type (ok si crud ok)
        - [] listAbsence() -> du  mois en cours
        - [] crudSoldeEmploye()
        - [] histoDemande()
# Cote Frontend
    - [] Dashboard 
        - [] Employe 
        - [] Admin 
        - [] Rh 
