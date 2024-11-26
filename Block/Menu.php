<?php
namespace Deco\Menu\Block;

class Menu extends \Magento\Framework\View\Element\Template
{    
    protected $_categoryCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,        
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        array $data = []
    )
    {
         $this->_categoryCollectionFactory = $categoryCollectionFactory;
         parent::__construct($context, $data);
    }


    public function getActiveCategoryCollection()
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');        
        $collection->addIsActiveFilter();
        $collection->setOrder('name','ASC');
        return $collection;
    }

    public function getListTypeCategoryCollection()
    {
        $categories = $this->getActiveCategoryCollection();

        $html = "<ul class='level-0' >";
        foreach($categories as $category){
            if(empty($category->getChildren()) && $category->getLevel() == 2){
                $html .= "<ul>";
                    $html .= "<li>";
                        $html .= "<a href='".$category->getUrl()."' >";
                            $html .= "<span class='name' >";
                                $html .= $category->getName();
                            $html .= "</span>";
                        $html .= "</a>";
                    $html .= "</li>";
                $html .= "</ul>";
            }elseif(!empty($category->getChildren()) && $category->getLevel() == 2){
                $level = $category->getLevel();
                $html .= $this->childrenList($category, $categories, $level);
            }
        }
        $html .= "</ul>";

        return $html;
    }

    public function childrenList($category, $categories, $level)
    {
        $level++;
        $html = "<ul class='group-hover'>";
            $html .= "<li class='has-child' >";
                $html .= "<a class='has-child' href='".$category->getUrl()."' >";
                    $html .= "<span class='name' >";
                        $html .= $category->getName();
                    $html .= "</span>";
                    $html .= "<span class='front-name' >";
                    $html .= "</span>";
                $html .= "</a>";
                $html .= "<span class='front-name-outside' >";
                $html .= "</span>";
            $html .= "</li>";
            $html .= "<ul class='group'>";
                foreach($categories as $categoryLevel){
                    if(empty($categoryLevel->getChildren()) && $categoryLevel->getLevel() == $level && $categoryLevel->getParentId() == $category->getId()){
                        $html .= "<ul>";
                            $html .= "<li>";
                                $html .= "<a href='".$categoryLevel->getUrl()."' >";
                                    $html .= "<span class='name' >";
                                        $html .= $categoryLevel->getName();
                                    $html .= "</span>";
                                $html .= "</a>";    
                            $html .= "</li>";
                        $html .= "</ul>";
                    }elseif(!empty($categoryLevel->getChildren()) && $categoryLevel->getLevel() == $level && $categoryLevel->getParentId() == $category->getId()){
                        $html .= $this->childrenList($categoryLevel, $categories, $level);
                    }
                }
            $html .= "</ul>";
        $html .= "</ul>";
    
        return $html;
    }
}