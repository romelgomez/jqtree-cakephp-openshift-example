<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Jqtree CakePHP Example</title>

    <!-- Bootstrap -->
<!--    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
    <link rel="stylesheet" type="text/css" href="/resources/library-vendor/bootstrap/css/bootstrap.css">

    <!-- font-awesome -->
<!--    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">-->
    <link rel="stylesheet" href="/resources/library-vendor/font-awesome/css/font-awesome.min.css">

    <!-- pnotify https://github.com/sciactive/pnotify -->
<!--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/2.0.0/pnotify.core.min.css">-->
    <link rel="stylesheet" type="text/css" href="/resources/library-vendor/pnotify/pnotify.custom.min.css">

    <!-- http://mbraak.github.io/jqTree/ -->
    <link rel="stylesheet" type="text/css" href="/resources/library-vendor/jqtree/jqtree.css">

    <?php
        echo $this->Html->css(array('base'));
        echo $this->fetch('css');
    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>



    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <a href="https://github.com/romelgomez/jqtree-cakephp-openshift-example"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/e7bbb0521b397edbd5fe43e7f760759336b5e05f/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f677265656e5f3030373230302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png"></a>
        <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Jqtree CakePHP Example</a>
            </div>
    </div>

    <div class="main-container">
        <?php echo $this->fetch('content'); ?>
    </div>



    <!-- footer -->
    <div id="footer" style="margin-bottom: 20px">

        <div style="text-align: center;">
            MIT License
        </div>

    </div>


    <!-- Debug
    ===================== -->
    <div style="padding: 10px;margin: 10px;border: 1px solid black;border-radius: 4px;">
        <h2 style="margin-top: 0;" >Debug:</h2>

        <h5>Ajax Request responseText:</h5>
        <div id="debug"></div>

        <?php
        echo '<h5>Sql Dump:</h5>';
        echo $this->element('sql_dump');

        echo '<h5>Ubicación:</h5>';

        if(isset($controller) && isset($action)){
            echo 'Controller: '.$controller.'Controller.php'.'<br />';
            echo 'Action: '.$action;
        }

        ?>
    </div>





    <!-- jQuery - https://github.com/jquery/jquery -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <script type="text/javascript" src="/resources/library-vendor/jquery/jquery-1.11.1.js" ></script>

    <!-- https://github.com/carhartl/jquery-cookie -->
    <script type="text/javascript" src="/resources/library-vendor/jquery-cookie/jquery.cookie.js" ></script>

    <!-- http://mbraak.github.io/jqTree/ -->
    <script type="text/javascript" src="/resources/library-vendor/jqtree/tree.jquery.js" ></script>

    <!-- Bootstrap - https://github.com/twbs/bootstrap -->
<!--    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
    <script type="text/javascript" src="/resources/library-vendor/bootstrap/js/bootstrap.js" ></script>

    <!-- pnotify https://github.com/sciactive/pnotify -->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/2.0.0/pnotify.core.min.js"></script>-->
    <script type="text/javascript" src="/resources/library-vendor/pnotify/pnotify.custom.min.js" ></script>


    <!-- jQuery Validation Plugin - https://github.com/jzaefferer/jquery-validation -->
<!--    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>-->
<!--    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js"></script>-->
    <script type="text/javascript" src="/resources/library-vendor/jquery-validate/jquery.validate.js" ></script>
    <script type="text/javascript" src="/resources/library-vendor/jquery-validate/additional-methods.js" ></script>

    <!-- Purl - https://github.com/allmarkedup/purl -->
<!--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/purl/2.3.1/purl.min.js"></script>-->
<!--    <script type="text/javascript" src="/resources/library-vendor/purl/purl.js" ></script>-->


    <?php
        echo $this->Html->script(array('base'));
    ?>

    <?php echo $this->fetch('script'); ?>

</body>
</html>