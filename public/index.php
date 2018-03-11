<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();


//Create a function that connect with MySQL server
function getConnection() {

    $dbhost="127.0.0.1"; //IP
    $dbuser="root"; //user
    $dbpass=""; //pass
    $dbname="api_db"; //db name
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass); //PDO connect
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //return an error if the connexion can't be establsihed
    return $dbh;

}


//Function that obtains the list of hostings in the bd
function obtenerHostings($response) {
    $sql = "SELECT * FROM Hosting";
    
try {
        $stmt = getConnection()->query($sql); //connect with mysql and do the query
        $hosting = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null; //close the conection

        return json_encode($hosting); //return the data
    

} catch(PDOException $e) {

    $error = var_dump(http_response_code()); //if the response is an error show the server status code
      echo $error;

    }
}


function agregarHosting($request) {
    $emp = json_decode($request->getBody()); //Catch the information from the data you pass in the http request
    $sql = "INSERT INTO Hosting (Nombre, Cores, Memoria, Disco) VALUES (:Nombre, :Cores, :Memoria, :Disco)"; //Query mysql
    try {
        $db = getConnection(); //use the function getconnection to connect to db
        $stmt = $db->prepare($sql); 
        $stmt->bindParam("Nombre", $emp->Nombre); //Catch the parameters that the user pass
        $stmt->bindParam("Cores", $emp->Cores);
        $stmt->bindParam("Memoria", $emp->Memoria);
        $stmt->bindParam("Disco", $emp->Disco);
        $stmt->execute();
        $emp->id = $db->lastInsertId();
        $db = null; //close the connection
        echo json_encode($emp); //show the data in the response
    } catch(PDOException $e) {
      $error = var_dump(http_response_code());  //if the response is an error show the server status code
      echo $error; //show the http response code
    }
}


function actualizarHosting($request) { //function to update hosting 
    $emp = json_decode($request->getBody()); //Catch the information from the data you pass in the http request
    $id = $request->getAttribute('id'); //catch the id attribute
    $sql = "UPDATE Hosting SET Nombre=:Nombre, Cores=:Cores, Memoria=:Memoria, Disco=:Disco WHERE Id=:id";//mysql query to update
    try {
        $db = getConnection(); //use function getconnection
        $stmt = $db->prepare($sql);
        $stmt->bindParam("Nombre", $emp->Nombre); //catch the parameters that the user pass
        $stmt->bindParam("Cores", $emp->Cores);
        $stmt->bindParam("Memoria", $emp->Memoria);
        $stmt->bindParam("Disco", $emp->Disco);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null; //close connection
        echo json_encode($emp);
    } catch(PDOException $e) {
        $error = var_dump(http_response_code()); //if the response is an error show the server status code
      echo $error; //show the error status
    }
}


function eliminarHosting($request) { //function delete hosting
    $id = $request->getAttribute('id');  //catch the id
    $sql = "DELETE FROM Hosting WHERE Id=:id"; //query mysql
    try {
        $db = getConnection(); //function get connection
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id); //catch id
        $stmt->execute();
        $db = null; //close connection
        echo '{"error":{"text":"Hosting deleted"}}'; //If hosting is delete show the message
    } catch(PDOException $e) {
     $error = var_dump(http_response_code()); //if the response is an error show the server status code
      echo $error; //show error status
    }
}
