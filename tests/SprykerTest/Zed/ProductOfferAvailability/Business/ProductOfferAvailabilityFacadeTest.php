<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductOfferAvailability\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\OmsProductReservationTransfer;
use Generated\Shared\Transfer\ProductOfferAvailabilityRequestTransfer;
use Generated\Shared\Transfer\ProductOfferStockTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductOfferAvailability
 * @group Business
 * @group Facade
 * @group ProductOfferAvailabilityFacadeTest
 * Add your own group annotations below this line
 */
class ProductOfferAvailabilityFacadeTest extends Unit
{
    /**
     * @var string
     */
    protected const STORE_NAME_DE = 'DE';

    /**
     * @var string
     */
    protected const STORE_NAME_AT = 'AT';

    /**
     * @var \SprykerTest\Zed\ProductOfferAvailability\ProductOfferAvailabilityBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testFindProductConcreteAvailabilityReturnsProductOfferAvailabilityAssumingOmsProductReservations(): void
    {
        // Arrange=
        $stockQuantity = 5;
        $reservedQuantity = 3;
        $expectedAvailability = $stockQuantity - $reservedQuantity;

        $storeTransfer = $this->tester->haveStore([StoreTransfer::NAME => static::STORE_NAME_DE]);
        $productOfferTransfer = $this->tester->haveProductOffer();
        $this->tester->haveProductOfferStore($productOfferTransfer, $storeTransfer);
        $this->tester->haveProductOfferStock([
            ProductOfferStockTransfer::ID_PRODUCT_OFFER => $productOfferTransfer->getIdProductOffer(),
            ProductOfferStockTransfer::QUANTITY => $stockQuantity,
            ProductOfferStockTransfer::STOCK => [
                StockTransfer::STORE_RELATION => [
                    StoreRelationTransfer::ID_STORES => [
                        $storeTransfer->getIdStore(),
                    ],
                ],
            ],
        ]);

        $this->tester->haveOmsProductReservation([
            OmsProductReservationTransfer::SKU => $productOfferTransfer->getConcreteSku(),
            OmsProductReservationTransfer::RESERVATION_QUANTITY => $reservedQuantity,
            OmsProductReservationTransfer::FK_STORE => $storeTransfer->getIdStore(),
        ]);

        $productOfferAvailabilityRequestTransfer = (new ProductOfferAvailabilityRequestTransfer())
            ->setStore($storeTransfer)
            ->setProductOfferReference($productOfferTransfer->getProductOfferReference())
            ->setSku($productOfferTransfer->getConcreteSku());

        // Act
        $productConcreteAvailabilityTransfer = $this->tester->getFacade()
            ->findProductConcreteAvailability($productOfferAvailabilityRequestTransfer);

        // Assert
        $this->assertNotNull($productConcreteAvailabilityTransfer);
        $this->assertSame($expectedAvailability, $productConcreteAvailabilityTransfer->getAvailability()->toInt());
    }

    /**
     * @return void
     */
    public function testFindProductConcreteAvailabilityReturnsAvailabilityZeroWhenProductOfferHasNoCurrentStore(): void
    {
        // Arrange
        $storeTransfer = $this->tester->haveStore([StoreTransfer::NAME => static::STORE_NAME_DE]);
        $productOfferTransfer = $this->tester->haveProductOffer();
        $this->tester->haveProductOfferStock([
            ProductOfferStockTransfer::ID_PRODUCT_OFFER => $productOfferTransfer->getIdProductOffer(),
            ProductOfferStockTransfer::QUANTITY => 5,
            ProductOfferStockTransfer::STOCK => [
                StockTransfer::STORE_RELATION => [
                    StoreRelationTransfer::ID_STORES => [
                        $storeTransfer->getIdStore(),
                    ],
                ],
            ],
        ]);

        $productOfferAvailabilityRequestTransfer = (new ProductOfferAvailabilityRequestTransfer())
            ->setStore($storeTransfer)
            ->setProductOfferReference($productOfferTransfer->getProductOfferReference())
            ->setSku($productOfferTransfer->getConcreteSku());

        // Act
        $productConcreteAvailabilityTransfer = $this->tester->getFacade()
            ->findProductConcreteAvailability($productOfferAvailabilityRequestTransfer);

        // Assert
        $this->assertNotNull($productConcreteAvailabilityTransfer);
        $this->assertSame(0, $productConcreteAvailabilityTransfer->getAvailability()->toInt());
    }

    /**
     * @return void
     */
    public function testFindProductConcreteAvailabilityReturnsAvailabilityZeroWhenStockHasNoStoreConnection(): void
    {
        // Arrange
        $storeTransfer = $this->tester->haveStore([StoreTransfer::NAME => static::STORE_NAME_DE]);
        $storeTransferAT = $this->tester->haveStore([StoreTransfer::NAME => static::STORE_NAME_AT]);
        $productOfferTransfer = $this->tester->haveProductOffer();
        $this->tester->haveProductOfferStore($productOfferTransfer, $storeTransfer);
        $this->tester->haveProductOfferStock([
            ProductOfferStockTransfer::ID_PRODUCT_OFFER => $productOfferTransfer->getIdProductOffer(),
            ProductOfferStockTransfer::QUANTITY => 5,
            ProductOfferStockTransfer::STOCK => [
                StockTransfer::STORE_RELATION => [
                    StoreRelationTransfer::ID_STORES => [
                        $storeTransferAT->getIdStore(),
                    ],
                ],
            ],
        ]);

        $productOfferAvailabilityRequestTransfer = (new ProductOfferAvailabilityRequestTransfer())
            ->setStore($storeTransfer)
            ->setProductOfferReference($productOfferTransfer->getProductOfferReference())
            ->setSku($productOfferTransfer->getConcreteSku());

        // Act
        $productConcreteAvailabilityTransfer = $this->tester->getFacade()
            ->findProductConcreteAvailability($productOfferAvailabilityRequestTransfer);

        // Assert
        $this->assertNotNull($productConcreteAvailabilityTransfer);
        $this->assertSame(0, $productConcreteAvailabilityTransfer->getAvailability()->toInt());
    }
}
