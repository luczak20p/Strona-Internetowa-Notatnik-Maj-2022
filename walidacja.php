<?php
ob_start();
session_start();
$_SESSION["ErrorMassage"] = "";
$uzytkownicy = explode(",", file_get_contents("uzytkownicy.txt"));


function testowanie($uzytkownicy){

    for($i=0;$i<count($uzytkownicy);$i++){

        if($_POST["login"]==$uzytkownicy[$i]&&$_POST["password"]==$uzytkownicy[$i+1]){
            echo "O";
            return true;
        }
    
    }

    return false;
}


if (isset($_POST["login"]) && isset($_POST["password"])) {
    if (!preg_match('/^([A-Za-z0-9-_]+)$/', $_POST["login"]) || !preg_match('/^([A-Za-z0-9-_]+)$/', $_POST["password"])) {
        $_SESSION["ErrorMassage"] = "Błędne hasło lub nazwa użytkownika";
        header("Location: logowanie.php");
    } else {
        if (is_writable("uzytkownicy.txt")) {

            if(in_array($_POST["login"], $uzytkownicy)){
                if(testowanie($uzytkownicy)){
                    $_SESSION["user"] = $_POST["login"];
                    header("Location: testuje.php");
                }
                else{
                    $_SESSION["ErrorMassage"] = "Złe hasło lub login ";
                    header("Location: logowanie.php");
                }

            }
            else{
                //trzeba zrobić osobno userów i osobno hasła
                fwrite(fopen("uzytkownicy.txt", "a+"), "{$_POST["login"]},{$_POST["password"]},");
                $testujeee ="pliki\\{$_POST['login']}";
                mkdir($testujeee);
                $_SESSION["ErrorMassage"] = "";
                $_SESSION["user"] = $_POST["login"];
                header("Location: testuje.php");

            }
           
        }
    }





}





