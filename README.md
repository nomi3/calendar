## セットアップ

### 1. リポジトリをクローン

```bash
git clone https://github.com/nomi3/calender.git
```

### 2. ディレクトリに移動

```bash
cd calender
```

### 3. vender パッケージをインストール

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

### 4. 一度起動する

```bash
./vendor/bin/sail up -d
```

### 5. .env ファイルを作成

decrypt 用の key は担当者が渡すものを使ってください。

```bash
./vendor/bin/sail artisan env:decrypt --key="base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx="
```

### 6. マイグレーション

```bash
./vendor/bin/sail artisan migrate
```
