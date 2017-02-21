<?php
//error_reporting(E_ALL & ~E_NOTICE &~E_WARNING);
ini_set('display_errors', 1);
//define('WEBEEZ_LIB' , 'D:/work/www/yii/yiimodel/branches/dev');
define('WEBEEZ_LIB', '/vagrant/yiimodel');
define('GA_LOCAL_DISPLAY','on');
define('POINTS_AUTO_EXPIRES','');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'charset' => 'UTF-8',
    'preload' => array(),
    'import' => array(
        'application.controllers.SimpleController',
        'application.controllers.BaseController',
        'webeez.classes.ChineseTrans',
        'webeez.extensions.DomainListener',
        'application.widgets.BaseWidget',
        'webeez.classes.NumericFaker',
    ),
    'defaultController' => 'site',
    'modules' => array(),
    'components' => array(
        'rest' => [
            'class' => 'webeez.extensions.RestClient',
            'domain' => [ // 服务名称 to 服务域名
                    'activity_product' => 'http://alan.activity.product.services.com/',
                    'price_policy' => 'http://alan.price.policy.services.com/',
                    'price_product' => 'http://price.tff.com/',
                    'user_center'   => "http://usersvcs.tff.com/",
                    // 'order_services' => "http://alan.ordersvcs.dev3.tff.com",
                    'order_services' => "http://ordersvcs.dev1.tff.com",
                    'finance_services' => "http://finance.services.tff.com/",
                    'resource_services' => "http://alan.resource.services.com",
                    // 'search_services'   => "http://search.services.tff.com/",
                    'search_services'   => "http://search-services.dev3.tff.com/",
                    'all_product' => 'http://alan.all_product_services.com/',
                    'event_services' => 'http://onegou.com/',
                    ],
            'interface' => [ // 服务名称 to 接口名称 to 接口uri
                'activity_product' => [
                    'get' => '{id}',
                    'upgrades' => '/{id}/upgrades', //获取产品的升级项
                    'price' => '/{id}/availabilities/price?date={date}', //获取产品的价格
                    'ownex' => '/{id}/ownexpense?language_id={language_id}', //获取特定产品的自费项目
                    'baseprice' => '/{id}/availabilities/base_price',
                    'fuckid' => '/fuckid/{is_new}/{id}', //获取新老id对应关系
                    'media' => '/{id}/media',
                    'departures' => '/{id}/departures',
                    'availabilities' => '/{id}/availabilities',
                    'cal_date'  => '/{id}/availabilities/cal_date',

                    'getDetail'         => "{productId}",
                    'getUpgrades'       => "{productId}/upgrades&currency={currency}",
                    'getMedia'          => "{productId}/media",
                    'getAvailabilities' => "{productId}/availabilities?date={date}",
                    'getAvailabilitiesPrice' => "{productId}/availabilities/price?date={date}",
                    'getDepartuees'     => "{productId}/departures"
                ],
                'price_policy' => [
                    'cal' => '/activity/cal',
                    'override' => '/{id}/override?date={date}',
                    'operation' => '/{id}/operation?base_price_adult={base_price_adult}&base_price_kids={base_price_kids}',
                    'calculator' => '/calculator/exchangeCurrency?amount={amount}&currencyFrom={currencyFrom}&currencyTo={currencyTo}&isSymbol={isSymbol}',
                    'getDiscount' => '/policy/{productId}?departure_date={departure_date}&user_id={userId}&level={level}&platform={platform}&is_icbc={is_icbc}&adult_num={adult_num}&child_num={child_num}',
                    'getSpecial' => '/policy/{productId}/special?date={date}&platform={platform}',
                    'cal_discount' => '/policy/{id}/calculate',
                    'getDifferentIndustry' => '/policy/getDifferentIndustry/{id}',
                    'couponList' => '/coupon/available?customer_id={customer_id}',
                    'validateCoupon' => '/coupon/validate?customer_id={customer_id}&product_id={product_id}&coupon_code={coupon_code}&customer_level={customer_level}&departure_date={departure_date}',
                    'showCoupon' => '/coupon/show?customer_id={customer_id}&show_type={show_type}',
                    'exchangeCurrencyBatch' => '/calculator/exchangeCurrencyBatch',
                    'getCouponById' => '/coupon/{id}/getCoupon',
                ],
                'price_product'    => [
                    'getCouponList'     => 'policy/{productId}/coupon',
                    'getCal'            => 'activity/cal',
                    'getDiscount'       => 'policy/{productId}?departure_date={departure_date}&user_id={userId}&level={level}&platform={platform}&is_icbc={is_icbc}&adult_num={adult_num}&child_num={child_num}',
                    'getSpecial'        => 'policy/{productId}/special?date={date}&platform={platform}'
                ],
                'user_center'      => [
                    'getPassenger'      => 'user/{userId}/passenger',
                    'getPoint'          => 'user/{userId}/point',
                ],
                'order_services'   => [
                    'getList'           => 'customer/{userId}/order?page_size={page_size}&cur_page={cur_page}&search_type={search_type}&word={word}',
                    'getDetail'         => 'order/{orderId}',
                    'toOrder'           => 'order',
                    'pay'               => 'order/{orderId}/pay?has_pay={has_pay}&pay_finish={pay_finish}&pay_nation={pay_nation}',
                    'updatePayItem'     => 'pay/item/{pay_item_id}',
                    'updateOrderBasic'  => 'order/{orderId}/basic',
                    'cancel'            => 'order/{orderId}/cancel',
                ],
                'finance_services' => [
                    'rate' => '/api/rate?datetime={datetime}',
                ],
                'resource_services' => [
                    'adviser' => '/team/adviser',
                    'comment' => '/team/comment',
                    'getMember' => '/team/getMember/{id}',
                ],
                'all_product' => [
                    'get_product_line'=> '/{id}/getproductline?is_new={is_new}',
                    'upgrades' => '/{id}/upgrades?date={date}', //获取产品的升级项
                    'price' => '/{id}/availabilities/price?date={date}', //获取产品的价格
                    'lowest_price' => '/{id}/price',
                    'get' => '/{id}', // 得到产品的基础信息
                    'ownex' => '/{id}/ownexpense?language_id={language_id}', //获取特定产品的自费项目
                    'base_price' => '/{id}/availabilities/base_price?date={date}&currency={currency}',
                    'basePrice' => '/{id}/basePrice?date={date}&currency={currency}',
                    'departures' => '/{id}/departures?date={date}',
                    'cal_date'  => '/{id}/availabilities/cal_date',
                    'media' => '/{id}/media',
                    'availabilities' => '/{id}/availabilities?date={date}',
                    'freesales' => '/freesales?ids=[]',
                    'fuck_id' => '/allid/{is_new}/{id}',//获取新老id对应关系
                    'remaining_seat' => '/{id}/remaining_seat',
                    //一下接口只有多日游才有
                    'base_info' => '/{id}/baseInfo',
                    'month_list' => '/{id}/availabilities/month_list',
                    'month' => '/{id}/price/month?currency={currency}&{m}',
                    'display_price' => '/{id}/price/display?date={date}&currency={currency}',//图片右侧的价格
                    'start_end' => '/{id}/special/start_end',
                    'set_redis' => 'setRedis?redis_key={redis_key}&redis_value={redis_value}',
                    'get_redis' => 'getRedis?redis_key={redis_key}',
                    'calc_price' => 'tour/calculate/calc',//价格计算
                    'ticket_calc' => '/ticket/calculate/calc',//票务价格计算
                    'ticket_all_sku' => '/{id}/get_sku',//返回产品所有sku_id
                    'holiday_price' => '/{id}/holiday_price?currency={currency}&filter={filter}'//多日游返回假日价格
                ],
                'search_services'   => [
                    'search'    => 'search?{condition}'
                ],
                'event_services' => [
                    'index' => '/experiencer/index?event_number_id={event_number_id}&user_id={user_id}',
                    'createExperiencer' => '/createExperiencer',
                ]
            ],

        ],
        'request'=>array(
            'csrfTokenName' => 'csrf_token',
            'csrfCookie' => array('domain' => '.tff.com')
        ),
        'sphinx' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'mysql:host=db.tff.com;port=9306',
            'emulatePrepare' => true,
            //'username' => '',
            //'password' => '',
            'charset' => 'utf8',
        ),
        'mapper' => [
            'class' => 'webeez.vendors.jsonmapper.JsonMapper'
        ],
        'segment' => array('class' => 'webeez.classes.Segment', 'server'=>'db.tff.com:9805'),
        'mobileDetect' => array(
            'class' => 'webeez.extensions.MobileDetect'
        ),
        'viewRenderer' => array(
            'class' => 'webeez.extensions.ETwigViewRenderer',
            'twigPathAlias' => 'webeez.vendors.Twig',
            'options' => [
                'debug' => true
            ],
            'functions' => array(
                'strimwidth' => 'mb_strimwidth',
                't' => 'Yii::t',
                'md5' => 'md5',
                'currencySymbol' => 'WebeezcurrencyFD::symbolDisplay',
                'currencyValue' => 'WebeezcurrencyFD::valueDisplay',
                'currencyFormatter' => 'WebeezcurrencyFD::formatterDisplay',
                'getFakePriceNode' => 'NumericFaker::getFakePriceNode'
            ),
        ),
        'mailer' => array(
            'Password' => 'snake==>',
            'Username' => 'tours@126.com',
            'SMTPAuth' => 'true',
            'Port' => '25',
            'Host' => 'smtp.126.com',
            'class' => 'webeez.extensions.phpmailer.EMailer',
            'defaultSender' => 'smtp',
            //'debugMailAddress'=>'281956350@qq.com',
            //'defaultFromMail'=>'webmaster@tours4fun.com',
            'defaultFromName' => '途风网客服部'
        ),
        'Txt2Img' => array(
            'class' => 'application.components.Txt2Img'
        ),
        'WeiXinSDK' => array(
            'class' => 'application.components.authorizeLogin.WeiXinSDK',
            'appID' => 'wxe91bd10c96aa4317',
            'appSecret' => 'fc0ff5e5cb6edc0916a18934aef8344e',
            'scope' => 'snsapi_login',
            'callback' => 'connect/weixin'
        ),
        'QQSDK' => array(
            'class' => 'application.components.authorizeLogin.QQSDK',
            'appID' => '101169148',
            'appKey' => '391afba43adb43ad61d759c6eb40b558',
            'scope' => 'get_user_info,add_album,add_t,add_pic_t,add_idol',
            'callback' => 'connect/qq'
        ),
        'RenRenSDK' => array(
            'class' => 'application.components.authorizeLogin.RenRenSDK',
            'appID' => '273080',
            'appSecret' => 'ae22da51e5a64bd18810638e406b2ce5',
            'scope' => 'snsapi_login',
            'callback' => 'connect/renren'
        ),
        'SinaSDK' => array(
            'class' => 'application.components.authorizeLogin.SinaSDK',
            'appID' => '1495418171',
            'appKey' => '4626661ae5418f85317ba1cb030ea107',
            'callback' => 'connect/sina'
        ),
        'BaiDuSDK' => array(
            'class' => 'application.components.authorizeLogin.BaiDuSDK',
            'appID' => '8j0VZonrkpaapeXoX42PoDgq',
            'appKey' => 'KlnzNSFKEWDKuGt185aMYPDjPig1VBKf',
            'callback' => 'connect/baidu'
        ),
        'Wordpress' => array(
            'class' => 'application.components.Wordpress',
            'word_press_url' => 'http://blog.toursforfun.com/'
        ),
        'db' => array(
            'class' => 'webeez.extensions.T4fDbConnection', //CDbConnection
            'emulatePrepare' => true,
            'charset' => 'utf8',
            'connectionString' => 'mysql:host=192.168.100.200;dbname=tff_2014_06_24',
            'username' => 'root',
            'password' => 'tufeng1801',
            /*'connectionString' => 'mysql:host=127.0.0.1;dbname=tff_2014_06_24',
            'username' => 'root',
            'password' => 'Game4king',*/
            'forceMaster' => true
        ),
        'queue' => array(
            'class' => 'webeez.extensions.T4fBeanstalkdConnection',
            'servers' => array(
                array(
                    'host' => '192.168.100.200',
                    'port' => '11300',
                ),
            ),
        ),
        'OpspService' => array(
            'class' => 'application.components.OpspService'
        ),
        'hotelService' => array(
            'class' => 'webeez.extensions.services.HotelService',
        ),
        'onegouService' => array(
            'class' => 'webeez.extensions.services.OnegouService',
        ),
        'payService' => array(
            'class' => 'webeez.extensions.services.PayService',
         ),
        'recommendService' => [
            'class' => 'webeez.extensions.services.RecommendService'
        ],
        'redis' => array(
            'class' => 'webeez.extensions.T4fRedis',
            'servers' => array(
                'scheme'   => 'tcp',
                'host'     => '192.168.100.200',
                //'host' => '127.0.0.1',
                'port'     => 6379,
                'database' => 15
            )
        ),
       /*'cache'=>array(
           'class' => 'system.caching.CApcCache',
           'keyPrefix' => 'newtff',
       ),*/
        /*'cache'=>array(
            'class'=>'system.caching.CMemCache',
            'keyPrefix' => 'seven',
            'useMemcached' => true,
            'servers'=>array(
                array(
                    'host'=>'db.tff.com',
                    'port'=>11211,
                ),
            ),
        ),*/
        'cache'=>array(
            'class'=>'webeez.extensions.MemcacheExtension',
            'keyPrefix' => 'newtff123',
            'useMemcached' => true,
            'servers'=>array(
                array(
                    'host'=>'db.tff.com',
                    'port'=>11211,
                    'weight'=>50
                ),
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211,
                    'weight'=>100
                ),
            ),
        ),
        'page_cache'=>array(
            'class'=>'webeez.extensions.MemcacheExtension',
            'keyPrefix' => 'newtff123',
            'useMemcached' => true,
            'servers'=>array(
                array(
                    'host'=>'db.tff.com',
                    'port'=>11211,
                    'weight'=>50
                ),
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211,
                    'weight'=>100
                ),
            ),
        ),

        'financeOrderService' => array(
            'class' => 'webeez.extensions.services.FinanceOrderService',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                    'categories' => 'application.*',
                )
            ),

        ),
        'errorHandler' => array('errorAction' => 'site/error'),
//		'urlManager'=>array(
//			'class'=>'webeez.classes.WebeezUrlManager',
//			'urlFormat'=>'path',
//			'caseSensitive'=>true,
//			'showScriptName'=>false,
//			'rules'=>include('route.php')
//		),
        'urlManager' => array(
            'class' => 'webeez.classes.WebeezUrlManager',
            'urlFormat' => 'path',
            'caseSensitive' => true,
            'showScriptName' => false,
            'rules' => include('route.php'),
            'secureHost' => 'http://alan.home.tff.com',
            'commonHost' => 'http://alan.home.tff.com',
            'cdn' => array(
                // provider => domain
                //'default' => 'xxx.rackcdn.com', // Note: just domain here, no schema
//                'qiniu' => array(
//                    'http' => 'http://toursforfun.qiniudn.com',
//                    'https' => 'https://toursforfun.qiniudn.com',
//                ),
                'qiniu' => array(
                    'http' => 'http://dn-toursforfun.qbox.me/',
                    'https' => 'https://dn-toursforfun.qbox.me/',
                ),
            ),
        ),
        'myCart' => array('class' => 'webeez.classes.myProcess.MyCart'),
        'myOrder' => array('class' => 'webeez.classes.myProcess.MyOrder'),
        'myCalculator' => array(
            'class' => 'webeez.classes.myProcess.MyCalculator',
            'plugin' => array(
                //'webeez.classes.myProcess.plugin.ICBC',
                //'webeez.classes.myProcess.plugin.Point',
                'webeez.classes.myProcess.plugin.MDiscount',
            ),
        ),
        'authManager' => array('class' => 'webeez.classes.WebeezAuthManager'),
        'session' => array('class' => 'webeez.classes.WebeezSession', 'autoGC' => false, 'sessionName' => 'DEV_SESSID'),
        'numberFormatter' => array('class' => 'webeez.classes.WebeezNumberFormatter'),
        'currencyFD' => array('class' => 'webeez.classes.WebeezCurrencyFD'),
//        'user' => array(
//            'class' => 'webeez.classes.WebUser',
//            'returnUrl' => array('MyAccount/index'),
//            'loginUrl' => array('Account/login'),
//            'allowAutoLogin' => true
//        ),
        'user' => array(
            'class' => 'webeez.classes.WebeezCustomer',
            'returnUrl' => array('MyAccount/index'),
            'loginUrl' => array('Account/login'),
            'allowAutoLogin' => true,
        ),
        'smsSender' => array('class' => 'webeez.classes.SMSSender'),
        'clientScript' => array(
            'class' => 'webeez.classes.WebeezClientScript',
            'scriptMap' => array('jquery.js' => '/js/jquery.js', 'jquery.min.js' => false)
        ),
        'insuranceAPI' => array(
            'class' => 'webeez.classes.InsuranceAPI'
        ),
        'session_cooperator' => array('class' => 'webeez.classes.WebeezSession', 'sessionName' => 'COOPERATOR'),
        'user_cooperator' => array(
            'class' => 'CooperatorWebUser',
            'returnUrl' => array('cooperate/index'),
            'loginUrl' => array('cooperate/login')
        ),
        'rackspaceConnect' => array(
            'class' => 'webeez.extensions.rackspace.RackspaceConnect',
            // following params will overwrite in template
            'username' => 'tours4fun',
            'apiKey' => 'd307a65e0320ebc59af6d98797163bbe',
            'serviceName' => 'cloudFiles',
            'region' => 'DFW',
            'imageContainerName' => 'test',
            'cssContainerName' => 'test',
            'debug' => true,
        ),
        'daytourAnalysis' => [
            'class' => 'application.components.DaytourAnalysis'
        ]
    ),

    'params' => array(
        'additional' => [
            'easybook' => [
                // 'action' => '//option.toursforfun.com/',
                'action' => '//alan.product.option.com/',
            ],
            'question' => [
                'action' => '//alan.question.com/',
            ],
            'comment' => [
                'action' => '//alan.comment.com/',
            ],
            'recomment' => [
                'action' => '//alan.recommendation.com/',
            ],
            'photo' => [
                'action' => '//alan.photo.sharing.com/',
            ]
        ],
        'devEmail' => 'robert.zeng@tours.com',
        'storePhone' => '1-866-933-7368 (US&Canada), 1-626-389-8668 (International)',
        'contactTime' => '9:00am~5:00pm, Monday~Sunday, Pacific Standard Time',
        'reviewsEmail' => 'review@tours4fun.com',
        //variables below will override by template.php
        'mainImagesabsuPath' => __DIR__.'/../../images/',
//        'mainImagesabsuPath' => '/images/',
        'cdnUrl' => '',
        'cdnSSLUrl' =>  '',
        'cdnCNAMEUrl' => 'http://images.toursforfun.com',
//        'geoIpFile' => '/opt/geo_ip/GeoIP2-City.mmdb',
        'geoIpFile' => '\GeoIP2-City.mmdb',
        'storeId' => 4,
        'languageId' => 3,
        'cookieDomain' => '.tff.com',
        'catalogUrl' => 'http://alan.home.tff.com',
        'catalogSecureUrl' => 'http://alan.home.tff.com',
        'providerUrl' => 'http://provider.tff.com',
        'defaultDomain' => '.tff.com',
        'domain' => '.tff.com',
        'mSiteUrl' => 'http://alan.home.tff.com',
        'serverId' => 'joe',
        'apiUrl' => 'http://joe-dev.tff.com',
        'qiniuCdnUrl'=> "http://dn-toursforfun.qbox.me",
        'qiniuCdnSSLUrl'=> "https://dn-toursforfun.qbox.me",
        'pageCache' => array(
            'redisDbList' => array( //页面静态化Redis 数据库列表，未配置的默认db 16 By Dave
                0 => 17, //一日游db 17
                1 => 18 //多日游db 18
            )
        ),
        // 'paymentUrl' => 'http://payment.tim.tff.com/',
        'paymentUrl' => 'http://alan.payment.dev3.tff.com/',
        // 'paymentsvcsUrl' => 'http://payment.services.tim.tff.com',
        // 'newPaymentUrl' => 'http://payment.tim.tff.com',
        'newPaymentUrl' => 'http://alan.payment.dev3.tff.com',
        'qiniuCdnUrl'=> "",
        'qiniuCdnSSLUrl'=> "",
        'accountHost' => 'alan.home.tff.com',
        'services' => array(
            'Provider' => array(
                'url' =>'http://provider.services.alan.tff.com/',
                'secret' => 'd41d8cd98f00b204e9800998ecf8427e',
            ),
            'Product' => array(
                'url' =>'http://product.services.alan.tff.com/',
                'secret' => 'd41d8cd98f00b204e9800998ecf8427e',
            ),
            'Affiliate' => array(
                'url' =>'http://affiliate.services.alan.tff.com/',
                'secret' => 'd41d8cd98f00b204e9800998ecf8427e',
            ),
            'Content' => array(
                'url' =>'http://content.services.alan.tff.com/',
                'secret' => 'd41d8cd98f00b204e9800998ecf8427e',
            ),
            'Order' => array(
                'url' =>'http://order.services.alan.tff.com/',
                'secret' => 'd41d8cd98f00b204e9800998ecf8427e',
            ),
            'Resource' => array(
                'url' =>'http://resource.services.alan.tff.com/',
                'secret' => 'd41d8cd98f00b204e9800998ecf8427e',
            ),
            'User' => array(
                'url' =>'http://user.services.alan.tff.com/',
                'secret' => 'd41d8cd98f00b204e9800998ecf8427e',
            ),
        )
    ),
);
