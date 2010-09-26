<?php

$api_url = "http://api.crunchbase.com/v/1/person/";

$users = array(
	'pg' => 'paul-graham',
	'spolsky' => 'joel-spolsky-2',
	'a4agarwal' => 'sachin-agarwal',
	'techcrunch' => 'michael-arrington',
	'epi0Bauqu' => 'gabriel-weinberg',
	'AndrewWarner' => 'andrew-warner',
	'swombat' => 'daniel-tenner',
	'dhh' => 'david-heinemeier-hansson',
	'daniel_levine' => 'daniel-levine',
	'bkrausz' => 'brian-krausz',
	'mceachen' => 'matthew-mceachen',
	'rgrieselhuber' => 'ray-grieselhuber',
	'rdamico' => 'ryan-damico',
	'jon_dahl' => 'jon-dahl',
	'answerly' => 'joe-fahrner',
	'jlm382' => 'jessica-mah',
	'brianchesky' => 'brian-chesky',
	'billclerico' => 'bill-clerico',
	'dhouston' => 'drew-houston',
	'danielha' => 'daniel-ha',
	'rantfoil' => 'garry-tan',
	'petesmithy' => 'pete-smith',
	'justin' => 'justin-kan',
	'gduffy' => 'greg-duffy',
	'spencerfry' => 'spencer-fry',
	'thinkcomp' => 'aaron-greenspan',
	'jack7890' => 'jack-groetzinger',
	'davewiner' => 'dave-winer'
);

if (isset($users[$_GET['user_id']])) {
	// Request to crunchbase
	$json = file_get_contents($api_url . $users[$_GET['user_id']] . '.js');
	$person = json_decode($json);
	
	$tooltip = substr(strip_tags($person->overview),0,200) . "... <br /><br />";
	
	foreach($person->relationships as $relationship) {
		if ($relationship->is_past == "true") { $tooltip .= "Ex "; }
			$tooltip .= $relationship->title . " @ ";
			$tooltip .= ($relationship->is_past == "true") ? $relationship->firm->name : "<strong>" . $relationship->firm->name . "</strong>";
			$tooltip .= "<br />";
	}
	
	$picture = "http://dev.syskall.com/hn/anonymous.jpg";
	
	if (!empty($person->image->available_sizes[0][1]))
		$picture = "http://crunchbase.com/" . $person->image->available_sizes[0][1];
?>
 
<div style="display:inline; position:relative;">

<a href="<?php echo $person->crunchbase_url; ?>" style="text-decoration:none">
<img src="<?php echo $picture; ?>" style="text-decoration:none;border:none;" width="30" height="30"
	onmouseover="this.parentNode.getElementsByTagName('span')[0].style.display='block'" onmouseout="this.parentNode.getElementsByTagName('span')[0].style.display='none';" />
<span style="display:none;position:absolute;top:-50px;right:-250px;padding:10px;background-color:#ff6600;filter:alpha(opacity=80);-moz-opacity: 0.8; opacity: 0.8; width:220px;color:#000;text-decoration:none;border:none"><?php echo $tooltip; ?></span>
</a>
</div>
<?php
}
?>