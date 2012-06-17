<?php

/*

Bestdeal - view item part
updated by 2bros 
2011.01.05

*/

$sql_counthits = sed_sql_query("UPDATE sed_bestdeal_item SET bditem_hits=bditem_hits+1 WHERE bditem_id='$id'");
$sql_getitem = sed_sql_query("SELECT * FROM sed_bestdeal_item WHERE bditem_id='$id'");
		
	if(sed_sql_numrows($sql_getitem)==0) {
			header("Location: plug.php?e=bestdeal");
			exit;
	}

$iteminfo = sed_sql_fetcharray($sql_getitem);
	
//Template structure

$path_plugin_path	= "".$cfg['bestdeal_path']."/bestdeal.viewitem.tpl";
$path_skin_path	= "skins/$skin/extplugin.bestdeal.viewitem.tpl";	
		
	if (file_exists($path_plugin_path)) {
						
						$path_skin= $path_plugin_path;
		}
			elseif (file_exists($path_skin_path)) {
			
						$path_skin = $path_skin_path;
			}
				else {
						header("Location: message.php?msg=907");
						exit;
				}	
$t = new XTemplate($path_skin);

//Tags part

//facebook comment
$fb_comment_id = $iteminfo['bditem_id'];
$page_fb_comment = "<fb:comments width=\"770\" xid=\"$fb_comment_id\" url=\"http://www.ridelinemtb.info/plug.php?e=bestdeal&id=$fb_comment_id\" canpost=\"true\" candelete=\"false\" numposts=\"14\" publish_feed=\"true\"></fb:comments>";

	
$contact = ($iteminfo['bditem_mailpm'] == 1) ? "<a href=\"plug.php?e=bestdeal&amp;page=sendmail&amp;id=".$iteminfo['bditem_user']."&amp;pn=".$iteminfo['bditem_id']."\">".$L['bd_contactowner']."</a>" : "<a href=\"pm.php?m=send&to=".$iteminfo['bditem_user']."\">".$L['bd_contactowner']."</a>";
	
if (empty($iteminfo['bditem_photo'])) echo "shit ez üres!";
	
	
$t-> assign(array(

	"VIEW_ITEM_FBCOMMENT" => $page_fb_comment,

	"VIEW_ITEM_CATS" => titelcat(2,$iteminfo['bditem_cat_id']),
	"VIEW_ITEM_USERPANEL" =>userpanel($usr['id']),
	"VIEW_ITEM_ID" => $iteminfo['bditem_id'],
	"VIEW_ITEM_USER" => userinfo($iteminfo['bditem_user']),
	"VIEW_ITEM_NAME" => $iteminfo['bditem_name'],
	"VIEW_ITEM_SHORTDESC" => $iteminfo['bditem_shortdesc'],
	"VIEW_ITEM_STATE" => $iteminfo['bditem_state'],
	"VIEW_ITEM_EDITDATE" => date($cfg['dateformat'],$iteminfo['bditem_editdate'] + $usr['timezone'] * 3600),
	"VIEW_ITEM_ADDDATE" => date($cfg['dateformat'],$iteminfo['bditem_adddate'] + $usr['timezone'] * 3600),
	"VIEW_ITEM_STATE_ENDDATE" => date($cfg['dateformat'],$iteminfo['bditem_state_enddate'] + $usr['timezone'] * 3600),
	"VIEW_ITEM_STARTDATE" => date($cfg['dateformat'],$iteminfo['bditem_startdate'] + $usr['timezone'] * 3600),
	"VIEW_ITEM_ENDDATE" => date($cfg['dateformat'],$iteminfo['bditem_enddate'] + $usr['timezone'] * 3600),
	"VIEW_ITEM_PRICE" => priceinfo($iteminfo['bditem_price'],$iteminfo['bditem_mode'],$iteminfo['bditem_id']),
	"VIEW_ITEM_MODE" => $iteminfo['bditem_mode'],
	"VIEW_ITEM_PHOTO" => "<img src=\"".$iteminfo['bditem_photo']."\" width=\"600px\" alt=\"Kép helye\ />" ,
	
	"VIEW_ITEM_DETAILS" => !empty($iteminfo['bditem_details']) ? sed_parse($iteminfo['bditem_details']) : $L['bd_nodetails'],
	"VIEW_ITEM_HITS" => $iteminfo['bditem_hits'],
	"VIEW_ITEM_LOCATION" => $iteminfo['bditem_location'],
	"VIEW_ITEM_PHONE" => !empty($iteminfo['bditem_phone']) ? $iteminfo['bditem_phone'] : $L['bd_nophone'],
	"VIEW_ITEM_CONTACT" => $usr['auth_write'] ? $contact : $L['bd_logintocontactowner'],
	"VIEW_ITEM_MAILMP" => $iteminfo['bditem_mailpm'],
	"VIEW_ITEM_ACTIONS" => actions($iteminfo['bditem_id'])
	));
	
$bids= bids($iteminfo['bditem_id']);
		if (!empty($bids)) {
							
						$t-> assign(array(
							"VIEW_ITEM_BIDS" => bids($iteminfo['bditem_id']),
							
							//more tags can be add here with the end a ,			
							));
	
	$t->parse("MAIN.VIEW_ITEM_BIDS");
		
		}

?>