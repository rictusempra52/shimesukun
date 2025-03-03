# 🏢 分識マンション管理システム「しめすくん」 設計書

## **1. 概要**

本システムは、分識マンションの管理業務を効率化するためのプラットフォームです。  
マンションの重要書類を **電子化・Web 化** し、**高度な AI 検索** を提供します。

## **2. 機能一覧**

-   📝 **書類管理**
    -   PDF アップロード・OCR 処理（テキスト抽出）
    -   書類の全文検索・AI 応答機能
-   🏢 **マンション情報管理**
    -   マンションごとの基本情報（住所・築年数・総房数など）
    -   書類との結び付け
-   🛠️ **管理会社向け機能**
    -   マンションごとの書類を統合管理
    -   居住者向けのアクセス制御
-   🔍 **AI による質問応答**
    -   書類を基にした高度な Q&A 機能（NotebookLM 的な機能）
    -   検索性の向上（全文検索 + 自然言語処理）

---

## **3. システム構成**

```mermaid
graph TD;
    subgraph ユーザー
        A[管理会社] -->|Web| B[管理システム]
        C[居住者] -->|Web| B
    end

    subgraph バックエンド
        B[管理システム] -->|API| D[データベース]
        B -->|Storage| E[書類保存]
        B -->|OCR処理| F[AIエンジン]
    end

    subgraph データレイヤー
        D[データベース] -->|Management Data| G[buildingsテーブル]
        D -->|Documents| H[documentsテーブル]
    end
```

---


## **7. データベース設計**

## **📌 ER 図**
```mermaid
erDiagram
    COMPANIES ||--o{ BUILDINGS : "管理"
    BUILDINGS ||--o{ DOCUMENTS : "書類管理"
    USERS ||--o{ DOCUMENTS : "アップロード"
    USERS ||--o{ BUILDINGS : "管理"

    COMPANIES {
        bigint id PK
        string name "会社名"
        string address "住所"
    }

    BUILDINGS {
        bigint id PK
        bigint company_id FK "管理会社ID"
        string name "マンション名"
        string address "住所"
        int unit_count "総戸数"
        year built_year "築年"
    }

    DOCUMENTS {
        bigint id PK
        bigint building_id FK "マンションID"
        bigint user_id FK "アップロードしたユーザー"
        string title "書類タイトル"
        string file_path "PDFファイルパス"
        text ocr_text "OCRテキスト"
    }

    USERS {
        bigint id PK
        string name "ユーザー名"
        string email "メールアドレス"
        string password "パスワード"
    }
```
