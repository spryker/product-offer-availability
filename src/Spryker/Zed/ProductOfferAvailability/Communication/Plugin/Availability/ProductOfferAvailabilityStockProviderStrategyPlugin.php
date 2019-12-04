<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductOfferAvailability\Communication\Plugin\Availability;

use Generated\Shared\Transfer\ProductAvailabilityCriteriaTransfer;
use Generated\Shared\Transfer\ProductConcreteAvailabilityTransfer;
use Generated\Shared\Transfer\ProductOfferAvailabilityRequestTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\AvailabilityExtension\Dependency\Plugin\AvailabilityStockProviderStrategyPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\ProductOfferAvailability\Business\ProductOfferAvailabilityFacadeInterface getFacade()
 */
class ProductOfferAvailabilityStockProviderStrategyPlugin extends AbstractPlugin implements AvailabilityStockProviderStrategyPluginInterface
{
    /**
     * {@inheritDoc}
     * - Checks if product offer availability requested, and strategy should be applied.
     *
     * @api
     *
     * @param string $sku
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param \Generated\Shared\Transfer\ProductAvailabilityCriteriaTransfer|null $productAvailabilityCriteriaTransfer
     *
     * @return bool
     */
    public function isApplicable(
        string $sku,
        StoreTransfer $storeTransfer,
        ?ProductAvailabilityCriteriaTransfer $productAvailabilityCriteriaTransfer = null
    ): bool {
        return $productAvailabilityCriteriaTransfer
            && $productAvailabilityCriteriaTransfer->getProductOffer()
            && $productAvailabilityCriteriaTransfer->getProductOffer()->getProductOfferReference();
    }

    /**
     * {@inheritDoc}
     * - Returns product concrete availability for product offer.
     *
     * @api
     *
     * @param string $sku
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param \Generated\Shared\Transfer\ProductAvailabilityCriteriaTransfer|null $productAvailabilityCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteAvailabilityTransfer|null
     */
    public function findProductConcreteAvailabilityForStore(
        string $sku,
        StoreTransfer $storeTransfer,
        ?ProductAvailabilityCriteriaTransfer $productAvailabilityCriteriaTransfer = null
    ): ?ProductConcreteAvailabilityTransfer {
        $productAvailabilityCriteriaTransfer
            ->requireProductOffer()
            ->getProductOffer()
                ->requireProductOfferReference();

        $productOfferAvailabilityRequestTransfer = (new ProductOfferAvailabilityRequestTransfer())
            ->setStore($storeTransfer)
            ->setProductOfferReference($productAvailabilityCriteriaTransfer->getProductOffer()->getProductOfferReference());

        return $this->getFacade()
            ->findProductConcreteAvailabilityForRequest($productOfferAvailabilityRequestTransfer);
    }
}
