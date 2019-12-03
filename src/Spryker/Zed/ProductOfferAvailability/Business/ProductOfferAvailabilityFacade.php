<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductOfferAvailability\Business;

use Generated\Shared\Transfer\ProductConcreteAvailabilityTransfer;
use Generated\Shared\Transfer\ProductOfferAvailabilityRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\ProductOfferAvailability\Business\ProductOfferAvailabilityBusinessFactory getFactory()
 */
class ProductOfferAvailabilityFacade extends AbstractFacade implements ProductOfferAvailabilityFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductOfferAvailabilityRequestTransfer $productOfferAvailabilityRequestTransfer
     *
     * @return bool
     */
    public function isProductSellableForRequest(
        ProductOfferAvailabilityRequestTransfer $productOfferAvailabilityRequestTransfer
    ): bool {
        return $this->getFactory()
            ->createProductOfferAvailabilityProvider()
            ->isProductSellableForRequest($productOfferAvailabilityRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductOfferAvailabilityRequestTransfer $productOfferAvailabilityRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteAvailabilityTransfer|null
     */
    public function findProductConcreteAvailabilityForRequest(ProductOfferAvailabilityRequestTransfer $productOfferAvailabilityRequestTransfer): ?ProductConcreteAvailabilityTransfer
    {
        return $this->getFactory()
            ->createProductOfferAvailabilityProvider()
            ->findProductConcreteAvailabilityForRequest($productOfferAvailabilityRequestTransfer);
    }
}
