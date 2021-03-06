<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/bootstrap.min.css">
    <title>exercise5</title>
</head>
<body>
<?php include("./partial/_navBar.php"); ?>

<h1>Exercise 5</h1>
<?php
if (!empty($_POST)) {
    if ($_POST["message"]) {
        $message = strip_tags($_POST["message"]);
    }
    if ($_POST["key"]) {
        $key = strip_tags($_POST["key"]);
    }
    if ($_POST["encodedMessage"]) {
        $encodedMessage = strip_tags($_POST["encodedMessage"]);
    }
    if ((!$key && $message)||(!$key && $encodedMessage)) {
        $errorMessage = "Vous devez entrer la clé";
    } elseif (!$message && !$encodedMessage && $key) {
        $errorMessage = "action non définie";
    } elseif ($message && $encodedMessage && $key) {
        $errorMessage = "trop d'informations";
    }
    if (!$errorMessage) {
        $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $alphabetTab = str_split($alphabet);
        $doubleAlphaTab = array_merge($alphabetTab, $alphabetTab);
        $sizeAlphabet = count($alphabetTab);
    
        for ($i = 0; $i < $sizeAlphabet; $i++){
            for ($j = 0; $j <$sizeAlphabet; $j++) {
                $line = $alphabetTab[$i];
                $column = $alphabetTab[$j];
                $vigenere[$line][$column] = $doubleAlphaTab[$i + $j];
            }
        }
        if ($message && $key) {
            $messageTab = str_split($message);
            $keyTab = str_split($key);
            $keySize = count($keyTab);
        
            $keyCounter = 0;
            foreach ($messageTab as $pointer => $letterToEncode) {
                $positionKeyLetter = $keyCounter % $keySize;
                $keyLetter = $keyTab[$positionKeyLetter];
                if($letterToEncode != " ") {
                    $encodedMessageTab[] = $vigenere[$letterToEncode][$keyLetter];
                } else {
                    $encodedMessageTab[] = " ";
                }
                $keyCounter++;
            }
            // TO DO
            $encodedMessage = implode($encodedMessageTab);
        } elseif ($encodedMessage && $key) {
            $key4decode = $key;
            $encodeMessageTab = str_split($encodedMessage);
            $key4decodeTab = str_split($key4decode);
            $key4decodeSize = count($key4decodeTab);
        
            $keyCounter = 0;
            foreach ($encodeMessageTab as $pointer => $letterToDecode) {
                $positionKeyLetter = $keyCounter % $key4decodeSize;
                $keyLetter = $key4decodeTab[$positionKeyLetter];
                if($letterToDecode != " ") {
                    for ($i = 0; $i < $sizeAlphabet; $i++){
                        $lineToDecode = $alphabetTab[$i];
                        if ($vigenere[$lineToDecode][$keyLetter] == $letterToDecode) {
                            $decrypteMessage[] = $lineToDecode;
                        }
                    }
                } else {
                    $decrypteMessage[] = " ";
                }
                $keyCounter++;
            }
        
            $message = implode($decrypteMessage);
            // TO DO
        }
    }
}?>

<h3>Système d'encodage de vigenère</h3>
<p>Vous pouvez entrer un message ou un code et la clé, ATTENTION en Majuscule</p>
<?php if ($errorMessage) :?>
<div class="alert alert-dismissible alert-warning">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h4 class="alert-heading">Attention!</h4>
  <p class="mb-0"><?php echo $errorMessage ?></p>
</div>
<?php endif ?>

    <form method="POST">
        <div class="form-group">
            <label for="message">LE MESSAGE</label>
            <textarea name="message" class="form-control border border-3" rows="2"><?php echo $message; ?></textarea>
        </div>
        <div class="form-group">
            <label class="col-form-label" for="key">LA CLE</label>
            <input type="text" class="form-control border border-3" name="key" value="<?php echo $key; ?>">
        </div>
        <div class="form-group">
            <label for="encodedMessage">LE CODE</label>
            <textarea name="encodedMessage" class="form-control border border-3" rows="2"><?php echo $encodedMessage;?></textarea>
        </div>
        <a href="/exercise5.php" class="btn-btn-primary mt-3 mb-3">ANNULER</a>
        <input type="submit" class="btn-btn-primary mt-3 mb-3" value="Vigenèriser">
    </form>
<script src="./bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>