# Astro-quiz
[![GitHub release](https://img.shields.io/badge/ver.-0.1.0-brightgreen.svg "download")](https://github.com/pbrus/astro-quiz)
[![Written in PHP](https://img.shields.io/badge/code-PHP-blue.svg "language")](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-yellow.svg "MIT license")](https://github.com/pbrus/astro-quiz/blob/master/LICENSE)
[![License](https://img.shields.io/badge/license-SIL-orange.svg "SIL license")](https://github.com/pbrus/astro-quiz/blob/master/LICENSE)
[![License](https://img.shields.io/badge/license-CC--BY--NC-lightgray.svg "CC-BY-NC license")](https://github.com/pbrus/astro-quiz/blob/master/LICENSE)

A little advanced quiz for astronomy enthusiasts. Designed for students and small groups of amateur astronomers.

![astro-quiz](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/astro-quiz.gif)

## Introduction

The program was designed to run locally, not on the Internet. The application uses a web browser only as an interface. For example, **astro-quiz** doesn't cooperate with any database but stores all information in text files and utilizes a session mechanism. However, it can be used by many users simultaneously, e.g. for students in a classroom (computers connected through LAN).

## Installation

### General information

I assume that you're not familiar with PHP applications and how to install them. Let's split the whole installation process into significant parts:
1. Download and install [*XAMPP*](https://www.apachefriends.org/download.html) with PHP 7.0 or greater
2. Install [*Composer*](https://getcomposer.org/) for [Linux](https://getcomposer.org/download/) or [Windows](https://getcomposer.org/doc/00-intro.md#installation-windows)
3. Change the localhost path just editing two lines in `httpd.conf` file
4. Start/restart *XAMPP*
5. Open yor favourite web browser and type `localhost` into the address bar

Note that this is the easiest way to install the application because the program does't worry about security on the Internet.

### Linux

Execute first two instructions from the **General information** section manually. If you successfully install *XAMPP* with default settings, `php` should be located in the `/opt/lampp/bin/` directory. After installation I recommend to move the `composer.phar` file to any catalog pointed by the `$PATH` variable and to change its name to `composer`.

In the next step choose the destination directory where you want to install application, open a terminal window and go there. Download the repo and all required components typing:
```bash
$ composer require pbrus/astro-quiz=dev-master
```
Instructions included in 3. and 4. lines will be executed automatically by the `install` script. To do this log in as root:
```bash
$ su
```
and run the script:
```bash
$ bash vendor/pbrus/astro-quiz/install
```
Note that the use of `sudo` instead of `su` sometimes can't call `composer`. If everything goes well, you will see the message **The installation has been completed**. It's time to open your web browser and test the application typing `localhost` into the address bar.

To start *XAMPP* after computer rebooting type into the terminal window:
```bash
$ sudo /opt/lampp/lampp start
```

### Windows

Execute first two instructions from the **General information** section manually. If you successfully install *XAMPP* with default settings, `php.exe` should be located in the `C:\xampp\php\` directory. Note that you have to point at the `php.exe` file during *Composer* installation.

![composer-install](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/composer-install.png)

In the next step create an empty directory to store the whole project. Let's assume that it will be the `astro-quiz` located in `D:\`, i.e. `D:\astro-quiz\`. Open the [*cmd.exe*](https://en.wikipedia.org/wiki/Cmd.exe) and go there typing:
```cmd
> D:
```
and further:
```cmd
> cd astro-quiz
```
Now it's time to download the project using *Composer*. Please type into *cmd.exe*:
```cmd
> composer require pbrus/astro-quiz=dev-master
```
Then copy all files and directories from `D:\astro-quiz\vendor\pbrus\astro-quiz\` to `D:\astro-quiz\` (just change the structure of the project). After all, type into *cmd.exe*:
```cmd
> composer dump-autoload
```
Note that your current localization must be `D:\astro-quiz\`.

At the end you must connect `localhost` with the project's directory. To do this open the *XAMPP Control Panel* and edit two lines in the `httpd.conf` file:
```
DocumentRoot "C:/xampp/htdocs"
<Directory "C:/xampp/htdocs">
```
```
DocumentRoot "D:/astro-quiz"
<Directory "D:/astro-quiz">
```

![localhost-edit](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/localhost-edit.png)

Save changes and start/restart *Apache*. Open your web browser and test the application typing `localhost` into the address bar.

To start *XAMPP* after computer rebooting open the *XAMPP Control Panel* and start the *Apache* module.

## Usage

The package contains demo files so you can easily test **astro-quiz** after the installation process. Of course you can prepare your own questions. Let's see the most important parts of the project.

### Web browser

A web browser is a [BUI](https://en.wikipedia.org/wiki/Browser_user_interface) for users and an administrator which oversees the users. To start quiz type into the address bar `localhost`. To see results, statistics and to manage the database please type into address bar `localhost/admin.php`. Access to this page is secured by the password stored in the `astroquiz.cfg` file.

### Define own quiz

All files needed to define own quiz must be located in the `files/` directory. You should create a text file to store all questions, points, answers and names of images if are required. You can create as many text files as you need. The current quiz is called in the `astroquiz.cfg` file.

I encourage to visit my website to see more detailed description of this project. The current link can be found on my [GitHub profile](https://github.com/pbrus).

## Credits

 * [Pure CSS Circular Percentage Bar](http://www.cssscript.com/pure-css-circular-percentage-bar/)

    Used on the last page with results.

 * [Fontello - icon fonts generator](http://fontello.com/)

   Used icons:
   * *icon-check*
   * *icon-check-empty*
   * *icon-right-circled2*

 * Demo images from [My subjective astronomy](https://mozdzierski.wordpress.com/my-subjective-astronomy/)

   Used files:
   * *question1.jpg*
   * *question2.jpg*
   * *question4.jpg*
   * *question5.jpg*

## License

**Astro-quiz** is licensed under the [MIT license](http://opensource.org/licenses/MIT). Some external components have own licenses. See the [license](https://github.com/pbrus/astro-quiz/blob/master/LICENSE) file for more details.
