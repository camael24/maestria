<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Maestria</title>
    <link href='http://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/maestria.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8"/>
</head>
<body>
<header>
    Evaluation multicritère graphisée
    <?php if (isset($userIsLogin) and $userIsLogin === true) { ?>
        <div id="logzone">
            <?php
            /**
             * @var $user \Application\Entities\User
             */

            ?>
            <div class="login"><?php echo $user->getRealName(); ?></div>
            <div class="logout"><a href="<?php echo $this->route->unroute('mainlogout'); ?>">DECONNEXION</a></div>
        </div>
    <?php } else { ?>
        <div id="logzone">
            <div class="logout"><a href="<?php echo $this->route->unroute('mainlogin'); ?>">CONNEXION</a></div>
        </div>
    <?php } ?>
</header>
<nav>
    <a href="/" class="logo"><img src="/img/maestria.jpg" alt="logo maestria"/></a>

    <h3><a href="<?php echo $this->route->unroute('indexUiaClassroom'); ?>">CLASSES</a></h3>

    <h3 class="synthese"><a href="synthese.html">SYNTHESE</a></h3>
    <br/>

    <h3><a href="/evaluation/">EVALUATIONS</a></h3>

    <h3 id="evalchx" class="eval">PUISSANCE</h3>

    <div class="flechebas"></div>
    <h3 class="eval"><a href="/">CORRECTION</a></h3>

    <?php if (isset($user) === true && $user->getIsAdmin() === true) { ?>
        <br/>
        <h3><a href="<?php echo $this->route->unroute('indexUiaItem'); ?>">ITEMS PEDA</a></h3>

    <?php } ?>

    <!--    <footer>
            <a href="http://metaphysik.fr/manuel/projet.php#contact">Contact</a>|
            <a href="metaphysik.fr">Metaphysik</a>
        </footer>-->
</nav>
<?php $this->block('popup'); ?>
<section id="popup">
    <section id="inpopup">

    </section>
</section>
<?php $this->endBlock() ?>
<?php $this->block('container'); ?>
<?php $this->endBlock() ?>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="/js/maestria.js"></script>
<script src="/js/interaction.js?doo=d"></script>
<?php $this->block('js:script'); ?>
<?php $this->endBlock(); ?>
</body>
</html>