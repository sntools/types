# SN Toolbox : Types

The SN Toolbox aims to provide classic tools in PHP development that will often be needed, without having to implement them over and over.

This particular package brings the strong Types : tools that allow strong typing through the technique of autoboxing, without relying on PECL SplTypes.

Thus, the package will grant you access to object-oriented wrappers for simple types, bring more advanced types like Email, and introduce the notions of Enumerations and Flags.

# Download

The easiest way to download the core tools is through Composer. Simply add the following to your composer requirements, where "~1.0" can be replaced by any version you need :

```
"sntools/types": "*"
```

# The fathers of PHP Autoboxing

The work on this package was inspired by the work of 2 developpers :

* Arthur Graniszewski and his first invention of the Autoboxing technique (http://www.phpclasses.org/package/6570-PHP-Wrap-string-and-integer-values-in-objects.html)
* Alexandre Quercia and his improvements on Graniszewsku's technique (https://github.com/alquerci/php-types-autoboxing)

# Why use SNTypes instead ?

The main problem, in my eyes, with Graniszewski's approach is that one still has to explicitly store variables as references, as it relies on global functions returning references.
Another big problem his the lack of garbage collecting process, which causes the references to never be deleted until the PHP process dies.

Alexandre Quercia fixed both these problems but added a new complexity : his garbage collector is capable of handling multiple memory spaces, despite the fact only one will ever be created and used.

This SNTypes package provides with a simpler yet effective memory handler and its garbage collector, as well as provides a lot more wrappers.
SNTypes has also been designed, much like the C# and Java wrappers, in order to provide quick access to most procedural functions, like the string manipulation ones for String.

Additionnaly, SNTypes implements magic methods related to the "operators" PECL extension without actually requiring it.
If you have said extension, SNTypes will take advantage of it by declaring operator overriding.
If you do not, SNTypes will still work fine, though you will have to rely on regular methods instead of operators.

# Usage : create an unsigned integer

```php
<?php
// First creation of the variable : create() static method
use SNTools\Types\UInt;
String::create($var, 5);

// Now, $var will stick to being a String instance
ehco $var; // 5
var_dump($var instanceof UInt); // true
$var = 2;
var_dump($var instanceof UInt); // true
echo $var; // 2
$var = '5';
var_dump($var instanceof UInt); // true
echo $var; // 5, as an integer not a string
$var = 'Foo'; // TypeMismatchException : cannot store a string into an unsigned integer
$var = -2; // TypeMismatch : cannot store a negative integer into an unsigned integer
```

# Usage : enumerations

```php
<?php
use SNTools\Types\Enum;
class MemberType extends Enum {
   const ADMIN = 0;
   const MODERATOR = 1;
   const NORMAL = 2;
   const GUEST =  3;
   const BANNED = 4;
}
MemberType->create($type, MemberType::ADMIN);
// now, $type cannot be overriden by something that is not part of the MemberType enum
$type = MemberType::NORMAL; // works
$type = 3; // works too, as MemberType::GUEST equals 3
$type = 'Foo'; // TypeMismatchException
```

# API Reference

To generate the documentation, use the apigen.neon file to generate it in a "docs" folder

```
> apigen generate
```

# Testing

Coming soon in /tests subfolder...

# Contributors

Samy Naamani <samy@namani.net>

# License

MIT