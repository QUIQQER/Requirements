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
requirements.tests.groups.php.functions = "PHP - Funktionen"
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

requirements.tests.php.modules.iconv.name = "Iconv"
requirements.tests.php.modules.iconv.desc = "Prüft, ob das Modul 'iconv' geladen ist"

requirements.tests.php.modules.openssl.name = "OpenSSL"
requirements.tests.php.modules.openssl.desc = "Prüft, ob das Modul 'openssl' geladen ist"

requirements.tests.php.modules.spl.name = "SPL"
requirements.tests.php.modules.spl.desc = "Prüft, ob das Modul 'SPL' geladen ist"

requirements.tests.php.modules.xml.name = "XML"
requirements.tests.php.modules.xml.desc = "Prüft, ob das Modul 'xml' geladen ist"

requirements.tests.php.modules.zip.name = "ZIP"
requirements.tests.php.modules.zip.desc = "Prüft, ob das Modul 'zip' geladen ist"

requirements.tests.php.version.name = "Version"
requirements.tests.php.version.desc = "Prüft die PHP Version"

requirements.tests.system.permissions.name = "Dateirechte"
requirements.tests.system.permissions.desc = "Prüft die Dateisystem rechte wichtiger Verzeichnisse"

requirements.tests.webserver.rewrite.name = "Rewrite"
requirements.tests.webserver.rewrite.desc = "Prüft, ob der Webserver Rewrite unterstützt"

requirements.tests.database.connectivity.name = "Verbindung"
requirements.tests.database.connectivity.desc = "Prüft, ob eine Datenbankverbindung aufgebaut werden kann"

requirements.tests.php.configuration.sessionautostart.name = "Session autostart"
requirements.tests.php.configuration.sessionautostart.desc = "Prüft, ob 'session.autostart' den Wert 0 hat"

requirements.tests.php.configuration.timezone.name = "Zeitzone"
requirements.tests.php.configuration.timezone.desc = "Prüft, ob eine Standard Zeitzone konfiguriert ist"

requirements.tests.php.configuration.uploadsize.name = "Uploadgröße"
requirements.tests.php.configuration.uploadsize.desc = "Prüft die maximale Uploadgröße"

requirements.tests.php.modules.SPL.name = "SPL"
requirements.tests.php.modules.SPL.desc = "Prüft, ob das Modul 'SPL' geladen ist"

requirements.tests.system.geolocate.name = "Geolocation"
requirements.tests.system.geolocate.desc = "Prüft, ob der Webserver Geolocating unterstützt."

requirements.tests.webserver.headers.name = "Headers"
requirements.tests.webserver.headers.desc = "Prüft, ob das Apache Modul 'headers' geladen ist."

requirements.tests.webserver.ssl.name = "Verbindung per SSL"
requirements.tests.webserver.ssl.desc = "Prüft, ob die Verbindung per HTTPS aufgebaut wurde."


# Test messages

requirements.error.memorylimit.undetected = "Das Arbeitsspeicher Limit konnte nicht ermittelt werden."
requirements.error.memorylimit.insufficient = " Das Arbeitsspeicherlimit ist sehr gering. Dies kann zu Problemen im Betrieb führen. Wir empfehlen mindestens 256M. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.module.dom.missing = "Das PHP-Modul 'DOM' ist nicht geladen oder installiert. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.module.gzip.missing = "Das PHP-Modul 'Gzip' ist nicht geladen oder installiert. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.module.imagelibs.missing = "Weder das PHP-Modul 'gd' noch 'imagick' ist geladen oder installiert. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.module.json.missing = "Das PHP-Modul 'json' ist nicht geladen oder installiert. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.module.mbstring.missing = "Das PHP-Modul 'mbstring' ist nicht geladen oder installiert. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.module.pdo.missing = "Das PHP-Modul 'pdo' ist nicht geladen oder installiert. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.module.curl.missing = "Das PHP-Modul 'curl' ist nicht geladen oder installiert. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.version.insufficient = "Die installierte Version ist zu gering. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.timezone.notset = "Es ist keine Standard Zeitzone konfiguriert. Dies kann Probleme bei Zeiten und Daten verursachen. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.uploads.deactivated = "Ihr System erlaubt keine Dateiuploads. Wir empfehlen Fileuploads zu aktivieren. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.uploadsize.low = "Die eingestellte Uploadgröße ist sehr gering. Wir empfehlen eine Uploadgröße von mindestens 8M. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.postsize.low = "Die konfigurierte maximale Post Size ist sehr gering. Wir empfehlen mindestens 8M. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.geolocate.not.found = "Es konnte nicht festgestellt werden, ob Geolocation unterstützt wird. Wir empfehlen die Konfiguration von Gelocation. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.webserver.headers.missing = "Das Modul 'headers' konnte nicht gefunden worden. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.webserver.ssl.disabled = "Die Verbindung wurde unverschlüsselt aufgebaut. Wir empfehlen dringend Webserver Verbindungen zu verschlüsseln. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.webserver.rewrite.missing = "Das Modul 'headers' konnte nicht gefunden worden. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.mysql.connectivity = "Die Datenbank ist nicht erreichbar. Bitte überprüfen Sie die Konfiguration. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.mysql.version.incompatible.driver = "Der verwendete Datenbanktreiber wird nicht unterstützt. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"
requirements.error.mysql.version.incompatible.version = "Die Datenbank Version wird nicht unterstützt. <a target='_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

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

requirements.tests.database.connectivity.name = "Connection"
requirements.tests.database.connectivity.desc = "Checks the database connection."

requirements.tests.php.configuration.sessionautostart.name = "Sesssion autostart"
requirements.tests.php.configuration.sessionautostart.desc = "Checks if session autostart is disabled"

requirements.tests.php.configuration.timezone.name = "Timezone"
requirements.tests.php.configuration.timezone.desc = "Checks if a default timezone is set"

requirements.tests.php.configuration.uploadsize.name = "Uploadsize"
requirements.tests.php.configuration.uploadsize.desc = "Checks the configured maximum upload size"

requirements.tests.php.modules.SPL.name = "SPL"
requirements.tests.php.modules.SPL.desc = "Checks if the module 'SPL' is enabled"

requirements.tests.system.geolocate.name = "Geolocation"
requirements.tests.system.geolocate.desc = "Checks if the webserver supports geolocation"

requirements.tests.webserver.headers.name = "Headers"
requirements.tests.webserver.headers.desc = "Checks if the module headers is enabled"

requirements.tests.webserver.ssl.name = "SSL connection"
requirements.tests.webserver.ssl.desc = "Checks if the connection uses SSL encryption"

requirements.tests.php.modules.iconv.name = "Iconv"
requirements.tests.php.modules.iconv.desc = "Checks if the module 'iconv' is enabled"

requirements.tests.php.modules.mbstring.name = "mbstring"
requirements.tests.php.modules.mbstring.desc = "Checks if the module 'mbstring' is enabled"

requirements.tests.php.modules.openssl.name = "OpenSSL"
requirements.tests.php.modules.openssl.desc = "Checks if the module 'openssl' is enabled"

requirements.tests.php.modules.xml.name = "XML"
requirements.tests.php.modules.xml.desc = "Checks if the module 'xml' is enabled"

requirements.tests.php.modules.zip.name = "ZIP"
requirements.tests.php.modules.zip.desc = "Checks if the module 'zip' is enabled"

# Test messages
requirements.error.module.curl.missing = ""
requirements.error.memorylimit.undetected = ""
requirements.error.memorylimit.insufficient = ""
requirements.error.module.dom.missing = ""
requirements.error.module.gzip.missing = ""
requirements.error.module.imagelibs.missing = ""
requirements.error.module.json.missing = ""
requirements.error.module.mbstring.missing = ""
requirements.error.module.pdo.missing = ""
requirements.error.version.insufficient = ""
requirements.error.timezone.notset = ""
requirements.error.uploads.deactivated = ""
requirements.error.uploadsize.low = ""
requirements.error.postsize.low = ""
requirements.error.webserver.ssl.disabled = ""
requirements.error.webserver.headers.missing = ""
requirements.error.webserver.rewrite.missing = ""
requirements.error.mysql.connectivity = ""
requirements.error.mysql.version.incompatible.driver = ""
requirements.error.mysql.version.incompatible.version = ""




# Other
test.message.error.permission.file = "'./%FILE%' has the wrong permissions. Current: %CURRENT. Required: %REQUIRED%."
test.message.error.not.writeable.file = "'./%FILE%' is not writable"