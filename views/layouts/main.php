<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <link rel="icon" href="/favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&subset=cyrillic-ext,latin" rel="stylesheet" type="text/css" />

</head>
<body>

<?php $this->beginBody() ?>
    <div class="header">
        <div class="head">
            
            <div class="top-href-block">
                <?= Html::a('Главная', ['/'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('Новости', ['/news'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('Документы', ['/doc'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('О нас', ['/site/about'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('Контакты', ['site/contact'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('Дневник', ['/diary'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('Игроки', ['/profile'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('Штрафы', ['/disq'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('Команды', ['/team'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('Турниры', ['/turnir'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('Игры', ['/game'], ['class' => 'top-menu-href']) ?>
                <?= Html::a('Поля', ['/field'], ['class' => 'top-menu-href']) ?>
            </div>
        </div>

    </div>
    <div class="menu">
                <div class="content">
                    
                    <?= Yii::$app->user->isGuest ?
                            Html::a('Войти', ['/site/login'], ['class' => 'right']) :
                            Html::a(
                                'Выйти (' . Yii::$app->user->identity->username . ')', 
                                ['/site/logout'],
                                ['data-method' => 'post','class' => 'right']) 
                    ?>
                    <?= Yii::$app->user->isGuest ?
                            Html::a('Регистрация', ['/site/signup'], ['class' => 'right']) : false ?>
                    <?= Yii::$app->user->isGuest ?
                            false : Html::a('Профиль', ['/profile/' . Yii::$app->user->identity->profile_id], ['class' => 'right']) ?>
                    <?= Yii::$app->user->can('task') ? 
                            Html::a('Задачи', ['/task/all'], ['class' => 'right']) :
                            false; ?>
                    <?= Yii::$app->user->can('admin') ? 
                            Html::a('Судьи', ['/referee'], ['class' => 'right']) :
                            false; ?>
                    <?= Yii::$app->user->can('admin') ? 
                            Html::a('Права', ['/auth-assignment'], ['class' => 'right']) :
                            false; ?>
                            
                </div>
            </div>
    <div><a id="top"></a></div>
    <div><a href="#top" class="idTop">ВВЕРХ</a></div>
    <div class="wrap">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; ВЛДФ <?= date('Y') ?></p>
            <p class="pull-right">
            <a target="_top" href="http://top.mail.ru/jump?from=1794029">
            <img src="http://df.c5.bb.a1.top.mail.ru/counter?id=1794029;t=138" 
            border="0" height="40" width="88" alt="@Mail.ru" /></a>
            <!--// Rating@Mail.ru counter-->
            </p>
            
        </div>
    </footer>


<!-- Yandex.Metrika counter -->
            <script type="text/javascript">
            (function (d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter21815401 = new Ya.Metrika({id:21815401,
                                clickmap:true,
                                trackLinks:true,
                                accurateTrackBounce:true});
                    } catch(e) { }
                });
            
                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                s.type = "text/javascript";
                s.async = true;
                s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";
            
                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window, "yandex_metrika_callbacks");
            </script>
            <noscript><div><img src="//mc.yandex.ru/watch/21815401" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
            <!-- /Yandex.Metrika counter -->
            
            
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
