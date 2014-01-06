<?

include "functions_general.php";
ob_start();
header('Content-Type: text/html; charset=UTF-8');
$postbackurl = array();
$script_url = str_replace ('http://','',  str_replace ('/track-show/postback_link.php', '/track/postback.php', full_url()));
$default_params = "?t=[TYPE]&a=[AMOUNT]&c=[CURRENCY]&s=[SUBID]";
$postbackurls['default'] = array('url' => _e($script_url.$default_params), 'vars' => '  [TYPE] &mdash; sale или lead<br />
  [AMOUNT] &mdash; доход от продажи<br />
  [CURRENCY] &mdash; usd или rub<br />
  [SUBID] &mdash; значение SubID<br />');

$postbackurls['actionads.ru'] = array('url' => _e($script_url."?t=sale&a={payout}&c=rub&s={aff_sub}"), 'vars' =>'
  {payout} &mdash; доход от продажи<br />
  {aff_sub} &mdash; значение SubID<br />');


$postbackurls['primelead.com.ua'] = array('url' => _e($script_url."?t=sale&a={payout}&c={currency}&s={aff_sub}"), 'vars' =>'
  {payout} &mdash; доход от продажи<br />
  {currency} &mdash; валюта выплат<br />
  {aff_sub} &mdash; значение SubID<br />');

$postbackurls['adwad.ru'] = array('url' => _e($script_url."?t=sale&a={payout}&c={currency}&s={aff_sub}"), 'vars' =>'
  {payout} &mdash; доход от продажи<br />
  {currency} &mdash; валюта выплат<br />
  {aff_sub} &mdash; значение SubID<br />');

$postbackurls['actionpay.ru'] = array('url' => _e($script_url."?t=sale&a={payout}&c=rub&s={aff_sub}"), 'vars' =>'
  {payment} &mdash; доход от продажи<br />
  {subaccount} &mdash; значение SubID<br />');

echo json_encode($postbackurls[$_REQUEST['network']]);
exit();
?>

