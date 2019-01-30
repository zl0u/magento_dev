<?php

namespace GorbanSv\AskQuestion\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Exception;

/**
 * Class ProductUpdateQty
 * @package GorbanSv\AskQuestion\Console\Command
 */
class ProductUpdateQty extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var StockRegistryInterface
     */
    private $stockRegistry;

    /**
     * @var State
     */
    private $state;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Inventory constructor.
     * @param StockRegistryInterface $stockRegistry
     */
    public function __construct(
        StockRegistryInterface $stockRegistry,
        State $state,
        ProductRepositoryInterface $productRepository
    ) {
        $this->stockRegistry = $stockRegistry;
        $this->state = $state;
        $this->productRepository = $productRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('product-tool:update-qty')
            ->setDescription('Update product qty')
            ->addArgument('product_id', InputArgument::REQUIRED, 'Product Id')
            ->addArgument('qty', InputArgument::REQUIRED, 'Qty');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->setAreaCode(Area::AREA_ADMINHTML);
            $productId = (int)$input->getArgument('product_id');
            $product = $this->productRepository->getById($productId);
            $stockItem = $this->stockRegistry->getStockItem($productId);
            $stockItem->setQty($input->getArgument('qty'));
            $stockItem->setIsInStock((bool)$input->getArgument('qty'));
            $this->stockRegistry->updateStockItemBySku($product->getSku(), $stockItem);

            $output->writeln("<info>Completed!<info>");
        } catch (Exception  $e) {
            $output->writeln("<info>{$e->getMessage()}<info>");
        }
    }
}
