#!/usr/bin/env bash -e

TEMPFILE="$(mktemp)"
BINPATH="$(dirname $0)"

echo "Creating UnboundedOccursPaths.json on $TEMPFILE"
php "${BINPATH}/max-occurs-paths.php" > "$TEMPFILE"

echo "Comparing to current UnboundedOccursPaths.json"
diff -u -b -B "${BINPATH}/../src/UnboundedOccursPaths.json" "$TEMPFILE"

echo "OK: Files match"
rm "$TEMPFILE"
