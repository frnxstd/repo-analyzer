# GitHub Repository Analyzer

It's made for fun. There is really simple and basic idea behind of this code. If you know your concerns about an open-source repository, it will collect the data from GitHub
APIv3 and summarize it in a row. It's easy to install, customize and use. It's so simple, because simple is the best!

### Install

We have a few steps before we kickstart. It requires no DB connection! It just works with cached GitHub APIv3 response!

```
$ git clone https://github.com/frnxstd/repo-analyzer
$ composer install
$ php artisan serve
```

>Please do not forget to configure .env for your expectations. `.env.example` file may help you. Otherwise it will use
>defaults.


### How to use?

Write or copy and paste :owner/:repo path of the URL. Let's check this repository.

![Example usage](public/img/home.png)

Bob is your uncle!