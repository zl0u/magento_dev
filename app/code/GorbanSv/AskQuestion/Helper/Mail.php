<?php

namespace GorbanSv\AskQuestion\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\User\Model\UserFactory;


class Mail extends AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * Mail constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     * @param UserFactory $userFactory
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        UserFactory $userFactory
    ) {
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->userFactory = $userFactory;
        parent::__construct($context);
    }

    /**
     * @throws \Magento\Framework\Exception\MailException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function sendMail($emailFrom, $customerName = '', $message)
    {
        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $this->storeManager->getStore()->getId()
        ];
        $templateVars = [
            'store' => $this->storeManager->getStore(),
            'customer_name' => $customerName,
            'message'   => $message
        ];
        $adminEmail = $this->getAdminEmail();

        $this->inlineTranslation->suspend();

        /**
         * Send Email To Admin
         */
        $from = ['email' => $emailFrom, 'name' => $customerName];
        $to = [$adminEmail];
        $transport = $this->transportBuilder->setTemplateIdentifier('ask_question_admin_email_template')
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom($from)
            ->addTo($to)
            ->getTransport();
        $transport->sendMessage();

        /**
         * Send Email To Customer
         */
        $from = ['email' => $adminEmail, 'name' => 'Admin'];
        $to = [$emailFrom];
        $transport = $this->transportBuilder->setTemplateIdentifier('ask_question_customer_email_template')
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom($from)
            ->addTo($to)
            ->getTransport();
        $transport->sendMessage();

        $this->inlineTranslation->resume();
    }

    /**
     * @return mixed|string
     */
    private function getAdminEmail()
    {
        $transEmailSaller = $this->scopeConfig->getValue(
            'trans_email/ident_sales/email',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if ($transEmailSaller) {
            return $transEmailSaller;
        }

        $userFactory =  $this->userFactory->create();

        if ($userFactory) {
            $user = $userFactory->getById(1);
            return $user->getEmail();
        }

        return '';
    }
}
