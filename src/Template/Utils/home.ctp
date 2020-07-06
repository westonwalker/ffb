<?php
$this->layout = false; 
?>
<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Fantasy Football Lite</title>
    <meta name="description" content="Fantasy Football scores that is easy on the users data.">
    <meta name="author" content="Weston Walker">

    <?= $this->Html->css('columns.css') ?>

    <!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
	<![endif]-->
</head>

<body> 
	<div class="grid grid-pad">
	    <div class="col-1-1">
	       <div class="content">
	           <h1 class="center-text"><?= $games['week_info']['year'] ?> Season Week <?= $games['week_info']['week']?></h1>
	       </div>
	    </div>
	</div> 
	<div class="grid grid-pad">
	    <div class="col-1-1">
	       <div class="content center-text">
				<?php 
					foreach ($weeks as $week) {
				?>
	        		<a href="/?week=<?= $week ?>"><?= $week ?></a>
				<?php 
					}
				?> 
	       </div>
	    </div>
	</div> 
	<br/>
	<?php 
		foreach ($games['games'] as $game) {
	?>  
	    <div class="grid grid-pad">
	        <div class="col-1-1"> 
	            <div style="overflow-x:auto;">
	                <table style="width: 100%;">
	                    <tbody>
	                        <tr style="text-align: left;">
	                            <th width="25%"></th>
	                            <th width="25%"><?= $game['status'] ?></th>
	                            <th width="25%"><?= $game['home_team'] ?></th>
	                            <th width="25%"><?= $game['home_score'] ?></th> 
	                        </tr> 
	                        <tr style="text-align: left;">
	                            <th width="25%"></th>
	                            <td width="25%"><a href="/gamedetails?gameId=<?= $game['date_id'] ?>">Details</a></td>
	                            <th width="25%"><?= $game['visitor_team'] ?></th>
	                            <th width="25%"><?= $game['visitor_score'] ?></th> 
	                        </tr>
	                </table>
	            </div>
	        </div>
	    </div>
	    <hr/>
	<?php 
		}
	?>   
</body>

</html>
