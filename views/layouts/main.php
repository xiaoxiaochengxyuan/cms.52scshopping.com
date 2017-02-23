<?php
use app\widgets\NavWidget;
use app\daos\CmsAdmin;
$controllerId = $this->context->id;
$actionId = $this->context->action->id;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?=$this->title?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- basic styles -->
		<link href="<?=ACE_STATIC_CSS_URL?>/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/font-awesome.min.css" />
		<link rel="stylesheet" href="<?=CMS_STATIC_CSS_URL?>/style.css" />
		
		<!--[if IE 7]>
			<link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/font-awesome-ie7.min.css" />
		<![endif]-->
		
		<!-- ace styles -->
		<link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/ace.min.css" />
		<link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/ace-rtl.min.css" />
		<link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/ace-skins.min.css" />

		<!--[if lte IE 8]>
			<link rel="stylesheet" href="<?=ACE_STATIC_CSS_URL?>/ace-ie.min.css" />
		<![endif]-->

		<script src="<?=ACE_STATIC_JS_URL?>/ace-extra.min.js"></script>

		<!--[if lt IE 9]>
			<script src="<?=ACE_STATIC_JS_URL?>/html5shiv.js"></script>
			<script src="<?=ACE_STATIC_JS_URL?>/respond.min.js"></script>
		<![endif]-->
		
		<script src="<?=ACE_STATIC_JS_URL?>/jquery-1.10.2.min.js"></script>
	</head>

	<body>
		<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-leaf"></i>&nbsp;<?=Yii::$app->name?>
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?=ACE_STATIC_AVATOR_URL?>/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>欢迎光临,</small> <?=CmsAdmin::loginInfo('username')?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="<?=Yii::$app->urlManager->createUrl('/cms-admin/chg-my-passwd')?>">
										<i class="icon-cog"></i> 修改密码
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?=Yii::$app->urlManager->createUrl('/login/logout')?>">
										<i class="icon-off"></i>
										退出
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>
			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>
				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>
					<div class="sidebar-shortcuts" id="sidebar-shortcuts">
						<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
							<button class="btn btn-success">
								<i class="icon-signal"></i>
							</button>
							<button class="btn btn-info">
								<i class="icon-pencil"></i>
							</button>
							<button class="btn btn-warning">
								<i class="icon-group"></i>
							</button>
							<button class="btn btn-danger">
								<i class="icon-cogs"></i>
							</button>
						</div>
						<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
							<span class="btn btn-success"></span>

							<span class="btn btn-info"></span>

							<span class="btn btn-warning"></span>

							<span class="btn btn-danger"></span>
						</div>
					</div>
					<?=NavWidget::widget(['controllerId' => $controllerId, 'actionId' => $actionId])?>
					
					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>

				<div class="main-content"><?=$content?></div>
			</div>

			<a href="javascript:void(0)" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?=ACE_STATIC_JS_URL?>/jquery.mobile.custom.min.js'>"+"<"+"script>");
		</script>
		<script src="<?=ACE_STATIC_JS_URL?>/bootstrap.min.js"></script>
		<script src="<?=ACE_STATIC_JS_URL?>/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?=ACE_STATIC_JS_URL?>/excanvas.min.js"></script>
		<![endif]-->

		<script src="<?=ACE_STATIC_JS_URL?>/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="<?=ACE_STATIC_JS_URL?>/jquery.ui.touch-punch.min.js"></script>
		<script src="<?=ACE_STATIC_JS_URL?>/jquery.slimscroll.min.js"></script>

		<!-- ace scripts -->

		<script src="<?=ACE_STATIC_JS_URL?>/ace-elements.min.js"></script>
		<script src="<?=ACE_STATIC_JS_URL?>/ace.min.js"></script>
	</body>
</html>