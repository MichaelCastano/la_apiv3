<?php
/* Verbindung zur Datenbank herstellen */
function db_connect(){
  $mysqli = new mysqli('mysql.knallhart.de','20120622002-1','#%6KkRqof7V)u9S5','20120622002-1');
  if ($mysqli->connect_errno) {
    database_error("Failed to connect to database",$mysqli->connect_errno,$mysqli->connect_error);
  }
}

/* Datenbankverbindung schließen  */
function db_close(){
  $mysqli->close();
}

/* Hole Konzerte in Arrays */
function getUpcomingGigs(){
  /* Prepared statement, stage 1: prepare */
  if (!($stmt = $mysqli->prepare("SELECT * FROM `gigs` WHERE `date` >= CURDATE() AND `public` LIKE 1 ORDER BY `date` ASC"))) {
    database_error("Failed to prepare statement!",$mysqli->errno, $mysqli->error);
  }
  
  $stmt->close();
}



/* Hole Konzerte in Arrays */
function getAllGigs(){
  if (!($stmt = $mysqli->prepare("SELECT * FROM `gigs` ORDER BY `date` ASC"))) {
    database_error("Failed to prepare statement!",$mysqli->errno, $mysqli->error);
  }
}

/* Hole einen Gig */
function getGigById($id){
  return mysql_query("SELECT * FROM `konzerte` WHERE `id` LIKE $id");
}

/* Hole Konzerte in Arrays */
function getPastGigs(){
  return mysql_query("SELECT * FROM `konzerte` WHERE `datum` < CURDATE() AND `public` LIKE 1 ORDER BY `datum` DESC");
}

/* Hole Konzerte in Arrays */
function getPastGigsByYear($year){
  return mysql_query("SELECT * FROM `konzerte` WHERE `datum` < CURDATE() AND YEAR(`datum`) = $year AND `public` LIKE 1 ORDER BY `datum` DESC");
}

/* Hole die nächsten 3 Konzerte für Notizzettel */
function getNUpcomingGigs($limit){
  return mysql_query("SELECT * FROM `konzerte` WHERE `datum` >= CURDATE() AND `public` LIKE 1 ORDER BY `datum` ASC LIMIT $limit");
}

/* Füge einen neuen Gig hinzu */
function addGig($bezeichnung, $datum, $lokalitaet, $ort, $eintritt){
  return mysql_query("INSERT INTO `konzerte` (`bezeichnung`, `datum`, `lokalitaet`, `ort`, `eintritt`) VALUES ('$bezeichnung', '$datum', '$lokalitaet', '$ort', '$eintritt')");
}

/* Speichert einen Gig */
function saveGig($id, $bezeichnung, $datum, $lokalitaet, $ort, $eintritt){
  return mysql_query("UPDATE `konzerte` SET `bezeichnung` = '$bezeichnung', `datum` = '$datum', `lokalitaet` = '$lokalitaet', `ort` = '$ort', `eintritt` = '$eintritt' WHERE `id` ='$id'");
}

/* Füge eine neue Bestellung hinzu */
function delGig($id){
  return mysql_query("DELETE FROM `konzerte` WHERE `id` =$id");
}

?>
