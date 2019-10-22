<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="boostrap/css/bootstrap.min.css">
<link rel="stylesheet" href="boostrap/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="boostrap/css/responsive.bootstrap.min.css">


<script src="js/jquery-1.12.3.min.js"></script>
<script src="boostrap/js/bootstrap.min.js"></script>
<script src="boostrap/js/formValidator.js"></script>
<script src="boostrap/js/jquery.dataTables.min.js"></script>
<script src="boostrap/js/dataTables.bootstrap.min.js"></script>
<!--<script src="boostrap/js/dataTables.responsive.min.js"></script>-->
<script type="text/javascript" src="js/jquery.countdownTimer.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

<script type="text/javascript" scr="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" scr="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" scr="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>


<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
<script type="text/javascript">
    ShopifyApp.init({
        apiKey: 'e4a28a39739e90067f60a449b1d326cc',
        shopOrigin: 'https://<?php echo $_GET['shop']; ?>'
    });
</script>
<script type="text/javascript">
    ShopifyApp.ready(function () {
        ShopifyApp.Bar.initialize({
            title: '',
            icon: 'aliceapi/theme_publish/app-icon.png'
        });
    });
</script>
<h1>jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj</h1>
<?php
session_start();
include 'shopify.php';
include 'config.php';


$_SESSION['shop'] = $_GET['shop'];
$str = $_SESSION['shop'];

if ($_POST['shop_name_d']) {
    $str = $_POST['shop_name_d'];
    $_SESSION['shop'] = $_POST['shop_name_d'];
} else {
    $str = $_SESSION['shop'];
}


$select_data_access = "select * from api_store_theme where shop_name='" . $str . "'";
$exe_access = mysqli_query($connection, $select_data_access);
$row_access = mysqli_fetch_array($exe_access);
//echo $row_access['shop_name'];
$sc = new ShopifyClient($row_access['shop_name'], $row_access['token_name'], $api_key, $secret);
$shop_id = $sc->call('GET', '/admin/shop.json', array());
date_default_timezone_set($shop_id['iana_timezone']);
$datee = date('Y-m-d h:i', time());



$themes = $sc->call('GET', '/admin/themes.json', array());


$date_sorting = array();
foreach ($themes as $key => $value) {
    $date_sorting[$value['id']] = $value['updated_at'];
   
}



arsort($date_sorting);


if (isset($_POST['inserttheme'])) {
    $themeids = $_POST['themes'];
    $datetorun = $_POST['datetorun'];
    $themesid = $sc->call('GET', "/admin/themes/" . $themeids . ".json", array());
    $cureentdate = date("Y-m-d") . "T" . date("h:i:s");
    $select_data_access_1 = "select * from theme_switcher";
    $exe_access_1 = mysqli_query($connection, $select_data_access_1);
    $row_access_1 = mysqli_fetch_array($exe_access_1);

    if (!empty($themeids)) {

        $get = mysqli_query($connection, "select * from theme_switcher");
        $ar = array();
        while ($row = mysqli_fetch_assoc($get)) {
            $ar[] = $row['theme_id'];
        }
        if (in_array($themeids, $ar)) {
            $select_data_access_12 = "select * from theme_switcher where theme_id = '" . $themeids . "' ";
            $exe_access_12 = mysqli_query($connection, $select_data_access_12);
            $row_access_12 = mysqli_fetch_array($exe_access_12);

            $update_form = "UPDATE theme_switcher SET  api_id='" . $row_access['id'] . "',theme_name='" . $themesid['name'] . "',theme_role='main',created_at='" . $themesid['created_at'] . "',updated_at='" . $themesid['updated_at'] . "', new_created_at='" . $cureentdate . "', date_for_publish='" . $datetorun . "', status='unpublish' WHERE id='" . $row_access_12['id'] . "'";
            $execute_update = mysqli_query($connection, $update_form);
        } else {
            $insert = "INSERT INTO theme_switcher (api_id,theme_id,theme_name,theme_role,created_at,updated_at,new_created_at,date_for_publish,status) VALUES ('" . $row_access['id'] . "','" . $themeids . "','" . $themesid['name'] . "','main','" . $themesid['created_at'] . "','" . $themesid['updated_at'] . "','" . $cureentdate . "','" . $datetorun . "','unpublish')";
            $ex = mysqli_query($connection, $insert);
        }
    }
}
if (isset($_POST['deletenow'])) {
    $thedelid = $_POST['deleiiid'];

    $del = mysqli_query($connection, "delete from theme_switcher where theme_id = '" . $thedelid . "' ");
}
?>
<style>
    span.js-icon.embedded-app__icon{ 
        background-color: red;
    }



    @media screen and (min-width: 1025px) {
        .container.theme-preview-main-grid {
            background: none;
            border: none;
        }
    }
    label{margin-left: 20px;}
    #datepicker > span:hover{cursor: pointer;}
    .buttonmar
    {
        border-radius: 0px;
        border: 1px solid black;
        height: 51.59px;
    }
    .theme-select{
        height: 38px; 
    }
    .theme-datetime{
        height: 40px; 
    } 
    .container
    {
        margin-top: 50px;
        margin-bottom: 70px;
        background-color: white;
        border: 2px solid #ccc;
    }
    body {
        background-color: #f4f6f8;
    }
    .form-horizontal
    {
        padding: 20px;
    }
    .bootstrap-datetimepicker-widget .picker-switch td span:before
    {
        content: "SetTime";
    }
    .bootstrap-datetimepicker-widget table td.disabled
    {
        background-color: #d9534f;
        color: black;
    }
    .bootstrap-datetimepicker-widget table td.disabled:hover
    {
        background-color: #d9534f;
    }

    ul.customize_link {
        float: right;
        margin: -104px 200px 0 0;
        padding: 0;
        display: inline-block;
        text-align: center;
    }
    .col-sm-offset-12 {
        margin-left: 0;
    }
    ul.customize_link li {
        list-style: none;
        display: inline-block;
        width: 100%;
        float: left;
        clear: both;
        overflow: hidden;
    }
    ul.customize_link li a {
        color: #419B3B;
        font-size: 14px;
        line-height: 34px;
    }	
    .buttonmar {
        border-radius: 0px;
        border: 1px solid black;
        height: 51.59px;
        margin-top: 15px;
    }	
    .form-horizontal .form-group {
        margin-right: -15px;
        margin-left: -15px;
        width: 358px;
        float: none;
        padding: 0;
        clear: both;
        margin: 0 auto;
    }
    .form-horizontal .control-label {
        padding-top: 7px;
        margin-bottom: 0;
        text-align: right;
        width: 50%;
    }


    .table-bordered thead tr th {
        font-size: 12px;
        color: #000000;
        font-family: Helvetica, Neue;
        font-weight: bold;
    }
    .table-bordered tbody tr td {
        font-size: 12px;
        font-family: Helvetica, Neue, Bold;
        color: #000000;
    }
    .table-bordered tbody tr td:nth-child(1) {
        font-size: 11px;
        font-family: Helvetica, Neue;
        color: #000000;
    }

    .table-bordered tbody tr td:nth-child(4) {
        font-size: 11px;
        font-family: Arial;
        color: #000000;
        font-weight: 100;
        text-decoration: underline;
        cursor: pointer;
        text-align: center;
    }
    .table-bordered tbody tr td:nth-child(2) {
        font-size: 11px;
        font-family: Helvetica, Neue;
        color: #000000;
        font-weight: 100;
    }	





    @media screen and (max-width: 728px) { 
        body {
            background-color: #fff;
        }
        .container
        {
            border: none !important;
        }
        .hide_mob{
            display: none;
        }
        .dataTables_paginate
        {
            margin-bottom: 35px !important;
        } 
        .sorting
        {
            width: 50px !important;
        }

div#example_length {
		width: 85%;
		float: none;
		text-align: center;
		padding: 0 !important;
		margin: 0 auto;
    } 
    .theme-title {
        text-align: center;
}

    }

    table.dataTable
    {
        font-size: 11px;
    }
    .loader-gif {
        text-align: center;
        margin: 0 auto;
        top: 50%;
        position: relative;
        display: none;
    }
@media screen and (max-width: 768px) {  
        /*----------narendra-------------*/
        .publish-date-col{
            display:none; 
        }
        div#example_length {
            display: none;
            margin: 0;
        }
        div#example_filter {
            float: right;
        }
        #EmbeddedApp header.header.js-app-header span.js-icon.embedded-app__icon {
            background: #000;
            padding: 8px;
            color: #fff !important;
            margin-right: 10px;
        }
        #EmbeddedApp header.header.js-app-header span.js-icon.embedded-app__icon .next-icon--header {
            fill: #fff;
        }
        .fresh-ui .embedded-app .header__main span.js-name {
            color: #000;
            font-weight: 500;
        }
        .form-horizontal .form-group button.btn.btn-success.btn-block.buttonmar {
            padding: 15px 0;
            border: solid 1px #010201;
        }
        .container {
            margin-top: 0px;
            margin-bottom: 0px;
            background-color: white;
            border: 2px solid #ccc;
            border-bottom: none;
            border-top: none;
        }   
        .text-center {
            text-align: left;
            font-size: 13px !important;
            text-decoration: none !important;
            color: #000;
        }
        h4.text-center u {
            text-decoration: none;
        }
        /*        #example_filter {
                    float: left;
                    margin: 0;
                    padding: 0;
                    width: 100%;
                }
        
                #example_filter label {
                    margin: 0;
                    padding: 0;
                    float: left;
                    width: 100%;
                }   
                #example_filter input.form-control.input-sm {
                    margin: 0 0 0 10px;
                    width: 82%;
                }
                #example_wrapper table#example th.sorting {
                    width: 82px !important;
                    border-bottom: none;
                    color: #000;
                }   
                #example_wrapper table#example tbody tr.odd {
                    background: none;
                    color: #000;
                    font-weight: bold;
                }
                #example_wrapper table#example tbody tr.even {
                    color: #000;
                    font-weight: bold;
                }   
                #example_info {
                    color: #000;
                    font-weight: 600;
                    margin-top: 50px;
                }*/
        div.dataTables_wrapper div.dataTables_paginate ul.pagination a {
            color: #000;
        }
        .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
            z-index: 3;
            color: #fff !important;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }
        table.dataTable thead .sorting:after {
            opacity: 0.6;
            content: "\e150";
        }
        .form-horizontal {
            padding: 10px 0 0 0;
        }

        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
            vertical-align: middle;
        }
        form.form-horizontal .form-group button.btn.btn-success.btn-block.buttonmar {
            background: #419B3B;
            border: solid 1px #000000;
            border-radius: 0;
            padding: 15px 0;
            text-decoration: underline;
            color: #fff !important;
        }
        .theme-preview-main-grid{   
            border: none;        
            margin-left: 13px;
            margin-right: 13px;
            padding: 5px;
        }
        .theme-preview__iframe--desktop{
            transform: scale(0.234483) !important;
        }
        .theme-preview__iframe--mobile{
            transform: scale(0.21) !important;
        }
        .form-horizontal .form-group {
            margin-right: -15px;
            margin-left: -15px;
            width: 500px;
            float: left;
            padding: 0;
        }
        ul.customize_link {
            float: right;
            margin: -45px 0 0 0;
            padding: 0;
            display: inline-block;
            text-align: center;
        }
        ul.customize_link li {
            list-style: none;
            display: inline-block;
            width: 100%;
            float: left;
            clear: both;
            overflow: hidden;
        }
        ul.customize_link li a {
            color: #419B3B;
            font-size: 14px;
            line-height: 40px;
        }
        .form-group:last-child {
            width: 100%;
            padding: 0;
            margin: 0 auto 15px;
        }
        .form-group:last-child .col-sm-offset-12 {
            margin: 0 auto;
            padding: 0;
        }
        .table-bordered {
            border: 1px solid #E2E2E2;
        }
        .table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
            border-top: 0;
            border-bottom: none;
        }
        .table-bordered thead tr th {
            font-size: 9px;
            color: #000000;
            font-family: Helvetica, Neue, Bold;
        }
        .table-bordered tbody tr td {
            font-size: 12px;
            font-family: Helvetica, Neue, Bold;
            color: #000000;
        }
        .table-bordered tbody tr td:nth-child(1) {
            font-size: 9px;
            font-family: Helvetica, Neue;
            color: #000000;
        }

        .table-bordered tbody tr td:nth-child(3) {
            font-size: 12px;
            font-family: Arial;
            color: #000000;
            font-weight: bold;
            /*text-decoration: underline;*/
            cursor: pointer;
        }
        .table-bordered tbody tr td:nth-child(2) {
            font-size: 12px;
            font-family: Helvetica, Neue;
            color: #000000;
            font-weight: 100;
        }
        .form-horizontal .form-group label.control-label {
            width: 100%;
        }

    }



    @media screen and (max-width: 595px) {  
        /*----------narendra-------------*/
        .publish-date-col{
            display:none; 
        }
        div#example_length {
            display: none;
            margin: 0;
        }
        div#example_filter {
            float: right;
        }
        #EmbeddedApp header.header.js-app-header span.js-icon.embedded-app__icon {
            background: #000;
            padding: 8px;
            color: #fff !important;
            margin-right: 10px;
        }
        #EmbeddedApp header.header.js-app-header span.js-icon.embedded-app__icon .next-icon--header {
            fill: #fff;
        }
        .fresh-ui .embedded-app .header__main span.js-name {
            color: #000;
            font-weight: 500;
        }
        .form-horizontal .form-group button.btn.btn-success.btn-block.buttonmar {
            padding: 15px 0;
            border: solid 1px #010201;
        }
        .container {
            margin-top: 0px;
            margin-bottom: 0px;
            background-color: white;
            border: 2px solid #ccc;
            border-bottom: none;
            border-top: none;
        }   
        .text-center {
            text-align: left;
            font-size: 13px !important;
            text-decoration: none !important;
            color: #000;
        }
        h4.text-center u {
            text-decoration: none;
        }
        /*        #example_filter {
                    float: left;
                    margin: 0;
                    padding: 0;
                    width: 100%;
                }
        
                #example_filter label {
                    margin: 0;
                    padding: 0;
                    float: left;
                    width: 100%;
                }   
                #example_filter input.form-control.input-sm {
                    margin: 0 0 0 10px;
                    width: 82%;
                }
                #example_wrapper table#example th.sorting {
                    width: 82px !important;
                    border-bottom: none;
                    color: #000;
                }   
                #example_wrapper table#example tbody tr.odd {
                    background: none;
                    color: #000;
                    font-weight: bold;
                }
                #example_wrapper table#example tbody tr.even {
                    color: #000;
                    font-weight: bold;
                }   
                #example_info {
                    color: #000;
                    font-weight: 600;
                    margin-top: 50px;
                }*/
        div.dataTables_wrapper div.dataTables_paginate ul.pagination a {
            color: #000;
        }
        .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
            z-index: 3;
            color: #fff !important;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }
        table.dataTable thead .sorting:after {
            opacity: 0.6;
            content: "\e150";
        }
        .form-horizontal {
            padding: 10px 0 0 0;
        }

        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
            vertical-align: middle;
        }
        form.form-horizontal .form-group button.btn.btn-success.btn-block.buttonmar {
            background: #419B3B;
            border: solid 1px #000000;
            border-radius: 0;
            padding: 15px 0;
            text-decoration: underline;
            color: #fff !important;
        }
        .theme-preview-main-grid{   
            border: none;        
            margin-left: 13px;
            margin-right: 13px;
            padding: 5px;
        }
        .theme-preview__iframe--desktop{
            transform: scale(0.234483) !important;
        }
        .theme-preview__iframe--mobile{
            transform: scale(0.21) !important;
        }
        .form-horizontal .form-group {
            margin-right: -15px;
            margin-left: -15px;
            width: 320px;
            float: left;
            padding: 0;
        }
        ul.customize_link {
            float: right;
            margin: -45px 0 0 0;
            padding: 0;
            display: inline-block;
            text-align: center;
        }
        ul.customize_link li {
            list-style: none;
            display: inline-block;
            width: 100%;
            float: left;
            clear: both;
            overflow: hidden;
        }
        ul.customize_link li a {
            color: #419B3B;
            font-size: 14px;
            line-height: 40px;
        }
        .form-group:last-child {
            width: 100%;
            padding: 0;
            margin: 0 auto 15px;
        }
        .form-group:last-child .col-sm-offset-12 {
            margin: 0 auto;
            padding: 0;
        }
        .table-bordered {
            border: 1px solid #E2E2E2;
        }
        .table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
            border-top: 0;
            border-bottom: none;
        }
        .table-bordered thead tr th {
            font-size: 9px;
            color: #000000;
            font-family: Helvetica, Neue, Bold;
        }
        .table-bordered tbody tr td {
            font-size: 12px;
            font-family: Helvetica, Neue, Bold;
            color: #000000;
        }
        .table-bordered tbody tr td:nth-child(1) {
            font-size: 9px;
            font-family: Helvetica, Neue;
            color: #000000;
        }

        .table-bordered tbody tr td:nth-child(3) {
            font-size: 12px;
            font-family: Arial;
            color: #000000;
            font-weight: bold;
            /*text-decoration: underline;*/
            cursor: pointer;
        }
        .table-bordered tbody tr td:nth-child(2) {
            font-size: 12px;
            font-family: Helvetica, Neue;
            color: #000000;
            font-weight: 100;
        }
        .form-horizontal .form-group label.control-label {
            width: 100%;
        }

    }



    @media screen and (max-width: 414px) {  
        /*----------narendra-------------*/
        .publish-date-col{
            display:none; 
        }
        div#example_length {
            display: none;
            margin: 0;
        }
        div#example_filter {
            float: right;
        }
        #EmbeddedApp header.header.js-app-header span.js-icon.embedded-app__icon {
            background: #000;
            padding: 8px;
            color: #fff !important;
            margin-right: 10px;
        }
        #EmbeddedApp header.header.js-app-header span.js-icon.embedded-app__icon .next-icon--header {
            fill: #fff;
        }
        .fresh-ui .embedded-app .header__main span.js-name {
            color: #000;
            font-weight: 500;
        }
        .form-horizontal .form-group button.btn.btn-success.btn-block.buttonmar {
            padding: 15px 0;
            border: solid 1px #010201;
        }
        .container {
            margin-top: 0px;
            margin-bottom: 0px;
            background-color: white;
            border: 2px solid #ccc;
            border-bottom: none;
            border-top: none;
        }	
        .text-center {
            text-align: left;
            font-size: 13px !important;
            text-decoration: none !important;
            color: #000;
        }
        h4.text-center u {
            text-decoration: none;
        }
        /*        #example_filter {
                    float: left;
                    margin: 0;
                    padding: 0;
                    width: 100%;
                }
        
                #example_filter label {
                    margin: 0;
                    padding: 0;
                    float: left;
                    width: 100%;
                }	
                #example_filter input.form-control.input-sm {
                    margin: 0 0 0 10px;
                    width: 82%;
                }
                #example_wrapper table#example th.sorting {
                    width: 82px !important;
                    border-bottom: none;
                    color: #000;
                }	
                #example_wrapper table#example tbody tr.odd {
                    background: none;
                    color: #000;
                    font-weight: bold;
                }
                #example_wrapper table#example tbody tr.even {
                    color: #000;
                    font-weight: bold;
                }	
                #example_info {
                    color: #000;
                    font-weight: 600;
                    margin-top: 50px;
                }*/
        div.dataTables_wrapper div.dataTables_paginate ul.pagination a {
            color: #000;
        }
        .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
            z-index: 3;
            color: #fff !important;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }
        table.dataTable thead .sorting:after {
            opacity: 0.6;
            content: "\e150";
        }
        .form-horizontal {
            padding: 10px 0 0 0;
        }

        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
            vertical-align: middle;
        }
        form.form-horizontal .form-group button.btn.btn-success.btn-block.buttonmar {
            background: #419B3B;
            border: solid 1px #000000;
            border-radius: 0;
            padding: 15px 0;
            text-decoration: underline;
            color: #fff !important;
        }
        .theme-preview-main-grid{   
            border: none;        
            margin-left: 13px;
            margin-right: 13px;
            padding: 5px;
        }
        .theme-preview__iframe--desktop{
            transform: scale(0.234483) !important;
        }
        .theme-preview__iframe--mobile{
            transform: scale(0.21) !important;
        }
        .form-horizontal .form-group {
            margin-right: -15px;
            margin-left: -15px;
            width: 269px;
            float: left;
            padding: 0;
        }
        ul.customize_link {
            float: right;
            margin: -45px 0 0 0;
            padding: 0;
            display: inline-block;
            text-align: center;
        }
        ul.customize_link li {
            list-style: none;
            display: inline-block;
            width: 100%;
            float: left;
            clear: both;
            overflow: hidden;
        }
        ul.customize_link li a {
            color: #419B3B;
            font-size: 14px;
            line-height: 40px;
        }
        .form-group:last-child {
            width: 100%;
            padding: 0;
            margin: 0 auto 15px;
        }
        .form-group:last-child .col-sm-offset-12 {
            margin: 0 auto;
            padding: 0;
        }
        .table-bordered {
            border: 1px solid #E2E2E2;
        }
        .table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
            border-top: 0;
            border-bottom: none;
        }
        .table-bordered thead tr th {
            font-size: 9px;
            color: #000000;
            font-family: Helvetica, Neue, Bold;
        }
        .table-bordered tbody tr td {
            font-size: 12px;
            font-family: Helvetica, Neue, Bold;
            color: #000000;
        }
        .table-bordered tbody tr td:nth-child(1) {
            font-size: 9px;
            font-family: Helvetica, Neue;
            color: #000000;
        }

        .table-bordered tbody tr td:nth-child(3) {
            font-size: 12px;
            font-family: Arial;
            color: #000000;
            font-weight: bold;
            /*text-decoration: underline;*/
            cursor: pointer;
        }
        .table-bordered tbody tr td:nth-child(2) {
            font-size: 12px;
            font-family: Helvetica, Neue;
            color: #000000;
            font-weight: 100;
        }
        .form-horizontal .form-group label.control-label {
            width: 100%;
        }

    }	

    @media screen and (max-width: 320px) {  

        div#example_length {
            margin: 0 !important;
            width: 85%;
            float: none;
            text-align: center;
            padding: 0 !important;
        }
        .form-horizontal .form-group {
            margin-right: -15px;
            margin-left: -15px;
            width: 228px;
            float: left;
            padding: 0;
        }
        .form-group:last-child {
            width: 100%;
            padding: 0;
            margin: 0 auto 15px;
        }
    }	


</style>
<div class="container">

    <form class="form-horizontal" action="" method="post">
        <div class="form-group">
            <label class="control-label col-sm-3" style="text-align: left;margin-left: 0px;" for="email">Theme Name:</label>
            <?php $theme_first_id = 0; ?>
            <div class="col-sm-12">
                <select name="themes" class="form-control theme-select">
                    <?php
                    $i = 0;
                    foreach ($date_sorting as $key => $sortingtheme) {
                        $i++;
                        $themesid = $sc->call('GET', "/admin/themes/" . $key . ".json", array());
                        if ($i == 1) {
                            $theme_first_id = $themesid['id'];
                        }
                        ?>
                        <option value="<?php echo $themesid['id']; ?>"><?php echo $themesid['name']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" style="text-align: left;margin-left: 0px;" for="pwd">Select Date & Time:</label>
            <div class="col-sm-12">          
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' name="datetorun" class="form-control theme-datetime" required/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <ul class="customize_link">
            <li><a href="https://<?php echo $str; ?>/admin/themes/<?php echo $theme_first_id; ?>/editor" target="_blank">Customize</a></li>
            <li><a href="https://<?php echo $str; ?>/?fts=0&preview_theme_id=<?php echo $theme_first_id; ?>" target="_blank">Preview</a></li>
            <li><a href="https://<?php echo $str; ?>/admin/themes/<?php echo $theme_first_id; ?>" target="_blank">Edit Code</a></li>
        </ul>

        <div class="form-group">        
            <div class="col-sm-offset-12 col-sm-12">
                <button type="submit" name="inserttheme" class="btn btn-success btn-block buttonmar">Schedule Theme</button>
            </div>
        </div>
    </form>
</div>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

<script type="text/javascript">
    $(function () {

        var date = "<?php echo date('Y-m-d H:i'); ?>";
        $('#datetimepicker1').datetimepicker({
            defaultDate: date,
            useCurrent: true,
            format: 'YYYY-MM-DD hh:mm',
            minDate: date,
            icons: {
                up: "fa fa-plus",
                down: "fa fa-minus"
            }
        });
    });
//     $(document).ready(function () {
//         console.log('call');
//         $('.header__main').html('Test');
//         $('#example').DataTable({
//             responsive: true,
//             "aaSorting": [[2, "desc"]]
//         });

//         $('.theme-select').change(function () {
//             id = $(this).val();
//             html = "<li><a href='https://<?php echo $str; ?>/admin/themes/" + id + "/editor' target='_blank'>Customize</a></li>\n\
//             <li><a href='https://<?php echo $str; ?>/?fts=0&preview_theme_id=" + id + "' target='_blank'>Preview</a></li>\n\
// <li><a href='https://<?php echo $str; ?>/admin/themes/" + id + "' target='_blank'>Edit Code</a></li>";
//             $('.customize_link').html(html);
//             $('.loader-gif').show();
//             $('.desktop-iframe').html('<iframe class="theme-preview__iframe theme-preview__iframe--desktop" src="https://<?php echo $str; ?>/?_ab=0&_fd=0&_sc=1&frame_token=GjWUXQVLC1jVx4rtAdqHYA5_09XR3CFtgS81XDmNevHducg9ydVvc_2e7Ip7K34OsDNouWsL7vIdRcMMoz_gjgbed7l9yrOvsNO0ZSiaoCpYp6veLx8HB_N44G_27dWzM6I8If70cCDHP41C1YE63Q%3D%3D&preview_theme_id=' + id + '" sandbox="allow-scripts" scrolling="no" tabindex="-1" ></iframe>');
//             $('.mobile-iframe').html('<iframe class="theme-preview__iframe theme-preview__iframe--mobile" src="https://<?php echo $str; ?>/?_ab=0&_fd=0&_sc=1&frame_token=GjWUXQVLC1jVx4rtAdqHYA5_09XR3CFtgS81XDmNevHducg9ydVvc_2e7Ip7K34OsDNouWsL7vIdRcMMoz_gjgbed7l9yrOvsNO0ZSiaoCpYp6veLx8HB_N44G_27dWzM6I8If70cCDHP41C1YE63Q%3D%3D&preview_theme_id=' + id + '" sandbox="allow-scripts" scrolling="no" tabindex="-1"></iframe>');
//             setTimeout(function () {
//                 $('.loader-gif').hide();
//             }, 3000);
//         });
//     });
</script>



<!-- <div class="container theme-preview-main-grid" style="position: relative;">  
    <div class="con1">
        <div class="ui-card__section ui-section--theme-previews" data-bind="themesIndex.scaleFrames()"><div class="ui-type-container">
                <div class="theme-preview">
                    <img alt="" class="theme-preview__desktop-frame" src="images/desktop_frame.png">
                    <div class="theme-preview__overlay">
                        <img alt="" class="desktop-gif-loader loader-gif" src="images/ajax-loader.gif">
                        <div class="desktop-iframe">
                            <iframe class="theme-preview__iframe theme-preview__iframe--desktop" src="https://<?php echo $str; ?>/?_ab=0&_fd=0&_sc=1&frame_token=GjWUXQVLC1jVx4rtAdqHYA5_09XR3CFtgS81XDmNevHducg9ydVvc_2e7Ip7K34OsDNouWsL7vIdRcMMoz_gjgbed7l9yrOvsNO0ZSiaoCpYp6veLx8HB_N44G_27dWzM6I8If70cCDHP41C1YE63Q%3D%3D&preview_theme_id=<?php echo $theme_first_id; ?>" frame-src="self" connect-src='self' default-src='self' frame-ancestors='none' script-src='unsafe-inline'z scrolling="no" tabindex="-1" ></iframe>
                        </div>
                    </div>
                </div>
                <div class="theme-preview--mobile ">
                    <img alt="" class="theme-preview__desktop-frame" src="images/mobile_frame.png">
                    <div class="theme-preview__overlay theme-preview__overlay--mobile">
                        <img alt="" class="mobile-gif-loader loader-gif" src="images/ajax-loader.gif">
                        <div class="mobile-iframe">
                            <iframe class="theme-preview__iframe theme-preview__iframe--mobile" src="https://<?php echo $str; ?>/?_ab=0&_fd=0&_sc=1&frame_token=GjWUXQVLC1jVx4rtAdqHYA5_09XR3CFtgS81XDmNevHducg9ydVvc_2e7Ip7K34OsDNouWsL7vIdRcMMoz_gjgbed7l9yrOvsNO0ZSiaoCpYp6veLx8HB_N44G_27dWzM6I8If70cCDHP41C1YE63Q%3D%3D&preview_theme_id=<?php echo $theme_first_id; ?>" sandbox="allow-scripts" scrolling="no" tabindex="-1"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->



<div class="container" style="margin-bottom: 0px;">      

    <style>
        .theme-preview {
            position: relative;
            /* margin-bottom: -2rem;*/
            width: 85%;
        }
        img {
            display: block;
            max-width: 100%;
        }
        .theme-preview__overlay {
            background: #ffffff;
            position: absolute;
            border-radius: 3px 3px 0 0;
            overflow: hidden;
            bottom: 0;
            top: 5.19931%;
            left: 3.32594%;
            right: 3.32594%;
        }
        .theme-preview--mobile {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 25%;
        }
        .ui-type-container>*:not(.hide)+* {
            margin-top: 1.6rem;
        }
        .theme-preview__iframe--desktop {
            width: 1160px;
            height: 793px;
            transform: scale(0.699138);
        }
        .theme-preview__overlay--mobile {
            top: 11.46789%;
            left: 5%;
            right: 5%;
        }
        .theme-preview__overlay {
            background: #ffffff;
            position: absolute;
            border-radius: 3px 3px 0 0;
            overflow: hidden;
            bottom: 0;
        }           
        .theme-preview__iframe--mobile {
            width: 350px;
            height: 605px;
            transform: scale(0.619997);
        }
        .theme-preview__iframe {
            border: 0;
            pointer-events: none;
            position: absolute;
            transform-origin: top left;
            bottom: 0;
            top: 0;
            left: 0;
            right: 0;
            border-top-right-radius: 8px;
            border-top-left-radius: 8px;

        }
        .theme-title{
            font-size: 13px;
            font-weight: 800;
            padding: 15px 0 5px 0;
            font-family: Arial;
            margin: 0;
            margin-bottom: 10px;
        }
        @media screen and (max-width: 414px){

        	.sub1 a
	{
		position: absolute !important;
	    margin-top: -85px !important;
	    margin-left: -5px !important;
	    width: auto !important;
	}
	.sub2 a
	{
		position: absolute !important;
	    margin-top: -85px !important;
	    margin-left: -75px !important;
	    width: auto !important;
	}
.theme-title {

    text-align: center;
}
		}
    </style>
    <script type="text/javascript">
    $(document).ready(function() {
    $('#example').DataTable( {
        "info":     false,
        language: {
    paginate: {
      next: '', // or '→'
      previous: '' // or '←' 
    }
  }
    } );
} );
    </script>
    <h4 class="theme-title">Theme Schedule</h4>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Theme name</th>
                <th class="publish-date-col">Publish Date</th>
                <th>Action/Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rr = 0;
            $idsd = $row_access['id'];
            $get = mysqli_query($connection, "select * from theme_switcher where api_id =  '" . $idsd . "' order by date_for_publish desc");
            while ($row = mysqli_fetch_assoc($get)) {
                $to_time = strtotime(date('Y-m-d H:i'));
                $from_time = strtotime($row['date_for_publish']);
                $diff[] = $from_time - $to_time;
                $tes[] = $row['date_for_publish'];
                ?>
                <tr>
                    <td><?php echo $row['theme_id']; ?></td>
                    <td><?php echo $row['theme_name']; ?></td>
                    <td class="publish-date-col"><?php echo $row['date_for_publish']; ?></td>
                    <td>
                        <?php
                        if ($row['status'] == "published") {
                            ?>
                            <a href="cancel.php?shop=<?php echo $str; ?>&id=<?php echo $row['theme_id']; ?>&status=Launched" style="color: green;">Launched</a>
                            <?php
                        } else if ($row['status'] == "Cancelled") {
                            ?>
                            <a href="cancel.php?shop=<?php echo $str; ?>&id=<?php echo $row['theme_id']; ?>&status=cancelled" style="color: black;">Cancelled</a>
                            <?php
                        } else {
                            ?>
                            <a href="cancel.php?shop=<?php echo $str; ?>&id=<?php echo $row['theme_id']; ?>&status=cancel" style="color: red;">Cancel</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php
                $rr ++;
            }
            ?>
        </tbody>
    </table>
</div>

<div class="container" style="background-color: transparent;border: none;margin-top: 20px;margin-bottom: 20px;">
	<div class="main">
		<div class="sub1">
			<a onclick="return clear_launcher(<?php echo $row_access['id']; ?>);" style="color: black;text-decoration: underline;cursor: pointer;">Clear Launched</a>
<br>
            <a onclick="return clear_all(<?php echo $row_access['id']; ?>);" style="color: black;text-decoration: underline;cursor: pointer;">Clear All</a>
		</div>
		<div class="sub2">
			<a href="#" style="color: black;text-decoration: underline;">Get Support</a>
		</div>
	</div>
</div>

<script type="text/javascript">
    function clear_launcher(id)
    {

        $.ajax({ 
        type: "POST",
        url: "https://aws.sprbot.com/aliceapi/theme_publish/ajax_launcher.php",
        data: {id:id},
        success: function(data){
         location.reload();
        }    
  });  

    }
    function clear_all(id)
    {

        $.ajax({ 
        type: "POST",
        url: "https://aws.sprbot.com/aliceapi/theme_publish/ajax_all.php",
        data: {id:id},
        success: function(data){
        location.reload();
        }    
  });  

    }
</script>
<style type="text/css">
	.main
	{
		width: 100%;
	}
	.sub1
	{
		width: 50%;
		float: left;
	}
	.sub2
	{
		width: 50%;
		float: right;
		text-align: right;
	}
	.sub1 a
	{
		position: relative;
    margin-left: 0;
    width: auto;
	}
	.sub2 a
	{
		position: relative;
    margin-top: 0;
    margin-left: 0;
    width: auto;
	}
</style>
<?php
if (isset($_POST['publishnow'])) {
    $ttt = $_POST['iiid'];
    $get1 = mysqli_query($connection, "select * from theme_switcher where theme_id = '" . $ttt . "' ");



    while ($row1 = mysqli_fetch_assoc($get1)) {
        try {
            $pusbished = array("id" => $row1['theme_id'], "role" => $row1['theme_role']);
            $publish = $sc->call('PUT', "/admin/themes/" . $row1['theme_id'] . ".json", array("theme" => $pusbished));

            mysqli_query($connection, "update theme_switcher set status='published' where id = '" . $row1['id'] . "' ");
        } catch (ShopifyApiException $e) {
            echo $e;
        } catch (ShopifyCurlException $e) {
            echo $e;
        }
    }
}
?>
<?php
$testss = count($tes);
?>
<script>
    $(function () {
        var yj = "<?php echo $testss; ?>";
        var cdate = "<?php echo $datee; ?>";
        var js_arrayy = [<?php echo '"' . implode('","', $tes) . '"' ?>];
        for (i = 0; i < yj; i++)
        {
            $('#given_date-' + i).countdowntimer({
                startDate: cdate,
                dateAndTime: js_arrayy[i],
                size: "lg"
            });
        }
    });
</script>
