Requirements
============

This package provides methods to check the system requirements for
QUIQQER

Paketname:

    quiqqer/requirements

Features (Funktionen)
---------------------

System requirements check.

Following tests are currently implemented

* PHP Version greater than 5.6
* PHP memory limit >256M
* PHP extension: PDO (MySql)
* PHP extension: DOM
* PHP extension: Curl
* PHP extension: JSON
* PHP extension: Image (GD | Imagick)
* PHP extension: Gzip
* PHP extension: MBstring
* Apache: Mod rewrite

Usage
-----

For usage examples please check the examples folder


Ignore specific Tests
---------------------

It is possible to ignore specific tests or groups.

```
$Requirements = new \QUI\Requirements\Requirements();
   
$Tests = $Requirements->getTests(array(
    path.within.tests.directory, //Group identifier
    test.identifier
));
print_r($Tests);
```

You can provide multiple identifiers in an array.  
Every test has an identifier, which you can find in the tests properties:
```
class Memorylimit extends Test
{
    protected $identifier = "php.configuration.memorylimit";
[...]
```

Each group has an identifier as well.  
The group identifiers are built by their namespace and hence by their location within the tests directory.

** To get the group identifier:**
1. Simply remove the `src/QUI/Requirements/Tests/` part.
2. Replace Slashes `/` by dots `.`
3. Put all letters to lowercase

```
src/QUI/Requirements/Tests/PHP/Configuration => php.configuration
```

Testcomponents
--------------

A test consists of thefollowing components:
* A name
* A description
* A result
  * Statuscode
  * Reason / message

Testresults
-----------

Each test will yield a TestResult. These TestResults have a status code
and areason/message tied to them.

The status codes are integers and defined by constants in the Testresult
class. Following status codes are implemented:
* STATUS_FAILED(0) - The test failed and QUIQQER will not run on this
  system
* STATUS_OK(1) - The test has passed and will not cause problems while
  running QUIQQER
* STATUS_UNKNOWN(2) - The test could not detect the component and thus
  the result is not known (apache rewrite cant be dtected by php alone)
* STATUS_WARNING(3) - The test yielded an warning ( i.e. ram is enoguh
  to ram but more is recommended)
* STATUS_OPTIONAL(4) - The component is missing, but also not required,
  but nice to have.

Adding new tests
----------------

To add new tests you need to create a new Class in the folder
`src/QUI/Requirements/Tests` The class needs to extend the abstract
class `QUI\Requirements\Tests\Test` and provide the property `protected
$identifier=''` The location of the class must be conformt to the PSR-4
standard and its namespace is used as its group.

Now you need to add the following locale variables:

* requirements.tests.\<your identifier here>.name // Test name
* requirements.tests.\<your identifier here>.desc // Test description
* requirements.tests.groups.\<namespce identifier>\* // Test group name

\* \<namespace identifier> This is the identifier for the namespace. it
will get generated from the namespace by substracting the common
namespace part: `QUI\\Requirements\\Tests\\` and putting the result to
all lower case and replacing the slashes with dots.

Example: QUI\Requirements\Tests\PHP\Configuration ==> php.configuration


**Example skeleton:**

```
namespace QUI\Requirements\Tests\ExampleGroup;

use QUI\Requirements\Locale;
use QUI\Requirements\TestResult;
use QUI\Requirements\Tests\Test;


class ExampleTest extends Test
{
    protected $identifier = "examplegroup.exampletest";

    public function run()
    {
        /*
        * Your Testlogix should be executed here
        */

        // Create and return a testresult Object
        return new TestResult(TestResult::STATUS_OK, "Alles gut!");
    }
}
```


Installation
------------

Der Paketname ist: quiqqer/requirements


Mitwirken
---------

- Issue Tracker: https://dev.quiqqer.com/quiqqer/requirements/issues
- Source Code: https://dev.quiqqer.com/quiqqer/requirements


Support
-------

Falls Sie einen Fehler gefunden haben oder Verbesserungen wünschen,
senden Sie bitte eine E-Mail an support@pcsg.de.


Lizenz
------

MIT


Entwickler
----------

Florian Bogner <f.bogner@pcsg.de>
