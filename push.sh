#!/bin/bash
# ----------------------------------------------------------------------
# Script Auto Commit & Push - Standar v2.5
# ----------------------------------------------------------------------

# 1. Dapatkan nama branch aktif saat ini
BRANCH=$(git rev-parse --abbrev-ref HEAD 2>/dev/null)
if [ -z "$BRANCH" ]; then
  BRANCH="master"
fi

# 2. Dapatkan tanggal hari ini format YYMMDD
DATE=$(date +%y%m%d)

# 3. Input pesan commit jika tidak dilewatkan sebagai argumen
if [ -z "$1" ]; then
  echo "=== Git Auto Push Standard ==="
  echo "Masukkan tipe commit (e.g. Added, Fixed, Changed, Security):"
  read -r TYPE
  echo "Masukkan deskripsi commit:"
  read -r DESC
  COMMIT_MSG="${DATE} - [${TYPE}]: ${DESC}"
else
  COMMIT_MSG="${DATE} - $1"
fi

# 4. Validasi linting PHP sebelum commit
echo "=== Melakukan Linting PHP ==="
LINT_ERROR=0
for file in $(git diff --name-only --cached | grep '\.php$'); do
  if [ -f "$file" ]; then
    php -l "$file" > /dev/null 2>&1
    if [ $? -ne 0 ]; then
      echo "❌ Lint error terdeteksi pada file: $file"
      LINT_ERROR=1
    fi
  fi
done

if [ $LINT_ERROR -ne 0 ]; then
  echo "Aborting commit due to PHP syntax errors."
  exit 1
fi

# 5. Jalankan Git Commands
echo "Melakukan git add..."
git add .

echo "Melakukan git commit dengan pesan: '$COMMIT_MSG'..."
git commit -m "$COMMIT_MSG"

echo "Melakukan git push ke origin ${BRANCH}..."
git push origin "$BRANCH"
