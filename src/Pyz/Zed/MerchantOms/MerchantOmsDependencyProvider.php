<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantOms;

use Pyz\Zed\MerchantOms\Communication\Plugin\Oms\CancelMarketplaceOrderItemCommandPlugin;
use Pyz\Zed\MerchantOms\Communication\Plugin\Oms\CancelReturnMarketplaceOrderItemCommandPlugin;
use Pyz\Zed\MerchantOms\Communication\Plugin\Oms\DeliverMarketplaceOrderItemCommandPlugin;
use Pyz\Zed\MerchantOms\Communication\Plugin\Oms\DeliverReturnMarketplaceOrderItemCommandPlugin;
use Pyz\Zed\MerchantOms\Communication\Plugin\Oms\ExecuteReturnMarketplaceOrderItemCommandPlugin;
use Pyz\Zed\MerchantOms\Communication\Plugin\Oms\RefundMarketplaceOrderItemCommandPlugin;
use Pyz\Zed\MerchantOms\Communication\Plugin\Oms\ShipByMerchantMarketplaceOrderItemCommandPlugin;
use Pyz\Zed\MerchantOms\Communication\Plugin\Oms\ShipReturnMarketplaceOrderItemCommandPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MerchantOms\MerchantOmsDependencyProvider as SprykerMerchantOmsDependencyProvider;

/**
 * @method \Spryker\Zed\MerchantOms\MerchantOmsConfig getConfig()
 */
class MerchantOmsDependencyProvider extends SprykerMerchantOmsDependencyProvider
{
    /**
     * @var string
     */
    public const PYZ_FACADE_OMS = 'PYZ_FACADE_OMS';

    /**
     * @var string
     */
    public const PYZ_FACADE_SALES_RETURN = 'PYZ_FACADE_SALES_RETURN';

    /**
     * @return array<\Spryker\Zed\StateMachine\Dependency\Plugin\CommandPluginInterface>
     */
    protected function getStateMachineCommandPlugins(): array
    {
        return [
            'MarketplaceOrder/ShipOrderItem' => new ShipByMerchantMarketplaceOrderItemCommandPlugin(),
            'MarketplaceOrder/DeliverOrderItem' => new DeliverMarketplaceOrderItemCommandPlugin(),
            'MarketplaceOrder/CancelOrderItem' => new CancelMarketplaceOrderItemCommandPlugin(),
            'MarketplaceOrder/Refund' => new RefundMarketplaceOrderItemCommandPlugin(),
            'MarketplaceReturn/CancelReturnForOrderItem' => new CancelReturnMarketplaceOrderItemCommandPlugin(),
            'MarketplaceReturn/DeliverReturnForOrderItem' => new DeliverReturnMarketplaceOrderItemCommandPlugin(),
            'MarketplaceReturn/ExecuteReturnForOrderItem' => new ExecuteReturnMarketplaceOrderItemCommandPlugin(),
            'MarketplaceReturn/ShipReturnForOrderItem' => new ShipReturnMarketplaceOrderItemCommandPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addPyzOmsFacade($container);
        $container = $this->addPyzSalesReturnFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addPyzOmsFacade(Container $container): Container
    {
        $container->set(static::PYZ_FACADE_OMS, function (Container $container) {
            return $container->getLocator()->oms()->facade();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addPyzSalesReturnFacade(Container $container): Container
    {
        $container->set(static::PYZ_FACADE_SALES_RETURN, function (Container $container) {
            return $container->getLocator()->salesReturn()->facade();
        });

        return $container;
    }
}
