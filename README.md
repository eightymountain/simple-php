# simple-php

누가 이런 끔찍한 혼종을 만들어냈단 말인가!

![496435cd8e6b46269cf2d96b9e598103a752d18f](https://user-images.githubusercontent.com/45650509/110643775-cc559c80-81f7-11eb-97a0-318b06926a7a.jpg)

## PHP 7.4.\* 이상 사용

## 첫 설정

- .env.example 파일을 .env 로 복사한 후 설정값을 넣어줍니다.

- composer가 없다면 설치를 해줍니다.

  ##### Linux

  ```bash
  // install
  curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin/

  // symbolic link
  sudo ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
  ```

  ##### Windows

  [설치파일 다운로드](https://getcomposer.org/Composer-Setup.exe)

- composer install

  터미널에서 프로젝트 root로 디렉토리 이동 후 아래 명령어를 실행해줍니다.

  ```bash
  composer iSnstall
  ```

## 폴더, 파일 구조

- `app` class로 작성된 php 코드(view 에서 사용)

- `asset` javascript, css, image

- `dist` 템플릿 원본

- `lib` class로 작성된 php 코드(모듈)

- `pages` 사용자에게 제공되는 view

  - `layout` 공통으로 사용되는 view

- `skel` 소스코드 기본 프레임

- `vendor` 의존성 라이브러리

## lib 폴더의 class에 변경사항이 있다면 아래 명령어를 꼭 실행해 줍니다.

```bash
composer dump-autoload
```

## ~~로깅~~

커밍순..ㅠㅠ
~~monolog wrapper~~

```php
<?php
use Lib\Log;

Log::debug({MESSAGE}, {CONTEXT});
Log::info({MESSAGE}, {CONTEXT});
Log::notice({MESSAGE}, {CONTEXT});
Log::warning({MESSAGE}, {CONTEXT});
Log::error({MESSAGE}, {CONTEXT});
Log::critical({MESSAGE}, {CONTEXT});
Log::alert({MESSAGE}, {CONTEXT});
```

## php built-in server

```bash
// project의 root에 위치하여 아래 명령어를 실행
php -S DOMAIN.NAME:PORT -t

// ex
-S localhost:8080 -t
```

## nginx 사용

```
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```


## SQL
[링크](https://github.com/eightymountain/simple-php/wiki/SQL)
