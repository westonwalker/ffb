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
    <?php
		if (empty($game)) {
	?>
            <div class="grid grid-pad">
                <div class="col-1-1">
                    <div class="content">
                        <h1 class="center-text">Could not find the game!</h1>
                    </div>
                </div>
            </div>
    <?php
		} else {
	?>
                <div class="grid grid-pad">
                    <div class="col-1-1">
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: center;">
                                        <th><h2><?= $game['away']['name'] ?></h2></th>
                                        <th><h2><?= $game['away']['score']['T'] ?></h2></th>
                                        <th><h2><?= $game['clock'] . $game['qtr'] ?></h2></th>
                                        <th><h2><?= $game['home']['score']['T'] ?></h2></th>
                                        <th><h2><?= $game['home']['name'] ?></h2></th>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                <br/>
				<hr/>
                <div class="grid grid-pad">
                    <div class="col-1-2">
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: center; border-bottom: 1px solid black;">
                                        <th></th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>Total</th>
                                    </tr> 
                                    <tr style="text-align: center;">
                                        <td style="text-align: left;">
                                            <?= $game['away']['abbr'] ?>
                                        </td>
                                        <td>
                                            <?= $game['away']['score'][1] ?>
                                        </td>
                                        <td>
                                            <?= $game['away']['score'][2] ?>
                                        </td>
                                        <td>
                                            <?= $game['away']['score'][3] ?>
                                        </td>
                                        <td>
                                            <?= $game['away']['score'][4] ?>
                                        </td>
                                        <td>
                                            <?= $game['away']['score']['T'] ?>
                                        </td>
                                    </tr> 
                                    <tr style="text-align: center;">
                                        <td style="text-align: left;">
                                            <?= $game['home']['abbr'] ?>
                                        </td>
                                        <td>
                                            <?= $game['home']['score'][1] ?>
                                        </td>
                                        <td>
                                            <?= $game['home']['score'][2] ?>
                                        </td>
                                        <td>
                                            <?= $game['home']['score'][3] ?>
                                        </td>
                                        <td>
                                            <?= $game['home']['score'][4] ?>
                                        </td>
                                        <td>
                                            <?= $game['home']['score']['T'] ?>
                                        </td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    <div class="col-1-2">
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody> 
                                    <tr>
                                        <th style="text-align: left;">
                                            Current Play:
                                        </th>
                                    </tr> 
                                    <tr>
                                        <td style="text-align: left;">
                                            <?= $game['down'] ?> down and <?= $game['togo'] ?>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>
                                            <?= $game['posession'] ?> ball on the <?= $game['yl'] ?>  yd line
                                        </td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
                <br/>
                <hr/>
                <!-- PASSING -->
                <div class="grid grid-pad">
                    <div class="col-1-2">
                        <div class="content">
                            <h3>
                                <?= $game['away']['name'] ?> Passing</h3>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: right;">
                                        <th></th>
                                        <th>C/ATT</th>
                                        <th>YDS</th>
                                        <th>TDS</th>
                                        <th>INTS</th>
                                        <th>FP</th>
                                    </tr>
                                    <?php
							    		foreach ($game['away']['passing'] as $passer) { 
							       ?>
                                        <tr style="text-align: right;">
                                            <td style="text-align: left;">
                                                <?= $passer['name'] ?>
                                            </td>
                                            <td>
                                                <?= $passer['cmp'] . '/' . $passer['att'] ?>
                                            </td>
                                            <td>
                                                <?= $passer['yds'] ?>
                                            </td>
                                            <td>
                                                <?= $passer['tds'] ?>
                                            </td>
                                            <td>
                                                <?= $passer['ints'] ?>
                                            </td>
                                            <td>
                                                <?= $passer['fp'] ?>
                                            </td>
                                        </tr>
                                        <?php
											}
								       ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-1-2">
                        <div class="content">
                            <h3>
                                <?= $game['home']['name'] ?> Passing</h3>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: right;">
                                        <th></th>
                                        <th>C/ATT</th>
                                        <th>YDS</th>
                                        <th>TDS</th>
                                        <th>INTS</th>
                                        <th>FP</th>
                                    </tr>
                                    <?php
							    		foreach ($game['home']['passing'] as $passer) {
							       ?>
                                        <tr style="text-align: right;">
                                            <td style="text-align: left;">
                                                <?= $passer['name'] ?>
                                            </td>
                                            <td>
                                                <?= $passer['cmp'] . '/' . $passer['att'] ?>
                                            </td>
                                            <td>
                                                <?= $passer['yds'] ?>
                                            </td>
                                            <td>
                                                <?= $passer['tds'] ?>
                                            </td>
                                            <td>
                                                <?= $passer['ints'] ?>
                                            </td>
                                            <td>
                                                <?= $passer['fp'] ?>
                                            </td>
                                        </tr>
                                        <?php
											}
								       ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
                <!-- END PASSING -->
                <!-- RUSHING -->
                <div class="grid grid-pad">
                    <div class="col-1-2">
                        <div class="content">
                            <h3>
                                <?= $game['away']['name'] ?> Rushing</h3>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: right;">
                                        <th></th>
                                        <th>ATT</th>
                                        <th>YDS</th>
                                        <th>TDS</th>
                                        <th>FP</th>
                                    </tr>
                                    <?php
							    		foreach ($game['away']['rushing'] as $rusher) { 
							       ?>
                                        <tr style="text-align: right;">
                                            <td style="text-align: left;">
                                                <?= $rusher['name'] ?>
                                            </td>
                                            <td>
                                                <?= $rusher['att'] ?>
                                            </td>
                                            <td>
                                                <?= $rusher['yds'] ?>
                                            </td>
                                            <td>
                                                <?= $rusher['tds'] ?>
                                            </td>
                                            <td>
                                                <?= $rusher['fp'] ?>
                                            </td>
                                        </tr>
                                        <?php
											}
								       ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-1-2">
                        <div class="content">
                            <h3>
                                <?= $game['home']['name'] ?> Rushing</h3>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: right;">
                                        <th></th>
                                        <th>ATT</th>
                                        <th>YDS</th>
                                        <th>TDS</th>
                                        <th>FP</th>
                                    </tr>
                                    <?php
							    		foreach ($game['home']['rushing'] as $rusher) { 
							       ?>
                                        <tr style="text-align: right;">
                                            <td style="text-align: left;">
                                                <?= $rusher['name'] ?>
                                            </td>
                                            <td>
                                                <?= $rusher['att'] ?>
                                            </td>
                                            <td>
                                                <?= $rusher['yds'] ?>
                                            </td>
                                            <td>
                                                <?= $rusher['tds'] ?>
                                            </td>
                                            <td>
                                                <?= $rusher['fp'] ?>
                                            </td>
                                        </tr>
                                        <?php
											}
								       ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
                <!-- END RUSHING -->
                <!-- RECEIVING -->
                <div class="grid grid-pad">
                    <div class="col-1-2">
                        <div class="content">
                            <h3>
                                <?= $game['away']['name'] ?> Receiving</h3>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: right;">
                                        <th></th>
                                        <th>REC</th>
                                        <th>YDS</th>
                                        <th>TDS</th>
                                        <th>FP</th>
                                    </tr>
                                    <?php
							    		foreach ($game['away']['receiving'] as $receiver) { 
							       ?>
                                        <tr style="text-align: right;">
                                            <td style="text-align: left;">
                                                <?= $receiver['name'] ?>
                                            </td>
                                            <td>
                                                <?= $receiver['rec'] ?>
                                            </td>
                                            <td>
                                                <?= $receiver['yds'] ?>
                                            </td>
                                            <td>
                                                <?= $receiver['tds'] ?>
                                            </td>
                                            <td>
                                                <?= $receiver['fp'] ?>
                                            </td>
                                        </tr>
                                        <?php
											}
								       ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-1-2">
                        <div class="content">
                            <h3>
                                <?= $game['home']['name'] ?> Receiving</h3>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: right;">
                                        <th></th>
                                        <th>REC</th>
                                        <th>YDS</th>
                                        <th>TDS</th>
                                        <th>FP</th>
                                    </tr>
                                    <?php
							    		foreach ($game['home']['receiving'] as $receiver) { 
							       ?>
                                        <tr style="text-align: right;">
                                            <td style="text-align: left;">
                                                <?= $receiver['name'] ?>
                                            </td>
                                            <td>
                                                <?= $receiver['rec'] ?>
                                            </td>
                                            <td>
                                                <?= $receiver['yds'] ?>
                                            </td>
                                            <td>
                                                <?= $receiver['tds'] ?>
                                            </td>
                                            <td>
                                                <?= $receiver['fp'] ?>
                                            </td>
                                        </tr>
                                        <?php
											}
								       ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
                <!-- END RECEIVING -->
                <!-- KICKING -->
                <div class="grid grid-pad">
                    <div class="col-1-2">
                        <div class="content">
                            <h3>
                                <?= $game['away']['name'] ?> Kicking</h3>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: right;">
                                        <th></th>
                                        <th>FGM</th>
                                        <th>FGA</th>
                                    </tr>
                                    <?php
							    		foreach ($game['away']['kicking'] as $kicker) { 
							       ?>
                                        <tr style="text-align: right;">
                                            <td style="text-align: left;">
                                                <?= $kicker['name'] ?>
                                            </td>
                                            <td>
                                                <?= $kicker['fgm'] ?>
                                            </td>
                                            <td>
                                                <?= $kicker['fga'] ?>
                                            </td>
                                        </tr>
                                        <?php
											}
								       ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-1-2">
                        <div class="content">
                            <h3>
                                <?= $game['home']['name'] ?> Kicking</h3>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: right;">
                                        <th></th>
                                        <th>FGM</th>
                                        <th>FGA</th>
                                    </tr>
                                    <?php
							    		foreach ($game['home']['kicking'] as $kicker) { 
							       ?>
                                        <tr style="text-align: right;">
                                            <td style="text-align: left;">
                                                <?= $kicker['name'] ?>
                                            </td>
                                            <td>
                                                <?= $kicker['fgm'] ?>
                                            </td>
                                            <td>
                                                <?= $kicker['fga'] ?>
                                            </td>
                                        </tr>
                                        <?php
											}
								       ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
                <!-- END KICKING -->
                <!-- DEFENSE -->
                <div class="grid grid-pad">
                    <div class="col-1-2">
                        <div class="content">
                            <h3>
                                <?= $game['away']['name'] ?> Defense</h3>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: right;">
                                        <th></th>
                                        <th>SACKS</th>
                                        <th>INT</th>
                                        <th>FUM</th>
                                    </tr>
                                    <?php
							    		foreach ($game['away']['defense'] as $defense) { 
							       ?>
                                        <tr style="text-align: right;">
                                            <td style="text-align: left;">
                                                <?= $defense['name'] ?>
                                            </td>
                                            <td>
                                                <?= $defense['sk'] ?>
                                            </td>
                                            <td>
                                                <?= $defense['int'] ?>
                                            </td>
                                            <td>
                                                <?= $defense['ffum'] ?>
                                            </td>
                                        </tr>
                                        <?php
											}
								       ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-1-2">
                        <div class="content">
                            <h3>
                                <?= $game['home']['name'] ?> Defense</h3>
                        </div>
                        <div style="overflow-x:auto;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr style="text-align: right;">
                                        <th></th>
                                        <th>SACKS</th>
                                        <th>INT</th>
                                        <th>FUM</th>
                                    </tr>
                                    <?php
							    		foreach ($game['home']['defense'] as $defense) { 
							       ?>
                                        <tr style="text-align: right;">
                                            <td style="text-align: left;">
                                                <?= $defense['name'] ?>
                                            </td>
                                            <td>
                                                <?= $defense['sk'] ?>
                                            </td>
                                            <td>
                                                <?= $defense['int'] ?>
                                            </td>
                                            <td>
                                                <?= $defense['ffum'] ?>
                                            </td>
                                        </tr>
                                        <?php
											}
								       ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
                <!-- END DEFENSE -->
    <?php
			
		}
	?>
    </body>

    </html>
