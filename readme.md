#Jform

Jform est une classe de remplacement à la class Form de Laravel.

##Installation

Add the provider to your providers array in config/app.php

<!-- language: lang-php -->

	'Jux\Jform\JformServiceProvider'

##Usage

You can use the Jform facade like this :

<!-- language: lang-php  -->

	Jform::text(true,'email')

The first element is a @boolean which define if it's a required field or not
