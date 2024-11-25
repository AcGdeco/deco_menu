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
        return $collection;
    }
}