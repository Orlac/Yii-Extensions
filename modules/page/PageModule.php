<?php
/**
 * PageModule class file.
 *
 * PageModule is a yii framework {@link http://www.yiiframework.com/} module that provides simple
 * content management system that is most suitable for presenting guides or tutorials.
 *
 * Resources:
 *
 * 1. Code on github {@link https://github.com/erikuus/Yii-Extensions/tree/master/modules/page}
 * 2. Live example {@link http://www.ra.ee/vau/index.php/en/page}
 *
 * Requirements:
 *
 * 1. Tested with Yii 1.1.8, should work in earlier versions
 * 2. Requires following extensions that can be downloaded from {@link https://github.com/erikuus/Yii-Extensions}
 *    ext.behaviors.XReturnableBehavior
 *    ext.behaviors.XReorderBehavior
 *    ext.behaviors.XSlugBehavior
 *    ext.actions.XReorderAction
 *    ext.actions.XHEditorUpload
 *    ext.validators.XCompareRequiredValidator
 *    ext.widgets.grid.groupgridview.XGroupGridView
 *    ext.widgets.grid.reordercolumn.XReorderColumn
 *    ext.widgets.alert.XAlert
 *    ext.widgets.xheditor.XHeditor
 *    ext.widgets.fancybox.XFancyBox
 *
 * Quickstart:
 *
 * 1. Create a skeleton Yii application
 * 2. Add page module to your application config
 *
 * <pre>
 * return array(
 *     'modules'=>array(
 *         'page'=>array(
 *             'class'=>'application.modules.page.PageModule',
 *         ),
 *     ),
 * )
 * </pre>
 *
 * 3. Create database tables by running migration commands
 *
 * yiic migrate --migrationPath=ext.modules.page.migrations
 * yiic migrate --migrationPath=ext.modules.page.migrations
 *
 * Note that migration examples are for PostgreSQL. For other databases modify migration scrpts
 * or create tables manually.
 *
 * 4. Now you will be able to access PageModule in your browser using the following URL
 * http://localhost/path/to/app/index.php?r=page
 *
 * If your application is using path-format URLs, you can access PageModule via:
 * http://localhost/path/to/app/index.php/page
 *
 * You can also configure your application Url Manager to set special rule for page module.
 * For example:
 * <pre>
 * 'urlManager'=>array(
 *     'urlFormat'=>'path',
 *     'showScriptName'=>false,
 *     'appendParams'=>false,
 *     'rules'=>array(
 *         'article/<topic:\S+>' => 'page/article/index',
 *     ),
 * ),
 * </pre>
 *
 * 5. You can also plug anywhere into your application PageMenuWidget as follows:
 * <pre>
 * $this->widget('application.modules.page.components.PageMenuWidget');
 * </pre>
 *
 * Customize:
 *
 * 1. You can configure the page module to use different database and/or
 * different table names
 *
 * <pre>
 * return array(
 *     'modules'=>array(
 *         'page'=>array(
 *             'class'=>'application.modules.page.PageModule',
 *             'dbConnectionString'=>'mysql:host=127.0.0.1;dbname=mydatabase',
 *             'dbUsername'=>'user',
 *             'dbPassword'=>'password',
 *             'menuTableName'=>'my_page_menu',
 *             'articleTableName'=>'my_page_article',
 *         ),
 *     ),
 * )
 * </pre>
 *
 * 2. Most often you need to customize layout and style. For example,
 * in case of skeleton application you probably want to configure layout
 * as follows:
 *
 * <pre>
 * return array(
 *     'modules'=>array(
 *         'page'=>array(
 *             'class'=>'application.modules.page.PageModule',
 *             'pageLayout'=>'
 *                 <div class="span-19">
 *                     <div id="content">
 *                         {content}
 *                     </div>
 *                 </div>
 *                 <div class="span-5 last">
 *                     <div id="sidebar">
 *                         {menu}
 *                     </div>
 *                 </div>
 *             ',
 *         ),
 *     ),
 * )
 * </pre>
 *
 * 3. You can customize the page module to be usable also when application
 * is based on zurb foundation css framework (tested with foundation 5.2.2)
 *
 * First you can save some custom style to application/css/menu.css:
 * .page-menu {
 *     background-color: #f9f9f9;
 *     padding: 15px;
 * }
 * .page-menu-label {
 *     text-transform: uppercase;
 *     font-weight: bold;
 *     color: #666666;
 * }
 * .page-menu-admin {
 *     float: right;
 *     margin: 15px 10px 0 0;
 * }
 *
 * Then configure page module as follows:
 * <pre>
 * return array(
 *     'modules'=>array(
 *         'page'=>array(
 *             'class'=>'ext.modules.page.PageModule',
 *             'pageLayout'=>'
 *                 <div class="row">
 *                     <div class="large-3 columns">
 *                         {menu}
 *                     </div>
 *                     <div class="large-9 columns">
 *                         {content}
 *                     </div>
 *                 </div>
 *             ',
 *             'menuCssFile'=>rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\').'/css/menu.css',
 *             'menuWidgetConfig'=>array(
 *                 'listCssClass'=>'side-nav'
 *             ),
 *             'gridCssFile'=>false,
 *             'gridCssClass'=>'large-12',
 *             'primaryButtonCssClass'=>'small button radius',
 *             'secondaryButtonCssClass'=>'small button radius secondary'
 *         ),
 *     ),
 * )
 * </pre>
 *
 * 4. You can customize the page module to be usable also when application
 * is based on bootstrap css framework (tested with bootstrap 3.1.1)
 * <pre>
 * return array(
 *     'modules'=>array(
 *         'page'=>array(
 *             'class'=>'ext.modules.page.PageModule',
 *             'pageLayout'=>'
 *                 <div class="row">
 *                     <div class="col-md-3">
 *                         {menu}
 *                     </div>
 *                     <div class="col-md-9">
 *                         {breadcrumbs}<br />{content}
 *                     </div>
 *                 </div>
 *             ',
 *             'menuCssFile'=>false,
 *             'menuWidgetConfig'=>array(
 *                 'listCssClass'=>'nav nav-pills nav-stacked'
 *                 'labelTemplate'=>'<h4>{label}</h4>',
 *             ),
 *             'gridCssFile'=>false,
 *             'gridCssClass'=>'table',
 *             'primaryButtonCssClass'=>'btn btn-primary',
 *             'secondaryButtonCssClass'=>'btn btn-default'
 *         ),
 *     ),
 * )
 * </pre>
 *
 * For all possible customizations refer to PageModule class properties below.
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class PageModule extends CWebModule
{
	/**
	 * @var string the ID of the default controller for this module.
	 * Defaults to 'tbl_page_menu'.
	 */
	public $defaultController='article';
	/**
	 * @var string the module database connection string.
	 * If NULL, application default database (db) is used.
	 */
	public $dbConnectionString;
	/**
	 * @var string the module database username
	 */
	public $dbUsername;
	/**
	 * @var string the module database password
	 */
	public $dbPassword;
	/**
	 * @var string the name of the menu table.
	 * Defaults to 'tbl_page_menu'.
	 */
	public $menuTableName='tbl_page_menu';
	/**
	 * @var string the name of the article table
	 * Defaults to 'tbl_page_article'.
	 */
	public $articleTableName='tbl_page_article';
	/**
	 * @var mixed authorization item name (an operation, a task or a role) that has access to restricted pages (content management pages).
	 * Defaults to false, meaning authorization component is not used at all and only admin user has access to restricted pages.
	 */
	public $authItemName=false;
	/**
	 * @var string the template used to render page modul. In this template,
	 * the token "{breadcrumbs}" will be replaced with the CBreadcrumbs widget,
	 * the token "{menu}" will be replaced with the PageMenuWidget,
	 * the token "{content}" will be replaced with the article content
	 */
	public $pageLayout='{breadcrumbs}{menu}{content}';
	/**
	 * @var string css class for primary (save) buttons
	 */
	public $primaryButtonCssClass;
	/**
	 * @var string css class for secondary (cancel) buttons
	 */
	public $secondaryButtonCssClass;
	/**
	 * @var string The base script URL for all module resources (e.g. javascript, CSS file, images).
	 * If NULL (default) the integrated module resources (which are published as assets) are used.
	 */
	public $baseScriptUrl;
	/**
	 * @var mixed the CSS file used for the menu. Defaults to null, meaning
	 * using the default CSS file included together with the module.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this module.
	 */
	public $menuCssFile;
	/**
	 * @var mixed the CSS file used for the article. Defaults to null, meaning
	 * using the default CSS file included together with the module.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this module.
	 */
	public $pageCssFile;
	/**
	 * @var mixed the CSS file used for the forms. Defaults to null, meaning
	 * using the default CSS file included together with the module.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this module.
	 */
	public $formCssFile;
	/**
	 * @var mixed the CSS file used for the gridviews. Defaults to null, meaning
	 * using the default CSS file. If false, no CSS file will be used. Otherwise,
	 * the specified CSS file will be included when using this module.
	 */
	public $gridCssFile;
	/**
	 * @var string css class for grid table. Defaults to 'items'.
	 */
	public $gridCssClass='items';
	/**
	 * @var array configuration for PageMenuWidget when used via page template.
	 * Refer to PageMenuWidget class for possible configuration.
	 * Defaults to array()
	 */
	public $menuWidgetConfig=array();
	/**
	 * @var boolean whether an id prefix is expected in the slug or not.
	 * @see XSluggableBehavior class
	 */
	public $slugIdPrefix=true;
	/**
	 * @var boolean whether inflector is use to build slug.
	 * @see XSluggableBehavior class
	 */
	public $slugInflector=true;
	/**
	 * @var boolean whether to enable saving reference code for articles.
	 * Using one reference code for artcles in different languages
	 * enables to link to same content within multilingual application.
	 * Defaults false
	 */
	public $enableRefcode=false;
	/**
	 * @var mixed the CSS file used by wysiwyg editor for the article content.
	 * Defaults false, meaning no CSS file will be used.
	 * Otherwise, the specified CSS file will be loaded by editor.
	 */
	public $editorArticleCssFile=false;
	/**
	 * @var mixed the CSS file used by wysiwyg editor for the article content.
	 * Defaults false, meaning no CSS file will be used.
	 * Otherwise, the specified CSS file will be loaded by editor.
	 */
	public $editorSideContentCssFile=false;
	/**
	 * @var string list of XHeditor tools for menu content
	 * Possible values are also 'mini', 'simple', 'full'
	 */
	public $editorMenuTools='Bold,Link,Unlink,List,SelectAll,Removeformat,Source,Fullscreen';
	/**
	 * @var string list of XHeditor tools for article content
	 * Possible values are also 'mini', 'simple', 'full'
	 */
	public $editorArticleTools='Cut,Copy,Paste,Pastetext,|,Blocktag,Bold,Italic,Underline,FontColor,BackColor,Removeformat,SelectAll,|,Align,List,Outdent,Indent,|,Link,Unlink,Img,Template,Table,|,Source,Preview,Fullscreen';
	/**
	 * @var string the name of the root directory where editor uploads files
	 */
	public $editorUploadRootDir='upload';
	/**
	 * @var string the type of directory structure for uploaded files
	 * Possible values are [day- directory per day, month- directory per month, ext- directory per extension]
	 * Defaults to 'day'
	 */
	public $editorUploadDirStructure='day';
	/**
	 * @var integer the maximum upload size for files
	 * Defaults to 2097152 (=2MB)
	 */
	public $editorUploadMaxSize=2097152;
	/**
	 * @var string the list extensions that are allowed to be uploaded by editor
	 */
	public $editorUploadAllowedLinkExtensions='pdf,txt,rar,zip';
	/**
	 * @var string the list image extensions that are allowed to be uploaded by editor
	 */
	public $editorUploadAllowedImageExtensions='jpg,jpeg,gif,png';

	/**
	 * @var array the list of routes that are publicly accessible
	 */
	private $publicRoutes=array(
		'article/index',
		'article/search',
	);

	/**
	 * Initializes the page module.
	 */
	public function init()
	{
		// import the module-level models and components
		$this->setImport(array(
			'page.models.*',
			'page.components.*',
			'ext.helpers.XHtml',
		));

		// set connection to module database
		if($this->dbConnectionString)
		{
			Yii::app()->setComponents(array(
				'pagedb'=>array(
					'class'=>'CDbConnection',
					'connectionString'=>$this->dbConnectionString,
					'username'=>$this->dbUsername,
					'password'=>$this->dbPassword,
				),
			));
		}

		// publish module assets
		if (!is_string($this->baseScriptUrl)) {
			$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('page.assets'));
		}
	}

	/**
	 * Performs access check to module.
	 * @param CController the controller to be accessed.
	 * @param CAction the action to be accessed.
	 * @return boolean whether the action should be executed.
	 */
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			$route=$controller->id.'/'.$action->id;

			if($this->authItemName!==false)
				$this->checkAuthAccess($route);
			else
				$this->checkUserAccess($route);

			return true;
		}
		else
			return false;
	}

	/**
	 * Performs access check to allow only admin user to access nonpublic route.
	 * @param string the route.
	 * @return boolean whether the action should be executed.
	 */
	protected function checkUserAccess($route)
	{
		if(Yii::app()->user->isGuest && !in_array($route,$this->publicRoutes))
			Yii::app()->user->loginRequired();
		elseif(!Yii::app()->user->isGuest && !in_array($route,$this->publicRoutes) && Yii::app()->user->name!='admin')
			throw new CHttpException(403,'You are not allowed to access this page.');
		else
			return true;
	}

	/**
	 * Performs access check to allow only specific auth item to access nonpublic route.
	 * @param string the route.
	 * @return boolean whether the action should be executed.
	 */
	protected function checkAuthAccess($route)
	{
		if(Yii::app()->user->isGuest && !in_array($route,$this->publicRoutes))
			Yii::app()->user->loginRequired();
		elseif(!Yii::app()->user->isGuest && !in_array($route,$this->publicRoutes) && Yii::app()->user->name!='admin' && !Yii::app()->user->checkAccess($this->authItemName))
			throw new CHttpException(403,'You are not allowed to access this page.');
		else
			return true;
	}
}
