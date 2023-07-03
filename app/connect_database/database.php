<?php
class Database {

    // static est un mot-clé qui signifie que la propriété ou la méthode appartient à la classe elle-même, plutôt qu'à une instance spécifique de la classe. Les propriétés et les méthodes static peuvent être appelées directement depuis la classe, sans avoir besoin de créer une instance.
    private static $host = 'localhost';
    private static $dataBaseName = 'test_soutenance';
    private static $user = 'root';
    private static $pwd = '';

    // Instance PDO
    private static $pdo;
    
    // Options de connexion à la base de données
    private static $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Activer le mode exception pour la gestion d'erreurs
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Récupérer les résultats sous forme de tableau associatif
        PDO::ATTR_EMULATE_PREPARES => false, // Désactiver l'émulation des requêtes préparées pour une meilleure sécurité
    ];

    public function __construct(){
        die('Idk why');
    }

    public static function connect(){
        if(self::$pdo === null){
            try{
                self::$pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$dataBaseName.";charset=utf8",self::$user,self::$pwd,self::$options);
            } catch(PDOException $e){
                die("Erreur de connexion a la base de donnees : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function disconnect(){
        self::$pdo = null;
    }
}