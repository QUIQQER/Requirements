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
requirements.tests.groups.quiqqer = "QUIQQER"

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

requirements.tests.quiqqer.checksums.name = "Paketintegrität"
requirements.tests.quiqqer.checksums.desc = "Prüft, ob die installierten Pakete verändert wurden."


# Test messages

requirements.message.version.ok = "<p><strong>Installiert:</strong> %VERSION%</p><p><strong>Mindestanforderung:</strong> %REQUIRED_VERSION%</p>"
requirements.error.memorylimit.undetected = "Das Arbeitsspeicher Limit konnte nicht ermittelt werden."

requirements.error.memorylimit.insufficient = " Das Arbeitsspeicherlimit ist sehr gering.
Dies kann zu Problemen im Betrieb führen.
Es werden mindestens 128M benötigt. <a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.module.dom.missing = "Das PHP-Modul 'DOM' ist nicht geladen oder installiert.<br />
<b>Lösung : </b><br />
Installiere das Modul über die Paketverwaltung :
<pre><code>apt-get install php7.X-xml</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.module.xml.missing = "Das PHP-Modul 'xml' ist nicht geladen oder installiert.<br />
<b>Lösung : </b><br />
Installiere das Modul über die Paketverwaltung :
<pre><code>apt-get install php7.X-xml</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.module.gzip.missing = "Das PHP-Modul 'Gzip' ist nicht geladen oder installiert.<br />
<b>Lösung : </b><br />
Installiere das Modul über die Paketverwaltung und starte den Webserver/PHP neu :
<pre><code>apt-get install php7.X-gzip</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.module.imagelibs.missing = "Weder das PHP-Modul 'gd' noch 'imagick' ist geladen oder installiert.<br />
<b>Lösung : </b><br />
Installiere das Modul über die Paketverwaltung und starte den Webserver/PHP neu :
<pre><code>apt-get install php7.X-gd</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.module.json.missing = "Das PHP-Modul 'json' ist nicht geladen oder installiert.
<br />
<b>Lösung : </b><br />
Installiere das Modul über die Paketverwaltung und starte den Webserver/PHP neu :
<pre><code>apt-get install php7.X-json</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.module.mbstring.missing = "Das PHP-Modul 'mbstring' ist nicht geladen oder installiert.<br />
<b>Lösung : </b><br />
Installiere das Modul über die Paketverwaltung und starte den Webserver/PHP neu :
<pre><code>apt-get install php7.X-mbstring</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.module.pdo.missing = "Das PHP-Modul 'pdo' ist nicht geladen oder installiert.<br />
<b>Lösung : </b><br />
Installiere das Modul über die Paketverwaltung und starte den Webserver/PHP neu :
<pre><code>apt-get install php7.X-mysql</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.module.curl.missing = "Das PHP-Modul 'curl' ist nicht geladen oder installiert.<br />
<b>Lösung : </b><br />
Installiere das Modul über die Paketverwaltung und starte den Webserver/PHP neu :
<pre><code>apt-get install php7.X-curl</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.module.zip.missing = "Das PHP-Modul 'zip' ist nicht geladen oder installiert.<br />
<b>Lösung : </b><br />
Installiere das Modul über die Paketverwaltung und starte den Webserver/PHP neu :
<pre><code>apt-get install php7.X-zip</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.module.iconv.missing = "Das PHP-Modul 'iconv' ist nicht geladen oder installiert.<br />
<b>Lösung : </b><br />
Installiere das Modul über die Paketverwaltung und starte den Webserver/PHP neu :
<pre><code>apt-get install php7.X-iconv</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.version.insufficient = "Die installierte Version ist zu gering.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.timezone.notset = "Es ist keine Standard Zeitzone konfiguriert.
Dies kann Probleme bei Zeiten und Daten verursachen.<br />
<b>Lösung : </b><br />
Setze die Zeitzone in der php.ini :
<pre><code>date.timezone = UTC</code></pre>
<a href = "http://php.net/manual/de/timezones.php">Unterstützen Zeitzonen</a><br />
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Weitere Hilfe</a>"

requirements.error.session.autostart.enabled = "Sessionautostart ist aktiviert.
Deaktiviere den Sessionautostart.<br />
<b>Lösung : </b><br />
session.auto_start in der php.ini deaktivieren :
<pre><code>session.auto_start = 0</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Weitere Help</a>"


requirements.error.uploads.deactivated = "Ihr System erlaubt keine Dateiuploads.
Wir empfehlen Fileuploads zu aktivieren.<br />
Dazu wird folgende Einstellung in der php.ini verwendet :
<pre><code>file_uploads = On</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.uploadsize.low = "Die eingestellte Uploadgröße ist sehr gering.
Wir empfehlen das Limit zu erhöhen.<br />
Dazu wird folgende Einstellung in der php.ini verwendet :
<pre><code>upload_max_filesize = 8M
post_max_size = 8M</code></pre>
Wir empfehlen eine Uploadgröße von mindestens 8M. <a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.postsize.low = "Die konfigurierte maximale Post Size ist sehr gering.
Wir empfehlen das Limit zu erhöhen.<br />
Dazu wird folgende Einstellung in der php.ini verwendet :
<pre><code>upload_max_filesize = 8M
post_max_size = 8M</code></pre>
Wir empfehlen mindestens 8M.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.geolocate.not.found = "Es konnte nicht festgestellt werden, ob Geolocation unterstützt wird.
Wir empfehlen die Konfiguration von Gelocation. <a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.webserver.headers.missing = "Das Modul 'headers' konnte nicht gefunden worden.<br />
<b>Lösung : </b><br />
Aktiviere das Modul und starte den Webserver neu (Apache2) :
<pre><code>a2enmod headers</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.webserver.ssl.disabled = "Die Verbindung wurde unverschlüsselt aufgebaut.
Wir empfehlen dringend Webserver Verbindungen zu verschlüsseln. <a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.webserver.rewrite.missing = "Das Modul 'rewrite' konnte nicht gefunden worden.
<br />
<b>Lösung : </b><br />
Aktiviere das Modul und starte den Webserver neu (Apache2) :
<pre><code>a2enmod rewrite</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.mysql.connectivity = "Die Datenbank ist nicht erreichbar.Bitte überprüfen Sie die Konfiguration.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.mysql.version.incompatible.driver = "Der verwendete Datenbanktreiber wird nicht unterstützt.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.mysql.version.incompatible.version = "Die Datenbank Version wird nicht unterstützt.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>"

requirements.error.system.permissions = "Die Dateirechte sind nicht korrekt.
Bitte stelle sicher, dass der Benutzer des Webservers Schreibrechte auf folgende Verzeichnisse und Datein hat.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Hilfe</a>
<pre><code>chown -R %USER% : %GROUP% %PATH%</code></pre>"

requirements.error.quiqqer.checksums = "Es wurden Pakete mit modifizierten oder zusätzlichen Datein gefunden. Folgende Pakete und Dateien wurden verändert:"
requirements.error.quiqqer.checksums.missing = "Nicht alle pakete konnten erfolgreich überprüft werden. Dies passiert wenn keine Checksummendatei des Paketauthors bereitgestellt wurde. Folgende pakete sind hiervon betroffen:"

# Other
test.message.error.permission.file = "'./%FILE%' Hat die falschen Dateirechte. Aktuell: %CURRENT%. Benötigt: %REQUIRED%."
test.message.error.not.writeable.file = "'./%FILE%' ist nicht beschreibbar"

checksums.table.header.file = "Lokale Datei"
checksums.table.header.checksum.file = "Aktuelle Prüfsumme"
checksums.table.header.checksum.local = "Soll-Prüfsumme (Lokal)"
checksums.table.header.checksum.remote = "Soll-Prüfsumme (Online)"

checksums.state.ok = "OK"
checksums.state.unknown = "Unbekannt"
checksums.state.modified = "Verändert"
checksums.state.added = "Hinzugefügt"
checksums.state.removed = "Entfernt"

checksums.state.ok.desc = "Die Datei befindet sich in ihrem Originalen Zustand."
checksums.state.unknown.desc = "Es wurden keine Prüfsumm gefunden, mit wlecher die Datei verglichen werden kann."
checksums.state.modified.desc = "Die Datei wurde verändert."
checksums.state.added.desc = "Die Datei wurde auf dem lokalen Dateisystem hinzugefügt und ist im originalem Paket nicht vorhanden."
checksums.state.removed.desc = "Die Datei wurde auf dem lokalen Dateisystem entfernt und ist im originalem Paket enthalten."

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
requirements.tests.groups.quiqqer = "QUIQQER"

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

requirements.tests.quiqqer.checksums.name = "Package integrity"
requirements.tests.quiqqer.checksums.desc = "Checks if the installed QUIQQER packages have been modified."

# Test messages
requirements.message.version.ok = "<p><strong>Installed:</strong> %VERSION%</p><p><strong>Required:</strong> %REQUIRED_VERSION%</p>"

requirements.error.memorylimit.undetected = "Could not detect the configured memory limit."

requirements.error.memorylimit.insufficient = "The configured memory limit is to low.
This can severly impact the QUIQQER.
QUIQQER will need at least 128M to perform correctly. <a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.module.dom.missing = "The PHP module 'dom' is not installed or not active.<br />
<b>Solution : </b><br />
Install the module via the package manager :
<pre><code>apt-get install php7.X-xml</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.module.xml.missing = "The PHP module 'xml' is not installed or not active.<br />
<b>Solution : </b><br />
Install the module via the package manager and restart the webserver :
<pre><code>apt-get install php7.X-xml</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.module.gzip.missing = "The PHP module 'gzip' is not installed or not active.<br />
<b>Solution : </b><br />
Install the module via the package manager and restart the webserver :
<pre><code>apt-get install php7.X-gzip</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.module.imagelibs.missing = "The PHP module 'gd' is not installed or not active.<br />
<b>Solution : </b><br />
Install the module via the package manager and restart the webserver :
<pre><code>apt-get install php7.X-gd</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.module.json.missing = "The PHP module 'json' is not installed or not active.<br />
<b>Solution : </b><br />
Install the module via the package manager and restart the webserver :
<pre><code>apt-get install php7.X-json</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.module.mbstring.missing = "The PHP module 'mbstring' is not installed or not active.<br />
<b>Solution : </b><br />
Install the module via the package manager and restart the webserver :
<pre><code>apt-get install php7.X-mbstring</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.module.pdo.missing = "The PHP module 'pdo_mysql' is not installed or not active.<br />
<b>Solution : </b><br />
Install the module via the package manager and restart the webserver :
<pre><code>apt-get install php7.X-mysql</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.module.curl.missing = "The PHP module 'curl' is not installed or not active.<br />
<b>Solution : </b><br />
Install the module via the package manager and restart the webserver :
<pre><code>apt-get install php7.X-curl</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.module.zip.missing = "The PHP module 'zip' is not installed or not active.<br />
<b>Solution : </b><br />
Install the module via the package manager and restart the webserver :
<pre><code>apt-get install php7.X-zip</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.module.iconv.missing = "The PHP module 'iconv' is not installed or not active.<br />
<b>Solution : </b><br />
Install the module via the package manager and restart the webserver :
<pre><code>apt-get install php7.X-iconv</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.version.insufficient = "The installed version of PHP is to low. Please install PHP5.6 or higher.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"


requirements.error.timezone.notset = "There is no default timezone configured.
This can have major impacts on QUIQQER.<br />
<b>Solution : </b><br />
Configure the timezone in the php.ini
<pre><code>date.timezone = UTC</code></pre>
<a href = "http://php.net/manual/de/timezones.php">List of supported timezones</a><br />
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Additional Help</a>"

requirements.error.session.autostart.enabled = "Sessionautostart is enabled.
Please disabled the session autostart.<br />
<b>Solution : </b><br />
Disable session.auto_start  in the php.ini
<pre><code>session.auto_start = 0</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Additional Help</a>"

requirements.error.uploads.deactivated = "Your system does not allow file uploads.
We recommend the permitting file uploads.<br />
To enable uploads set the following setting in your php.ini :
<pre><code>file_uploads = On</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.uploadsize.low = "The configured upload size is to low.
We recommnend  increasing the limit.<br />
To increase the limit set the following settings in the php.ini
<pre><code>upload_max_filesize = 8M
post_max_size = 8M</code></pre>
We recommend to set the limit to at least 8M. <a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.postsize.low = "The configured "Post max size" is to low.
We recommnend  increasing the limit.<br />
To increase the limit set the following settings in the php.ini
<pre><code>upload_max_filesize = 8M
post_max_size = 8M</code></pre>
We recommend to set the limit to at least 8M.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.geolocate.not.found = "GeoLocation support could not be detected.<br />
We recommend to enable geolocation support. <a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.webserver.headers.missing = "The module 'headers' was not found.<br />
<b>Solution : </b><br />
Enable the module and restart the webserver (Apache2) :
<pre><code>a2enmod headers && /etc/init.d/apache2 restart</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.webserver.ssl.disabled = "Die Verbindung wurde unverschlüsselt aufgebaut.
Wir empfehlen dringend Webserver Verbindungen zu verschlüsseln. <a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.webserver.rewrite.missing = "The module 'rewrite' was not found.<br />
<b>Solution : </b><br />
Enable the module and restart the webserver (Apache2) :
<pre><code>a2enmod rewrite && /etc/init.d/apache2 restart</code></pre>
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.mysql.connectivity = "Could not connect to the database. Please verify your connection settings are correct.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.mysql.version.incompatible.driver = "The chosen database driver is not supported.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.mysql.version.incompatible.version = "The installed database version is not supported.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>"

requirements.error.system.permissions = "The systems filepermissions are not correct.
Please make sure that the webservers user can write the following files and directories.
<a target = '_blank' href='https://dev.quiqqer.com/quiqqer/quiqqer/wikis/setup/vorraussetzungen#troubleshooting'>Help</a>
<pre><code>chown -R %USER% : %GROUP% %PATH%</code></pre>"

requirements.error.quiqqer.checksums = "Some packages contain modified or added files. You can find the modified packages and files below:"
requirements.error.quiqqer.checksums.missing = "Some packages could not be verified.This happens when the package author does not provide a checksum file. The following packages are imapcted by this:"

checksums.table.header.file = "Local file"
checksums.table.header.checksum.file = "Current Checksum"
checksums.table.header.checksum.local = "Desired checksum (local)"
checksums.table.header.checksum.remote = "Desired checksum (online)"

checksums.state.ok = "OK"
checksums.state.unknown = "Unknown"
checksums.state.modified = "Modified"
checksums.state.added = "Added"
checksums.state.removed = "Removed"

checksums.state.ok.desc = "The file is in its original state."
checksums.state.unknown.desc = "There are no checksums available to compare the file with."
checksums.state.modified.desc = "The file has modifications compared to its original state."
checksums.state.added.desc = "The file was added to the local filesystem."
checksums.state.removed.desc = "The file is missing on the local filesystem."

# Other
test.message.error.permission.file = "'./%FILE%' has the wrong permissions. Current: %CURRENT. Required: %REQUIRED%."
test.message.error.not.writeable.file = "'./%FILE%' is not writable"