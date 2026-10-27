<?php
    session_start();
    header("Content-type: text/xml");

    # Used to adjust puzzle width to match current phone model.
    function getCiscoPhoneModel() {
        return $_SERVER['HTTP_X_CISCOIPPHONEMODELNAME'] ?? 'unknown';
    }

    $urlPath = "http://192.168.3.250/cisco/wheel.php";

    $puzzle = array(
        "Beautiful! Powerful! Dangerous! Cold!",
        "Frozen",

        "Split the ice apart. Beware the frozen heart.",
        "Frozen",

        "There's beauty and there's danger here.",
        "Frozen",

        "Do you wanna build a snowman?",
        "Frozen",

        "Just watching the hours tick by, tick tock tick tock.",
        "Frozen",

        "For the first time in forever. Nothing's in my way!",
        "Frozen",

        "Can I say something crazy?",
        "Frozen",

        "Love is an open door. Life can be so much more.",
        "Frozen",

        "Let it go, let it go. Can't hold it back anymore.",
        "Frozen",

        "The cold never bothered me anyway.",
        "Frozen",

        "Reindeers are better than people.",
        "Frozen",

        "Good night. Don't let the frontbite bite.",
        "Frozen",

        "Just imagine how much cooler I'll be in summerrr.",
        "Frozen",

        "The hot and the cold are both so intense.",
        "Frozen",

        "When life gets rough, I like to hold on to my dream.",
        "Frozen",

        "Why are you holding back from such a man?",
        "Frozen",

        "So he's a bit of a fixer-upper.",
        "Frozen",

        "Everyone's a bit of a fixer-upper.",
        "Frozen",

        "True love brings out their best!",
        "Frozen",

        "Moana, make way, make way!",
        "Moana",

        "Moana, that voice inside is who you are.",
        "Moana",

        "You can find happiness right where you are.",
        "Moana",

        "I've been staring at the edge of the water.",
        "Moana",

        "One day I'll know how far I'll go.",
        "Moana",

        "And when it's time to find home, we know the way.",
        "Moana",

        "You're face-to-face with greatness and it's strange.",
        "Moana",

        "Yes, it's really me, It's Maui! Breathe it in.",
        "Moana",

        "So what can I say except you're welcome?",
        "Moana",

        "Now I know I can be happy as a clam.",
        "Moana",

        "I'd rather be Shiny, like a treasure from a sunken ship.",
        "Moana",

        "Shiny. Watch me dazzle like a diamond in the rough.",
        "Moana",

        "We are explorers reading every sign.",
        "Moana",

        "Oh, imagine a land, it's a faraway place.",
        "Aladdin",

        "Hop on a carpet and fly, to another Arabian night.",
        "Aladdin",

        "There's a road that may lead you to good or to greed.",
        "Aladdin",

        "Gotta keep one jump ahead of the breadline.",
        "Aladdin",

        "One jump ahead of the lawman.",
        "Aladdin",

        "Riff raff! Street rat! Scoundrel! Take that!",
        "Aladdin",

        "One jump ahead of the slowpokes.",
        "Aladdin",

        "They're quick, but I'm much faster.",
        "Aladdin",

        "Here comes a wave meant to wash me away.",
        "Aladdin",

        "Broken again, left with nothing to say.",
        "Aladdin",

        "All I know is I won't go speechless.",
        "Aladdin",

        "Well, Ali Baba, he had them forty thieves.",
        "Aladdin",

        "All you gotta do is rub that lamp.",
        "Aladdin",

        "You ain't never had a friend like me!",
        "Aladdin",

        "Say what you wish, it's yours!",
        "Aladdin",

        "So what's your wish? I really wanna know.",
        "Aladdin",

        "One wish, or two, or three.",
        "Aladdin",

        "Make way for Prince Ali.",
        "Aladdin",

        "Make way! Here he comes! Ring bells! Bang the drums.",
        "Aladdin",

        "Prince Ali! Fabulous he! Ali Ababwa.",
        "Aladdin",

        "Prince Ali, mighty is he, Ali Ababwa.",
        "Aladdin",

        "Prince Ali, Handsome is he, Ali Ababwa.",
        "Aladdin",

        "A whole new world. A new fantastic point of view.",
        "Aladdin",

        "Let me share this whole new world with you.",
        "Aladdin",

        "Ruthlessness is mercy upon ourselves.",
        "Epic",

        "This life is amazing when you greet it with open arms.",
        "Epic",

        "I see a song of past romance.",
        "Epic",

        "I can take the suffering from you.",
        "Epic",

        "Keep your friends close and your enemies closer.",
        "Epic",

        "Pride is a damsel in distress.",
        "Epic",

        "Wouldn't you like the taste of the power?",
        "Epic",

        "Wouldn't you like to use more than words?",
        "Epic",

        "If you make one wrong move, then you're done for.",
        "Epic",

        "Ha, how do you like that? You goin to like that.",
        "Black Pink",

        "This that Pink venom. Get 'em, get 'em, get 'em.",
        "Black Pink",

        "Let's kill this love! Yeah, yeah, yeah, yeah, yeah.",
        "Black Pink",

        "Boombayah, Yah, yah, yah, boombayah.",
        "Black Pink",

        "When we pull up, you know it's a shutdown.",
        "Black Pink",

        "Don't mess with the girls.",
        "Black Pink",

        "Love, l-l-love, l-l-love.",
        "Black Pink",
 
        "How you love to hate me.",
        "Black Pink" );

    $wheel = array(
        0, 0, 0,
        60,60,60,
        40,40,40,
        30,30,30,
        80,80,80,
        35,35,35,
        45,45,45,
        70,70,70,
        30,30,30,
        60,60,60,
        500,500,500,
        30,30,30,
        60,60,60,
        30,30,30,
        50,50,50,
        80,80,80,
        55,55,55,
        40,40,40,
        30,30,30,
        90,90,90,
        50,50,50,
        90,90,90 );

    $count = 73;

    # Recall prior variable state.
    $id = $_SESSION['id'] ?? "";                    # App name.

    # $cmd = "";

    # Prevent data corruption to next application.
    if ($id == "wheel") {
        $cmd = $_SESSION['cmd'] ?? "";
        $state = $_SESSION['state'] ?? 0;
        $total = $_SESSION['total'] ?? 0;
        $wheelPos = $_SESSION['wheelPos'] ?? 0;
        $game = $_SESSION['game'] ?? 0;
        $guess = $_SESSION['guess'] ?? "";
        $width = $_SESSION['width'] ?? 0;

        $ndx1 = $game * 2;      # Calculate puzzle text index.
        $text = $puzzle[$ndx1]; 
		$mesg = ""; 
        }

    else {
        $game = mt_rand(0,$count - 1);

        # $game = $count - 4;     # test using the last game.

        $ndx1 = $game * 2;      # Puzzle text index.
        $ndx2 = $ndx1 + 1;      # Puzzle theme index.

        $text = $puzzle[$ndx1];
        $len = strlen($text);

        $mesg = "Hint: ".$puzzle[$ndx2];
        $guess = "";


        # Set the screen width based on phone model.
        $model = getCiscoPhoneModel();

        if ($model == "CP-7911G")
            $width = 21;
        else
            $width = 17;	


        # Hide the letters, but reveal just the spaces and special characters.
        for ($i = 0; $i < $len; $i++) {
            $letter = substr($text, $i, 1);
            
            switch($letter) {
                case "-" :
                case "'" :
                case "." :
                case "," :
                case "?" :
                case "!" :
                case " " :
                    $guess = $guess.$letter;
                    break;
                default :
					$guess = $guess."#"; 
            }
        }
        
		$total = 0;
		$state = 0;
		$wheelPos = 0;
		$wheelAmt = "";
    }


    # Get SoftKey selection and determine which action to take.
    $key = $_GET['key'] ?? "";
    
    switch($key) {
        case "vowel" :
            if ($total < 250) {
                $mesg = "You have less than $250!";
                
                # Inhibit query for vowel.
                $key = "";
            }
            else
                $mesg = "Pick a vowel";
            break;
            
        case "spin" :
            if ($state == 0) {
                $n = mt_rand(13,31);
                $wheelPos = ($wheelPos + $n) % 66;
				$amt = $wheel[$wheelPos] * 10;
    
                if ($amt == 0) {
                    $wheelAmt = " - Bankrupt";
                    $total = 0;
                    $state = 0;
                }

                $state = 1;
            }
            else
                $mesg = "Select vowel or letter.";
            break;
            
        case "letter" :
            if ($state == 0) { $mesg = "Spin the wheel first!";
                
                # Inhibit query for letter.
                $key = "";
            }
            else
                $mesg = "Pick a  letter";
            break;
    }


    # Update current wheel amount display.
	$amt = $wheel[$wheelPos] * 10;

    if ($amt > 0)
        $wheelAmt = " - $".number_format($amt);
    
    
	# Determine the number of matches found within the text.
    $data = $_GET['ch'] ?? "";
	$ch = substr($data,1,1);

    $textCnt = 0;

	if (strlen($ch) > 0) {
        $textCnt = substr_count(strtoupper($text),$ch);
        $guessCnt = substr_count(strtoupper($guess),$ch);
        
        switch($ch) {
            case "A" :
			case "E" :
            case "I" :
            case "O" :
            case "U" :
                if ($cmd == "letter") {
                    $mesg = "That was not a consonant!";
                    break;
                }
                
                if ($guessCnt > 0) {
                    $mesg = "Letter was already found!";
                    break;
                }
                
                if ($textCnt == 0) {
                    $mesg = "Vowel not found!";
                    $total = 0;
                }
                else
                    $total -= 250;
                break;
                
            default :
                $state = 0;
                
                if ($cmd == "vowel") {
                    $mesg = "That was not a vowel!";
                    break;
                }
                
                if ($guessCnt > 0) {
                    $mesg = "Letter was already found!";
                    break;
                }
                
                if ($textCnt == 0) 
                    $mesg = "Consonant not found!";
                else
                    $total += $textCnt * $wheel[$wheelPos] * 10;
                break;
        }
    }
    
    
    # Reveal the letters successfully guessed.
    if (($textCnt > 0) && ($mesg == "")) {
        
        $len = strlen($text);
        $lowercase = strtolower($ch);
        $temp = $guess;
        $guess = "";
        
        for ($i = 0; $i < $len; $i++) {
            $letter = substr($text, $i, 1);
            
            switch($letter) {
                case $ch :
                case $lowercase :
                    $guess = $guess.$letter;
                    break;
                    
                default :
                    $guess = $guess.substr($temp, $i, 1);
            }
        }
    }
    

    # Initialize screen array.
    $screen[0] = "";
    $screen[1] = "";
    $screen[2] = "";


    # Perform word wrap operation to evenly fill multi-line 16 char/line display on 7961.
    # Perform word wrap operation to evenly fill multi-line 21 char/line display on 7911.
    $length = strlen($guess);
    $lineCnt = 1 + floor($length / $width) - floor($length / 60);
    $lineLen = floor($length / $lineCnt) + 4;
    
    if ($lineLen > $width)
        $lineLen = $width;

    $words = explode(" ",$guess);
    
    $i = 0; $j = 0;
    $screen[$i] = $words[$j++];

	while (isset($words[$j]))

		if (strlen($screen[$i].$words[$j]) < $lineLen)
            $screen[$i] = $screen[$i]." ".$words[$j++];
        else
            $screen[++$i] = $words[$j++];
    
    
    # Expand the text display to simulate Wheel of Fortune format.
    for ($i = 0; isset($screen[$i]); $i++) {
        $lineLen = strlen($screen[$i]);
        $temp = "";
        
        for ($j = 0; $j < $lineLen; $j++) {
            $letter = substr($screen[$i],$j,1);

            switch($letter) {
                case "-" :
                    $string = "-  ";
                    break;
                case "'" :
                    $string = "'   ";
                    break;
                case "." :
                    $string = ".  ";
                    break;
                case "," :
                    $string = ",  ";
                    break;
                case "?" :
                    $string = "?  ";
                    break; 
                case "!" : 
                    $string = "!  ";
                    break;
                case " " : 
                    $string = "    ";
                    break;
                default :
                    $string = strtoupper($letter)." "; 
            }
            $temp = $temp.$string;
        }
        
        $screen[$i] = $temp;
    }
    
    
    # Update IP Phone display.
    if (($key != "vowel") && ($key != "letter")) {
        
        # If no error messages, display running balance.
        if ($mesg == "") 
            $mesg = "Balance: $".number_format($total);
        
        echo "<CiscoIPPhoneText>\n";
        echo "  <Title>Wheel of Fortune".$wheelAmt."</Title>\n";
        echo "  <Text>".$screen[0]."\n".$screen[1]."\n".$screen[2]."</Text>\n";
        
        if ($guess != $text) {
            echo "  <SoftKeyItem>\n";
            echo "    <Name>Vowel</Name>\n";
            echo "    <URL>$urlPath?key=vowel</URL>\n";
            echo "    <Position>1</Position>\n";
            echo "  </SoftKeyItem>\n";
            
            echo "  <SoftKeyItem>\n";
            echo "    <Name>Spin</Name>\n";
            echo "    <URL>$urlPath?key=spin</URL>\n";
            echo "    <Position>2</Position>\n";
            echo "  </SoftKeyItem>\n";
            
            echo "  <SoftKeyItem>\n";
            echo "    <Name>Letter</Name>\n";
            echo "    <URL>$urlPath?key=letter</URL>\n";
            echo "    <Position>3</Position>\n";
            echo "  </SoftKeyItem>\n";

			$id = "wheel"; 
        }

        else
            $id = "";
        
        echo "  <SoftKeyItem>\n";
        echo "    <Name>Exit</Name>\n";
        echo "    <URL>SoftKey:Exit</URL>\n";
        echo "    <Position>4</Position>\n";
        echo "  </SoftKeyItem>\n";
        
        echo "  <Prompt>".$mesg."</Prompt>\n";
		echo "</CiscoIPPhoneText>\n"; 
        }
    
    else {
        echo "<CiscoIPPhoneInput>\n";
        echo "  <Title>Wheel of Fortune".$wheelAmt."</Title>\n";
        echo "  <URL method=\"post\">$urlPath</URL>\n";
        
        echo "  <InputItem>\n";
        echo "    <DisplayName>".$mesg."</DisplayName>\n";
        echo "    <QueryStringParam>ch</QueryStringParam>\n";
        echo "    <DefaultValue> </DefaultValue>\n";
        echo "    <InputFlags>U</InputFlags>\n";
        echo "  </InputItem>\n";
        
        echo "  <SoftKeyItem>\n";
        echo "    <Name>Submit</Name>\n";
        echo "    <URL>SoftKey:Submit</URL>\n";
        echo "    <Position>2</Position>\n";
        echo "  </SoftKeyItem>\n";
        
        echo "  <SoftKeyItem>\n";
        echo "    <Name>Erase</Name>\n";
        echo "    <URL>SoftKey:Back</URL>\n";
        echo "    <Position>3</Position>\n";
        echo "  </SoftKeyItem>\n";
        
        echo "  <SoftKeyItem>\n";
        echo "    <Name>Cancel</Name>\n";
        echo "    <URL>$urlPath?key=home</URL>\n";
        echo "    <Position>4</Position>\n";
        echo "  </SoftKeyItem>\n";
        
        echo "  <Prompt>Use numeric keypad to enter.</Prompt>\n";
        echo "</CiscoIPPhoneInput>\n";

        # Save SoftKey command, for further processing.
		$cmd = $key; 
        }


    # Save current variable state.
    $_SESSION['id'] = $id;
    $_SESSION['cmd'] = $cmd;
    $_SESSION['state'] = $state;
    $_SESSION['total'] = $total;
    $_SESSION['wheelPos'] = $wheelPos;
    $_SESSION['game'] = $game;
    $_SESSION['guess'] = $guess;
    $_SESSION['width'] = $width;
?>
