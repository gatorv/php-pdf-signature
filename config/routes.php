<?php

/** @var \Zend\Expressive\Application $app */
$app->get('/', App\Action\HomePageAction::class, 'home');
$app->get('/pdf', App\Action\PdfPageAction::class, 'pdf');
