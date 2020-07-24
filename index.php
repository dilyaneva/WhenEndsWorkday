 <?php 
    //When did you start work today?
    $whenStartedToday = '07:49';
    //When did you log out for lunch break?
    $whenGoForLunch = '12:56';
    //When did you log in after lunch?
    $whenBackFromLunch = '13:38';

    //my time shift is 07:30 long
    $hours = new DateTime('07:30');
    $format = 'H:i';
    $hours->format($format);
    $formatReplace = '%H:%i';
    
    $regEx = "/^([0-1]?[0-9]|[2][0-3]):([0-5][0-9])$/"; //01:30
    if (preg_match($regEx, $whenStartedToday)
        && preg_match($regEx, $whenGoForLunch)
        && preg_match($regEx, $whenBackFromLunch)) 
	{
        $signIn = new DateTime($whenStartedToday);
        $signOutLunch = new DateTime($whenGoForLunch);
        $signInLunch = new DateTime($whenBackFromLunch);      

        $workBeforeLunch = $signOutLunch->diff($signIn)->format($formatReplace);
        $workBeforeLunch = new DateTime($workBeforeLunch);
      
        $leftHours = $hours->diff($workBeforeLunch)->format($formatReplace);
        $leftHours = new DateTime($leftHours);

        $interval = new DateInterval(
            'PT' . $leftHours->format('H') . 'H' . $leftHours->format('i') . 'M'
        );

        $when = $signInLunch->add($interval);

        echo 'Workday ends at: ' . $when->format($format);
    }

    ?> 
