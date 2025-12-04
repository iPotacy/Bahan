#!/bin/bash

# PHP Obfuscator - Quick Start Script
# This script helps you quickly obfuscate your PHP files

echo "======================================"
echo "   PHP Code Obfuscator Quick Start"
echo "======================================"
echo ""

# Check if input file is provided
if [ -z "$1" ]; then
    echo "Usage: ./quick_start.sh <php_file> [method]"
    echo ""
    echo "Methods:"
    echo "  1 or basic    - Basic obfuscation"
    echo "  2 or advanced - Advanced obfuscation"
    echo "  3 or extreme  - Extreme obfuscation (recommended)"
    echo ""
    echo "Example:"
    echo "  ./quick_start.sh myfile.php extreme"
    echo ""
    exit 1
fi

INPUT_FILE="$1"
METHOD="${2:-extreme}"

# Convert numeric method to name
case "$METHOD" in
    1)
        METHOD="basic"
        ;;
    2)
        METHOD="advanced"
        ;;
    3)
        METHOD="extreme"
        ;;
esac

# Check if file exists
if [ ! -f "$INPUT_FILE" ]; then
    echo "❌ Error: File not found: $INPUT_FILE"
    exit 1
fi

# Generate output filename
BASENAME=$(basename "$INPUT_FILE" .php)
OUTPUT_FILE="${BASENAME}_protected.php"

echo "📁 Input:  $INPUT_FILE"
echo "📁 Output: $OUTPUT_FILE"
echo "🔧 Method: $METHOD"
echo ""
echo "⏳ Processing..."
echo ""

# Run obfuscator
python3 obfuscator.py "$INPUT_FILE" "$OUTPUT_FILE" "$METHOD"

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Success! Your protected file is ready."
    echo ""
    echo "📋 Next steps:"
    echo "   1. Test the protected file"
    echo "   2. Backup your original file"
    echo "   3. Deploy the protected version"
    echo ""
else
    echo ""
    echo "❌ Obfuscation failed. Please check the error message above."
    exit 1
fi