<?php

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

/**
 * Creates a new Homepage Action
 */
class HomePageAction implements ServerMiddlewareInterface
{
    /** @var Router\RouterInterface **/
    private $router;

    /** @var Template\TemplateRendererInterface **/
    private $template;

    /**
     * @param Router\RouterInterface $router
     * @param Template\TemplateRendererInterface $template
     */
    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template)
    {
        $this->router   = $router;
        $this->template = $template;
    }

    /**
     * {@inheritDoc}
     * @see \Interop\Http\ServerMiddleware\MiddlewareInterface::process()
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $data = [];
        $data['routerName'] = 'Zend Router';
        $data['routerDocs'] = 'https://docs.zendframework.com/zend-router/';
        $data['templateName'] = 'Twig';
        $data['templateDocs'] = 'http://twig.sensiolabs.org/documentation';

        return new HtmlResponse($this->template->render('app::home-page', $data));
    }
}
