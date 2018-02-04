<?php

namespace App\Action\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use App\Action\PdfPageAction;

/**
 * Handles creation of a PdfPageAction
 */
class PdfPageFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\Factory\FactoryInterface::__invoke()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PdfPageAction();
    }
}
