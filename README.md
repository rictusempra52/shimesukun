# 書類管理システム

マンションの書類管理を行うWebアプリケーションです。PDF・画像ファイルのアップロードとOCRによるテキスト抽出機能を提供します。

## 主な機能

- 書類のアップロード（PDF、JPG、PNG形式）
- OCRによるテキスト抽出（日本語対応）
- マンションごとの書類管理
- キーワード検索機能
- ユーザー認証

## 技術スタック

- Laravel 10.x
- PHP 8.2
- MySQL 8.0
- Nginx
- Docker
- Tesseract OCR（日本語対応）
- Tailwind CSS

## 開発環境のセットアップ

### 必要なソフトウェア

- Docker Desktop
- Git

### セットアップ手順

1. リポジトリをクローン
```bash
git clone [repository-url]
cd shimesukun
```

2. 環境設定
```bash
# .envファイルのコピー
cp .env.example .env
```

3. Dockerコンテナの起動
```bash
docker-compose up -d
```

4. アプリケーションのセットアップ
```bash
# コンテナ内でコマンドを実行
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan storage:link
docker-compose exec app php artisan migrate:fresh --seed
docker-compose exec app npm install
docker-compose exec app npm run build
```

5. アクセス
- アプリケーション: http://localhost
- phpMyAdmin: http://localhost:8080
  - サーバー: db
  - ユーザー名: shimesukun
  - パスワード: password

### 初期ユーザー

- 管理者アカウント
  - メール: admin@example.com
  - パスワード: password

- テストユーザー
  - メール: test@example.com
  - パスワード: password

## 開発環境での作業

### コンテナの操作

```bash
# コンテナの起動
docker-compose up -d

# コンテナの停止
docker-compose down

# コンテナのログ確認
docker-compose logs -f

# コンテナ内でコマンド実行
docker-compose exec app php artisan [command]
```

### アセットのビルド

```bash
# 開発時の監視
docker-compose exec app npm run dev

# 本番用ビルド
docker-compose exec app npm run build
```

### データベースのリセット

```bash
docker-compose exec app php artisan migrate:fresh --seed
```

## ディレクトリ構造

主要なディレクトリと役割：

```
shimesukun/
├── app/                    # アプリケーションのコアコード
│   ├── Http/              # コントローラー、ミドルウェア、リクエスト
│   └── Models/            # Eloquentモデル
├── database/              # マイグレーション、シーダー
├── docker/               # Dockerの設定ファイル
├── resources/           # ビュー、CSS、JavaScript
└── storage/            # アップロードされたファイル
```

## 機能の詳細

### 書類管理機能

- PDF・画像ファイルのアップロード（最大10MB）
- OCRによるテキスト抽出（Tesseract OCR使用）
- マンションごとの分類
- キーワード検索（タイトル・OCRテキスト）

### ユーザー管理機能

- ログイン・ログアウト
- パスワードリセット
- アクセス制限

## 注意事項

- 本番環境では必ずAPP_DEBUGをfalseに設定してください
- ストレージのシンボリックリンクは必ず作成してください
- アップロードされたファイルは定期的にバックアップを取ることを推奨します

## ライセンス

[MIT License](LICENSE)
