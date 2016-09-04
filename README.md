# Travian-CLI

Travian-CLI is a CLI for the online game Travian. Current aims are:

* Being able to read data from the game to either CSV or human-readable form
* Being able to give all commands one would be able to give in-game

Travian-CLI is currently incomplete and under development.

Travian-CLI uses Composer. Having installed composer, one should run `composer install` in the root directory of this project in order for the program to function properly.

### Installation

**The composer way**

- Run command `composer global require timpack/travian-cli`
- Add directory `~/.config/composer/vendor/bin` to your `$PATH` variable

**The git way**
- Run command `git clone git@github.com:Desmaster/travian-cli.git`
- In that directory, run command `composer install`
- Then run the application using `app/console` 

### Requirements

- php >= 7.0
- composer

### Developed using

- php >= 7.0
- linux kernel >= 4.4
