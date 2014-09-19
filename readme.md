#Jform

Jform is a Facade like the form facade but with boilerplate and accessibility management

##Installation

Add the provider to your providers array in config/app.php

<!-- language: lang-php -->

	'Jux\Jform\JformServiceProvider'

##Usage

You can use the Jform facade like this :

<!-- language: lang-php  -->

	Jform::text(true,'email')

The first element is a @boolean which define if it's a required field or not
