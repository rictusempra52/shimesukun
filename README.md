# マンション書類管理システム

マンションの書類をデジタル化して管理するシステムです。PDFや画像をアップロードし、OCR機能でテキストを抽出して検索可能にします。

## 主な機能

- 書類のアップロード・管理
  - PDF、JPG、PNGファイルに対応
  - タイトル、マンション、日付による管理
  - OCRによるテキスト抽出（PDFのみ）

- 書類の検索
  - マンションごとの書類一覧
  - タイトル・本文による全文検索
  - アップロード日時による並び替え

- マンション・管理会社の管理
  - マンションと管理会社の紐付け
  - 住所、戸数などの基本情報管理

## 必要要件

- PHP 8.1以上
- MySQL 5.7以上
- Composer
- Node.js 16以上
- Tesseract OCR（PDFからのテキスト抽出に使用）

## インストール

1. リポジトリのクローン
```bash
git clone [リポジトリURL]
cd [プロジェクトディレクトリ]
```

2. 依存パッケージのインストール
```bash
composer install
npm install
```

3. 環境設定
```bash
cp .env.example .env
php artisan key:generate
```

4. データベースの設定
`.env`ファイルでデータベースの接続情報を設定します：
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shimesukun
DB_USERNAME=[ユーザー名]
DB_PASSWORD=[パスワード]
```

5. データベースのマイグレーション
```bash
php artisan migrate
php artisan db:seed  # テストデータの作成
```

6. ストレージのリンク作成
```bash
php artisan storage:link
```

7. ビルド & 実行
```bash
npm run build
php artisan serve
```

## 使用方法

1. ログイン
   - デフォルトのテストアカウント:
     - 管理者: admin@example.com / password
     - 一般: test@example.com / password

2. 書類のアップロード
   - 「新規アップロード」ボタンから書類をアップロード
   - マンション、タイトル、ファイルを選択
   - PDFの場合は自動でテキスト抽出

3. 書類の検索・閲覧
   - マンションを選択して絞り込み
   - キーワードで検索
   - 一覧から書類を選択して詳細表示

## OCR機能について

PDFファイルをアップロードすると、Tesseract OCRを使用して自動的にテキストを抽出します。抽出されたテキストは検索対象となり、書類の検索性を向上させます。

### OCR対応フォーマット
- PDF（日本語・英語対応）

## 開発者向け情報

### ディレクトリ構成

```
app/
├── Http/
│   ├── Controllers/    # コントローラー
│   └── Requests/       # フォームリクエスト
├── Models/             # モデル
└── Services/          # ビジネスロジック
```

### 主要なファイル

- `DocumentController.php`: 書類管理の主要な処理
- `BuildingController.php`: マンション管理
- `CompanyController.php`: 管理会社管理

### テスト

```bash
php artisan test
```

## ライセンス

MIT License

## 作者

株式会社分識

## サポート

不具合や要望は、GitHubのIssueでお知らせください。
