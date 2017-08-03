[de]
# Test states
requirements.status.failed = "Fehlgeschlagen"
requirements.status.ok = "OK"
requirements.status.unknown = "Unbekannt"
requirements.status.warning = "Warnung"
requirements.status.optional = "Optional"

# Group names
requirements.tests.groups.webserver = "Webserver"
requirements.tests.groups.database = "Datenbank"
requirements.tests.groups.php.modules = "PHP - Module"
requirements.tests.groups.php.configuration = "PHP - Konfiguration"
requirements.tests.groups.php = "PHP"
requirements.tests.groups.system = "System"

# Tests 
requirements.tests.database.version.name = "Version"
requirements.tests.database.version.desc = "Prüft die Datenbank Server Version."

requirements.tests.php.configuration.memorylimit.name = "Memory Limit"
requirements.tests.php.configuration.memorylimit.desc = "Prüft das Memory Limit von PHP."

requirements.tests.php.modules.curl.name = "CURL"
requirements.tests.php.modules.curl.desc = "Prüft, ob das Modul 'curl' geladen ist"

requirements.tests.php.modules.dom.name = "DOM"
requirements.tests.php.modules.dom.desc = "Prüft, ob das Modul 'dom' geladen ist"

requirements.tests.php.modules.gzip.name = "GZIP"
requirements.tests.php.modules.gzip.desc = "Prüft, ob das Modul 'gzip' geladen ist"

requirements.tests.php.modules.image.name = "Imagelibraries"
requirements.tests.php.modules.image.desc = "Prüft, ob das Modul 'curl' geladen ist"

requirements.tests.php.modules.json.name = "JSON"
requirements.tests.php.modules.json.desc = "Prüft, ob das Modul 'json' geladen ist"

requirements.tests.php.modules.pdo.name = "MySql mit PDO"
requirements.tests.php.modules.pdo.desc = "Prüft, ob das Modul 'mysql' geladen ist und PDO unterstützt"

requirements.tests.php.modules.mbstring.name = "MBString"
requirements.tests.php.modules.mbstring.desc = "Prüft, ob das Modul 'mbstring' geladen ist"

requirements.tests.php.version.name = "Version"
requirements.tests.php.version.desc = "Prüft die PHP Version"

requirements.tests.system.permissions.name = "Dateirechte"
requirements.tests.system.permissions.desc = "Prüft die Dateisystem rechte wichtiger Verzeichnisse"

requirements.tests.webserver.rewrite.name = "Rewrite"
requirements.tests.webserver.rewrite.desc = "Prüft, ob der Webserver Rewrite unterstützt"

# Other
test.message.error.permission.file = "'./%FILE%' Hat die falschen Dateirechte. Aktuell: %CURRENT%. Benötigt: %REQUIRED%."
test.message.error.not.writeable.file = "'./%FILE%' ist nicht beschreibbar"

[en]
# States
requirements.status.failed = "Failed"
requirements.status.ok = "OK"
requirements.status.unknown = "Unknown"
requirements.status.warning = "Warning"
requirements.status.optional = "Optional"

# Groups
requirements.tests.groups.webserver = "Webserver"
requirements.tests.groups.database = "Database"
requirements.tests.groups.php.modules = "PHP - Modules"
requirements.tests.groups.php.configuration = "PHP - Configuration"
requirements.tests.groups.php = "PHP"
requirements.tests.groups.system = "System"

# Tests 
requirements.tests.database.version.name = "Version"
requirements.tests.database.version.desc = "Checks the database servers version"

requirements.tests.php.configuration.memorylimit.name = "Memorylimit"
requirements.tests.php.configuration.memorylimit.desc = "Checks if PHPs memory limit is sufficient."

requirements.tests.php.modules.curl.name = "CURL"
requirements.tests.php.modules.curl.desc = "Checks if the module 'curl' is loaded"

requirements.tests.php.modules.dom.name = "DOM"
requirements.tests.php.modules.dom.desc = "Checks if the module 'dom' is loaded"

requirements.tests.php.modules.gzip.name = "GZIP"
requirements.tests.php.modules.gzip.desc = "Checks if the module 'gzip' is loaded"

requirements.tests.php.modules.image.name = "Image libraries"
requirements.tests.php.modules.image.desc = "Checks if the module 'gd' or 'imagick' is loaded"

requirements.tests.php.modules.json.name = "JSON"
requirements.tests.php.modules.json.desc = "Checks if the module 'json' is loaded"

requirements.tests.php.modules.pdo.name = "MySql + PDO"
requirements.tests.php.modules.pdo.desc = "Checks if the module 'mysql' including pdo support is loaded"

requirements.tests.php.version.name = "Version"
requirements.tests.php.version.desc = "Checks the PVP version"

requirements.tests.system.permissions.name = "Filesystem permissions"
requirements.tests.system.permissions.desc = "Checks the filesystem permissions for important directories"

requirements.tests.webserver.rewrite.name = "Rewrite"
requirements.tests.webserver.rewrite.desc = "Checks if the webserver supports rewriting of urls"


test.message.error.permission.file = "'./%FILE%' has the wrong permissions. Current: %CURRENT. Required: %REQUIRED%."
test.message.error.not.writeable.file = "'./%FILE%' is not writable"