Echo Message Server (PHP)
This project is a simple client-server echo application built with PHP.

Features
Accepts messages from a client via POST (e.g. PowerShell, cURL).

Accepts messages from a browser via GET.

Stores all messages in a SQLite database for persistence.

Displays messages:

In PowerShell as JSON (after POST).

In the web browser as styled HTML (after POST or GET).

Technologies
PHP (built-in web server)

SQLite (file-based database)

PowerShell or any HTTP client

HTML (basic output)

How It Works
The client sends a message via POST (JSON body) or GET (?mensaje=...).

The PHP server receives and stores the message in mensajes_db.sqlite.

The message is returned as JSON (for the client) and displayed in the browser.
