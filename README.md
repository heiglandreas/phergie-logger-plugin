# phergie-logger-plugin

This is a plugin for phergie.

It can be used to log an IRC-Channel to disk using a PSR3-Logger.

## Usage:

1. require the logger-plugin: `
    ```composer require org_heigl/phergie-logger-plugin```
2. Create a LoggerOptions-Instance with a Parser
    ```$config = new LoggerConfiguration(new \Phergie\Irc\Parser());```
3. Create  PSR-3 compatible logger for the channels to be logged:
    ```$logger = new \Monolog/Logger('name');```
4. Add the logger as logger for a channel to the Configuration:
    ```$config->addLogger($logger, '#channelname');
5. add the plugin to the plugins-array:
    ```new LoggerPLugin($config);```
