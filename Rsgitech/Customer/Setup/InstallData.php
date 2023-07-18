<?php
namespace Rsgitech\Customer\Setup;

use Magento\Customer\Model\Customer;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    private $eavSetupFactory;
    
    private $eavConfig;
    
    private $attributeResource;
    
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Customer\Model\ResourceModel\Attribute $attributeResource
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
    }
    
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // Attribute 1: Skype
        $this->addAttribute($eavSetup, 'rut', 'Rut Cliente', 'text', true, true, true, 990, 990, [
            'adminhtml_customer',
            'customer_account_create',
            'customer_account_edit'
        ]);

        // Attribute 2: Facebook
        $this->addAttribute($eavSetup, 'giro', 'Giro Cliente', 'text', true, true, true, 991, 991, [
            'adminhtml_customer',
            'customer_account_create',
            'customer_account_edit'
        ]);
        
        $this->addAttribute($eavSetup, 'comunaDespacho', 'Comuna Despacho', 'text', true, true, true, 992, 992, [
            'adminhtml_customer',
            'customer_account_create',
            'customer_account_edit'
        ]);
        
        $this->addAttribute($eavSetup, 'comunaFacturacion', 'Comuna Facturacion', 'text', true, true, true, 993, 993, [
            'adminhtml_customer',
            'customer_account_create',
            'customer_account_edit'
        ]);
        
        $this->addAttribute($eavSetup, 'razonSocial', 'Razon Social', 'text', true, true, true, 994, 994, [
            'adminhtml_customer',
            'customer_account_create',
            'customer_account_edit'
        ]);
        
        $this->addAttribute($eavSetup, 'nombreFantasia', 'Nombre Fantasia', 'text', true, true, true, 995, 995, [
            'adminhtml_customer',
            'customer_account_create',
            'customer_account_edit'
        ]);

    }

    private function addAttribute($eavSetup, $attributeCode, $label, $inputType, $isRequired, $isVisible, $isUserDefined, $sortOrder, $position, $usedInForms)
    {
        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Customer::ENTITY);
        $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Customer::ENTITY);

        $eavSetup->addAttribute(Customer::ENTITY, $attributeCode, [
            // Attribute parameters
            'type' => 'varchar',
            'label' => $label,
            'input' => $inputType,
            'required' => $isRequired,
            'visible' => $isVisible,
            'user_defined' => $isUserDefined,
            'sort_order' => $sortOrder,
            'position' => $position,
            'system' => 0,
        ]);
        
        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, $attributeCode);
        $attribute->setData('attribute_set_id', $attributeSetId);
        $attribute->setData('attribute_group_id', $attributeGroupId);

        $attribute->setData('used_in_forms', $usedInForms);

        $this->attributeResource->save($attribute);
    }
}
?>
