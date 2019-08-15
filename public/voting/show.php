<?php # BMP — Javier González González

$txid = e($_GET[1]);

$voting = action_voting_info($txid);

$__template['title'] = 'Voting: '.$voting['question'];

$__template['lib_js'][]  = '/public/voting/voting.js';

?>

<h1>Voting</h1>


<table border=0 width="100%"><tr><td valign="top" style="min-width:500px;">


<fieldset>
<legend style="font-size:22px;font-weight:bold;"><?=$voting['question']?></legend>

<legend style="float:right;font-size:14px;margin-top:-46px;"><?=strtoupper($voting['status'])?></legend>

<ol>
<?php
foreach ($voting['points'] AS $text)
    echo '<li>'.html_h($text, 3).'</li>';
?>
</ol>


</fieldset>






<fieldset>
<legend>Result</legend>

<span style="float:right;">

</span>


<?php

$config = array(
        'votes'     => array('align' => 'right', 'num' => 0),
        'power'     => array('align' => 'right', 'num' => POWER_PRECISION, 'after' => '%', 'bold' => true),
        'hashpower' => array('align' => 'right', 'function' => 'hashpower_humans'),
    );

foreach ($voting['options'] AS $option)
    $print_options[] = array(
            'option'    => $option['option'],
            'votes'     => $option['votes'],
            'power'     => $option['power'],
            'hashpower' => $option['hashpower'],
        );

echo html_table($print_options, $config);

?>

<br />

<legend style="float:right;font-size:14px;margin-bottom:-14px;">Validity <?=num($voting['validity']['valid'],POWER_PRECISION)?>%</legend>

</fieldset>


<?php if ($voting['status']=='open') { ?>

<fieldset>
<legend>Vote</legend>


<form id="voting_vote">

<input type="hidden" id="voting_txid" value="<?=$voting['txid']?>" />
<input type="hidden" id="voting_type_vote" value="1" />

<p>
<select id="voting_option" style="font-size:22px;white-space:normal;max-width:400px;">

<?php
foreach ($voting['options'] AS $option_txid => $r)
    echo '<option value="'.$r['vote'].'">'.$r['option'].'</option>';
?>

</select> 
</p>


<table border=0>

<tr>
<td>

<input type="submit" value="Vote" class="executive_action btn btn-success" />

</td>
<td style="padding-top:8px;">

<input id="rv_1" type="radio" name="voting_validity" value="1" class="radio" required /> 
<label for="rv_1">This voting is valid.</label>
<br />
<input id="rv_0" type="radio" name="voting_validity" value="0" class="radio" required /> 
<label for="rv_0">This voting is not valid.</label>

</td>
</tr>


</table>


<p><input type="text" id="voting_comment" maxlength="41" value="" autocomplete="off" style="width:100%;padding:4px;" placeholder="Comment..." /></p>

<span id="op_return_preview" class="monospace" style="font-size:13px;"></span>

</form>



<legend style="float:right;font-size:14px;margin-bottom:-14px;">Closed in <?=$voting['close_in']?> blocks</legend>

</fieldset>


<?php } ?>





</td><td valign="top" style="font-size:11px;">


<?=print_r2(json_encode($voting, JSON_PRETTY_PRINT))?>


</td></tr></table>