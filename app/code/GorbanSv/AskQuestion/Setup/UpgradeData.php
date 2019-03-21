<?php

namespace GorbanSv\AskQuestion\Setup;

use Magento\Framework\DB\Transaction;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Store\Model\Store;
use Magento\Framework\File\Csv;
use Magento\Framework\DB\TransactionFactory;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Customer\Model\GroupFactory;
use Magento\Customer\Model\ResourceModel\GroupRepository;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use GorbanSv\AskQuestion\Model\AskQuestion;
use GorbanSv\AskQuestion\Model\AskQuestionFactory;

/**
 * Class UpgradeData
 * @package GorbanSv\AskQuestion\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var AskQuestionFactory
     */
    private $askQuestionFactory;

    /**
     * @var Csv
     */
    private $csv;

    /**
     * @var ComponentRegistrar
     */
    private $componentRegistrar;
    
    /**
     * @var EavSetupFactory
     */
    private $transactionFactory;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var \Magento\Customer\Model\Attribute
     */
    private $customerAttribute;

    /**
     * @var GroupFactory
     */
    private $groupFactory;

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * UpgradeData constructor.
     * @param AskQuestionFactory $askQuestionFactory
     * @param ComponentRegistrar $componentRegistrar
     * @param Csv $csv
     * @param TransactionFactory $transactionFactory
     * @param EavSetupFactory $eavSetupFactory
     * @param \Magento\Customer\Model\Attribute $customerAttribute
     * @param GroupFactory $groupFactory
     * @param GroupRepository $groupRepository
     */
    public function __construct(
        AskQuestionFactory $askQuestionFactory,
        ComponentRegistrar $componentRegistrar,
        Csv $csv,
        TransactionFactory $transactionFactory,
        EavSetupFactory $eavSetupFactory,
        \Magento\Customer\Model\Attribute $customerAttribute,
        GroupFactory $groupFactory,
        GroupRepository $groupRepository,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->askQuestionFactory = $askQuestionFactory;
        $this->componentRegistrar = $componentRegistrar;
        $this->csv = $csv;
        $this->transactionFactory = $transactionFactory;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerAttribute = $customerAttribute;
        $this->groupFactory = $groupFactory;
        $this->groupRepository = $groupRepository;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $statuses = [AskQuestion::STATUS_PENDING, AskQuestion::STATUS_PROCESSED];
            
            /** @var Transaction $transaction */
            $transaction = $this->transactionFactory->create();
            
            for ($i = 1; $i <= 5; $i++) {
                /** @var AskQuestion $askQuestion */
                $askQuestion = $this->askQuestionFactory->create();
                
                $askQuestion->setName("Customer #$i")
                    ->setEmail("test-mail-$i@gmail.com")
                    ->setPhone("+38093-$i$i$i-$i$i-$i$i")
                    ->setProductName("Product #$i")
                    ->setSku("product_sku_$i")
                    ->setQuestion('Just a test question')
                    ->setStatus($statuses[array_rand($statuses)])
                    ->setStoreId(Store::DISTRO_STORE_ID);
                $transaction->addObject($askQuestion);
            }
            
            $transaction->save();
        }

        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            $this->updateDataForAskQuestion($setup, 'import_data.csv');
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'show_questions_form',
                [
                    'type' => 'int',
                    'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                    'frontend' => '',
                    'label' => 'Show Questions Form',
                    'input' => 'select',
                    'group' => 'General',
                    'class' => '',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => true,
                    'user_defined' => false,
                    'default' => '1',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'sort_order' => 20
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.4') < 0) {
            $this->createDisallowAskQuestionCustomerAttribute($setup);
        }

        if (version_compare($context->getVersion(), '1.0.5') < 0) {
            $this->createDisallowAskQuestionCustomerGroup($setup);
        }

        if (version_compare($context->getVersion(), '1.0.6') < 0) {
            $this->createCorpusAddressCustomerAttribute($setup);
        }

        $setup->endSetup();
    }

    /**
     * @param $setup
     * @throws \Exception
     */
    public function createDisallowAskQuestionCustomerGroup($setup)
    {
        // Create the new group
        /** @var \Magento\Customer\Model\Group $group */
        $group = $this->groupFactory->create();
        $group->setCode('Forbidden for Ask Question')
            ->setTaxClassId($this->groupRepository::DEFAULT_TAX_CLASS_ID)
            ->save();
    }

    public function createCorpusAddressCustomerAttribute($setup)
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttribute('customer_address', 'corpus', [
            'type' => 'varchar',
            'label' => 'Corpus',
            'input' => 'text',
            'required' => false,
            'visible' => true,
            'user_defined' => true,
            'sort_order' => 1000,
            'position' => 1000,
            'system' => 0,
        ]);

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'corpus')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => [
                    'adminhtml_customer_address',
                    'customer_address_edit',
                    'customer_register_address',
                ],
            ]);

        $attribute->save();
    }

    /**
     * @param $setup
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createDisallowAskQuestionCustomerAttribute($setup)
    {
        $code = 'disallow_ask_question';
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Customer::ENTITY,
            $code,
            [
                'type'         => 'int',
                'label'        => 'Disallow Ask Question',
                'input'        => 'select',
                'source'       => Boolean::class,
                'required'     => false,
                'visible'      => false,
                'user_defined' => true,
                'position'     => 999,
                'system'       => 0,
                'default'      => 0,
                'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
            ]
        );
        $attribute = $this->customerAttribute->loadByCode(Customer::ENTITY, $code);
        $attribute->addData([
            'attribute_set_id' => 1,
            'attribute_group_id' => 1,
            'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
        ])->save();
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param $fileName
     * @throws \Exception
     */
    public function updateDataForAskQuestion(ModuleDataSetupInterface $setup, $fileName)
    {
        $tableName = $setup->getTable('gorbansv_ask_question');
        $filePath = $this->getPathToCsvMagentoAtdec($fileName);
        $csvData = $this->csv->getData($filePath);

        if ($setup->getConnection()->isTableExists($tableName)) {
            foreach ($csvData as $row => $data) {
                if (count($data) === 9) {
                    $res = $this->getCsvData($data);

                    $setup->getConnection()->insertOnDuplicate(
                        $tableName,
                        $res,
                        [
                            'name',
                            'email',
                            'phone',
                            'product_name',
                            'sku',
                            'question',
                            'created_at',
                            'status',
                            'store_id',
                        ]
                    );
                }
            }
        }
    }

    /**
     * @param $fileName
     * @return string
     */
    private function getPathToCsvMagentoAtdec($fileName)
    {
        return $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, 'GorbanSv_AskQuestion') .
            DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * @param $data
     * @return array
     */
    private function getCsvData($data)
    {
        return [
            'name' => $data[0],
            'email' => $data[1],
            'phone' => $data[2],
            'product_name' => $data[3],
            'sku' => $data[4],
            'question' => $data[5],
            'created_at' => $data[6],
            'status' => $data[7],
            'store_id' => $data[8],
        ];
    }
}
