<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>

<?php
session_start();
include 'shopify.php';
include 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('SHOPIFY_API_KEY', 'e4a28a39739e90067f60a449b1d326cc');
define('SHOPIFY_SECRET', '36b608ebdfade5b7ff0add596642034c');









/* Define requested scope (access rights) - checkout https://docs.shopify.com/api/authentication/oauth#scopes   */
define('SHOPIFY_SCOPE', 'read_content,write_content,read_customers,write_customers,read_shipping,write_shipping,read_orders,write_orders,write_products,read_products,read_themes,write_themes'); //eg: define('SHOPIFY_SCOPE','read_orders,write_orders');

if (isset($_GET['code'])) { // if the code param has been sent to this page... we are in Step 2
    // Step 2: do a form POST to get the access token
    $shopifyClient = new ShopifyClient($_GET['shop'], "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
    session_unset();

    // Now, request the token and store it in your session.
    $_SESSION['token'] = $shopifyClient->getAccessToken($_GET['code']);
    if ($_SESSION['token'] != '')
        $_SESSION['shop'] = $_GET['shop'];
    $shop = isset($_POST['shop']) ? $_POST['shop'] : $_GET['shop'];
    //header("Location: http://".$shop."/admin/app");

    $db_token = $_SESSION['token'];
    $db_shop = $_SESSION['shop'];
    $select_store = "select * from api_store_theme where shop_name='" . $db_shop . "' ";
    $db_select_store = mysqli_query($connection,$select_store) or die(mysqli_error());
    $row_shop = mysqli_fetch_array($db_select_store);
    if (mysqli_num_rows($db_select_store) > 0) {
        $update_shop = "update api_store_theme set token_name='" . $db_token . "',status='1',update_date='" . date('Y-m-d H:i:s') . "' where id='" . $row_shop['id'] . "'";
        $ex = mysqli_query($connection,$update_shop) or die(mysqli_error());
    } else {
        $ins_db = "INSERT INTO api_store_theme (shop_name,token_name,status,installed_date) VALUES ('" . $db_shop . "','" . $db_token . "','1','" . date('Y-m-d H:i:s') . "')";
        $ex = mysqli_query($connection,$ins_db);
    }

    header("Location: http://" . $shop . "/admin/apps");
    exit;
}
// if they posted the form with the shop name
else if (isset($_POST['shop'])) {


    // Step 1: get the shopname from the user and redirect the user to the
    // shopify authorization page where they can choose to authorize this app
    $shop = isset($_POST['shop']) ? $_POST['shop'] : $_GET['shop'];
    $shopifyClient = new ShopifyClient($shop, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);

    // get the URL to the current page
    $pageURL = 'https';
//    if ($_SERVER["HTTPS"] == "on") {
//        $pageURL .= "s";
//    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["SCRIPT_NAME"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["SCRIPT_NAME"];
    }

    // redirect to authorize url
    header("Location: " . $shopifyClient->getAuthorizeUrl(SHOPIFY_SCOPE, $pageURL));
    exit;
}

// first time to the page, show the form below
?>

 <style>
    .panel-default{
        top: 18%;
        position: relative;
        width:50%;
        margin:0 auto;
    }
    .form-horizontal{

        padding: 75px;
    }
    .text-danger{
        font-size: 14px;
        font-weight: 600;        
    }
    .panel-default>.panel-heading{
        font-size: 16px;
        font-weight: 600;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">Install Theme Schedule Switcher App</div>
    <div class="panel-body">
        <form action="" method="post" class="form-horizontal" id="install_form">

            <div class="form-group">
                <label for='shop'><strong>The URL of the Shop</strong> 
                </label> 
            </div>
            <div class="form-group">
                <input id="shop"  id="shop" name="shop" size="45" type="text" class="form-control" value="" /> 
                <p class="text-danger">(enter it exactly like this: myshop.myshopify.com)</p> 
            </div>
            <div class="form-group">
                <input name="commit"  type="submit" value="Install" class="btn btn-success"/> 
            </div>
        </form></div>
</div>
<script>
    $(document).ready(function () {
        $('#install_form').bootstrapValidator({
            container: '#messages',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                shop: {
                    validators: {
                        notEmpty: {
                            message: 'The shop URL is required and cannot be empty'
                        },
                        regexp: {
                            regexp: /\.(myshopify.com)$/i,
                            message: 'The shop URL end with this format myshop.myshopify.com'
                        }
                    }
                }
            }
        });
    });
</script>