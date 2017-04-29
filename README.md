# Astro-quiz [![GitHub release](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/ver20170421.svg "download")](https://github.com/pbrus/astro-quiz) ![Written in PHP](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/php.svg "language") ![Written in HTML](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/html.svg "language") ![Written in CSS](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/css.svg "language")

A little advanced quiz for astronomy enthusiasts. Designed for students and small groups of amateur astronomers.

![astro-quiz](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/astro-quiz.gif)

## Introduction

The program was designed to run locally, not in the Internet. The application uses a webbrowser only as an interface. For example, astro-quiz doesn't cooperate with any database but stores all information in text files and utilizes a session mechanism. However, it can be used by many users simultaneously, e.g. for students in a classroom (computers connected through LAN).

## Installation

### General information

I assume that you're not familiar with PHP applications and how to install them. Let's split the whole installation process into significant parts:
1. Download and install [*XAMPP*](https://www.apachefriends.org/download.html) with PHP 7.0 or greater
2. Install [*Composer*](https://getcomposer.org/download/)
3. Change the localhost path just editing two lines in `httpd.conf` file
4. Start/restart *XAMPP*
5. Open yor favourite web browser and type `localhost` into the address bar

Note that this is the easiest way to install the application because the program does't worry about security in the Internet.

### Linux

Execute first two instructions from the **General information** section manually. If you successfully install *XAMPP* with default settings, `php` should be located at `/opt/lampp/bin/`. After installation I recommend to move the `composer.phar` file to any catalog pointed by the `$PATH` variable and to change it's name to `composer`.

In the next step choose the destination directory where you want to install application, open a terminal window and go there. Download the repo and all required components typing:
```bash
$ composer require pbrus/astro-quiz=dev-master
```
Instructions included in 3. and 4. lines will be executed automatically by `install` script. To do this log in as root:
```bash
$ su
```
and run the script:
```bash
$ bash vendor/pbrus/astro-quiz/install
```
If everything goes well, you will see the message **The installation is complete**. It's time to open your web browser and test the application typing `localhost` into the address bar.
