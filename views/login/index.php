<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>登录页面 - <?=Yii::$app->name?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- basic styles -->
        <link href="<?=ACE_STATIC_CSS_URL?>/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/font-awesome.min.css" />
        
        <!--[if IE 7]>
          <link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/font-awesome-ie7.min.css" />
        <![endif]-->
        
        <link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/ace.min.css" />
        <link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/ace-rtl.min.css" />

        <!--[if lte IE 8]>
            <link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/ace-ie.min.css" />
        <![endif]-->
        <style type="text/css">
        #vimg:hover{
            cursor: pointer;
        }
        span.error {
            background: #CA5952;
            padding: 2px 7px;
            color : white;
        }
        </style>
        
        <script type="text/javascript" src="<?=ACE_STATIC_JS_URL?>/jquery-1.10.2.min.js"></script>
        <script type="text/javascript">
        function changeVerify() {
            var date = new Date();
            $("#vimg").attr("src", "<?=Yii::$app->urlManager->createUrl(['common/verify', 'len' => 5, 'iw' => 290, 'ih' => 36])?>&ts=" + date.getTime());
        }
        </script>
    </head>
    <body class="login-layout">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h1>
                                    <i class="icon-leaf green"></i>
                                    <span class="red">欢迎</span>
                                    <span class="white">登录</span>
                                </h1>
                                <h4 class="blue">&copy; SCSHOPPING</h4>
                            </div>
                            <div class="space-6"></div>
                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger">
                                                <i class="icon-coffee green"></i> 请输入您信息
                                            </h4>

                                            <div class="space-6"></div>
                                            
                                            <?php $form = ActiveForm::begin()?>
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?=Html::textInput('CmsAdminForm[username]', $cmsAdminForm->username, ['placeholder' => '用户名', 'class' => 'form-control'])?>
                                                            <i class="icon-user"></i>
                                                        </span>
                                                    </label>
                                                    <?php if ($cmsAdminForm->hasErrors('username')):?>
                                                        <label class="block clearfix">
                                                            <span class="block error"><?=Html::error($cmsAdminForm, 'username')?></span>
                                                        </label>
                                                    <?php endif;?>
                                                    
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?=Html::passwordInput('CmsAdminForm[password]', $cmsAdminForm->password, ['placeholder' => '密码', 'class' => 'form-control'])?>
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>
                                                    <?php if ($cmsAdminForm->hasErrors('password')):?>
                                                        <label class="block clearfix">
                                                            <span class="block error"><?=Html::error($cmsAdminForm, 'password')?></span>
                                                        </label>
                                                    <?php endif;?>
                                                    
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <?=Html::textInput('CmsAdminForm[verifyCode]', $cmsAdminForm->verifyCode, ['placeholder' => '验证码', 'class' => 'form-control'])?>
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>
                                                    <?php if ($cmsAdminForm->hasErrors('verifyCode')):?>
                                                        <label class="block clearfix">
                                                            <span class="block error"><?=Html::error($cmsAdminForm, 'verifyCode')?></span>
                                                        </label>
                                                    <?php endif;?>
                                                    <label class="block clearfix">
                                                        <img onclick="changeVerify();" id="vimg" alt="验证码,点击刷新" src="<?=Yii::$app->urlManager->createUrl(['common/verify', 'len' => 5, 'iw' => 290, 'ih' => 36])?>">
                                                    </label>
                                                    <div class="space"></div>

                                                    <div class="clearfix">
                                                        <button type="submit" class="btn-block btn btn-sm btn-primary">
                                                            <i class="icon-key"></i> 登录
                                                        </button>
                                                    </div>
                                                    <div class="space-4"></div>
                                                </fieldset>
                                            <?php ActiveForm::end()?>
                                        </div><!-- /widget-main -->

                                        <div class="toolbar clearfix">&nbsp;</div>
                                    </div><!-- /widget-body -->
                                </div><!-- /login-box -->
                            </div>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div>
    </body>
</html>
