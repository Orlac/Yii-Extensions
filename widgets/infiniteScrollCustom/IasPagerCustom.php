<?php
Yii::import('ext.infiniteScroll.*');
class IasPagerCustom  extends IasPager {

    private $baseUrl;
    private $parentBaseUrl;
    public $currentItemsSelector;
    
    public function init() {

        $assets = dirname(__FILE__) . '/assets';
        $parentAssets = dirname(__FILE__) . '/../infiniteScroll/assets';
        $this->baseUrl = Yii::app()->assetManager->publish($assets);
        $this->parentBaseUrl = Yii::app()->assetManager->publish($parentAssets);
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCSSFile($this->parentBaseUrl . '/css/jquery.ias.css');
        $cs->registerScriptFile($this->baseUrl . '/js/jquery.ias.js', CClientScript::POS_END);
    }
    
    public function run() {

        $js = "jQuery.ias(" .
                CJavaScript::encode(
                        CMap::mergeArray($this->options, array(
                            'container' => '#' . $this->listViewId . '' . $this->itemsSelector,
                            'item' => $this->rowSelector,
                            'currentItemsSelector'=>$this->currentItemsSelector,
                            'pagination' => $this->pagerSelector,
                            'next' => $this->nextSelector,
                            'loader' => $this->loaderText,
                        ))) . ");";

//        $js = "jQuery.ias(" .
//            json_encode(
//                CMap::mergeArray($this->options, array(
//                    'container' => '#' . $this->listViewId . '' . $this->itemsSelector,
//                    'item' => $this->rowSelector,
//                    'pagination' => '#' . $this->listViewId . ' ' . $this->pagerSelector,
//                    'next' => '#' . $this->listViewId . ' ' . $this->nextSelector,
//                    'loader' => $this->loaderText,
//                ))) . ");";


        $cs = Yii::app()->clientScript;
        $cs->registerScript(__CLASS__ . $this->id, $js, CClientScript::POS_READY);


        $buttons = $this->createPageButtons();

        echo $this->header; // if any
        echo CHtml::tag('ul', $this->htmlOptions, implode("\n", $buttons));
        echo $this->footer;  // if any
    }
}