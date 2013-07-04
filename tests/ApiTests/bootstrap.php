<?php


if ((!$loader = @include __DIR__ . '/../../vendor/autoload.php')) {
	echo 'Install Nette Tester using `composer update --dev`';
	exit(1);
}

$loader->add('ApiTests', __DIR__ . '/../');


