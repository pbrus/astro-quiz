# Astro-quiz [![GitHub release](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/ver20170419.svg "download")](https://github.com/PBrus/Astro-quiz) ![Written in PHP](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/Php.svg "language") ![Written in HTML](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/Html.svg "language") ![Written in CSS](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/Css.svg "language")

A little advanced quiz for astronomy enthusiasts. Designed for students and small groups of amateur astronomers.

![astro-quiz](http://www.astro.uni.wroc.pl/ludzie/brus/img/github/Astro_quiz.gif)

## Introduction

The program was designed to run locally, not in the Internet. The application uses a webbrowser only as an interface. For example, astro-quiz doesn't cooperate with any database but stores all information in text files and utilizes a session mechanism. However, it can be used by many users simultaneously, e.g. for students in a classroom (computers connected through LAN).

## Installation

### General information

I assume that you're not familiar with PHP applications and how to install them. Let's split the whole installation process into significant parts:
1. Download and install [*XAMPP*](https://www.apachefriends.org/download.html) with PHP 7.0 or greater
2. Install [*Composer*](https://getcomposer.org/download/)

   If you successfully install *XAMPP* with default settings, `php` should be located at `/opt/lampp/bin/`
3. ...

Note that this is the easiest way to install the application because the program does't worry about security in the Internet.
