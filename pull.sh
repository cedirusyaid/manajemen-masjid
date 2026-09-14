#!/bin/bash

# Auto-detect current branch and strip carriage returns/newlines
BRANCH=$(git rev-parse --abbrev-ref HEAD 2>/dev/null | tr -d '\r\n')
if [ -z "$BRANCH" ]; then
    BRANCH="main"
fi

echo "=== Git Auto Pull & Migrate Script ==="
echo "----------------------------------------"
echo "📥 Menarik perubahan terbaru dari origin branch: $BRANCH..."
git pull origin "$BRANCH" --no-rebase

echo "----------------------------------------"
if [ -f "spark" ]; then
    echo "🧹 Membersihkan cache CodeIgniter..."
    php spark cache:clear

    echo "----------------------------------------"
    echo "🗄️ Menjalankan migrasi database..."
    php spark migrate --no-interaction
elif [ -f "artisan" ]; then
    echo "🧹 Membersihkan cache Laravel..."
    php artisan optimize:clear

    echo "----------------------------------------"
    echo "🗄️ Menjalankan migrasi database..."
    php artisan migrate --force
else
    echo "⚠️ File framework (spark/artisan) tidak ditemukan, melewati tahap cache & migrate."
fi

echo "----------------------------------------"
echo "✅ Selesai! Sistem sudah up-to-date."
