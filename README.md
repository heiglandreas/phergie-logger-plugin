# phergie-logger-plugin

This is a plugin for phergie.

It can be used to log an IRC-Channel to disk using a PSR3-Logger.

## Usage:

1. require the logger-plugin: ```composer require org_heigl/phergie-logger-plugin```
2. add the plugin to the plugins-array: ```new LoggerPLugin($logger, $parser);```
