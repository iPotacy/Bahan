# PHP Code Obfuscator - DeckPHP Style

Tool untuk melakukan obfuscation kode PHP dengan gaya mirip DeckPHP. Tool ini menggunakan Python dan bisa dijalankan langsung di terminal.

## 🚀 Fitur

- **3 Level Obfuscation**: Basic, Advanced, dan Extreme
- **Hex Encoding**: String dikonversi ke hexadecimal
- **Base64 Multi-Layer**: Encoding berlapis untuk keamanan ekstra
- **Random Variable Names**: Nama variabel acak dengan karakter unicode
- **Global Array Storage**: Data tersimpan dalam array global terenkripsi
- **Pack/Unpack**: Encoding tambahan menggunakan pack()
- **Dummy Variables**: Variabel palsu untuk membingungkan reverse engineering

## 📋 Requirements

- Python 3.x
- Tidak perlu dependency tambahan (hanya menggunakan library standard Python)

## 🎯 Cara Penggunaan

### Sintaks Dasar:
```bash
python3 obfuscator.py <input_file> [output_file] [method]
```

### Parameter:
- `input_file`: File PHP yang akan di-obfuscate (wajib)
- `output_file`: Nama file output (opsional, default: input_obfuscated.php)
- `method`: Metode obfuscation (opsional, default: basic)
  - `basic` - Obfuscation dasar (cepat)
  - `advanced` - Obfuscation lanjutan dengan multi-layer
  - `extreme` - Obfuscation ekstrem (DeckPHP style)

## 💡 Contoh Penggunaan

### 1. Basic Obfuscation (Default)
```bash
python3 obfuscator.py input.php
# Output: input_obfuscated.php
```

### 2. Advanced Obfuscation
```bash
python3 obfuscator.py input.php output.php advanced
```

### 3. Extreme Obfuscation (DeckPHP Style)
```bash
python3 obfuscator.py input.php output.php extreme
```

### 4. Contoh Lengkap
```bash
# Obfuscate dengan metode extreme dan nama file custom
python3 obfuscator.py my_script.php my_script_protected.php extreme
```

## 📊 Output Example

### Input (Original):
```php
<?php
echo "Hello World!";
$name = "User";
echo "Welcome, " . $name;
?>
```

### Output (Extreme Method):
```php
<?php
/*
 本代码由 DeckPHP Beta [ V2.0.5 ] 创建
 创建时间 2025-12-04 18:35:35
 技术支持 
 严禁反编译、逆向等任何形式的侵权行为，违者将追究法律责任
*/
if(!defined('EQKRGHHQIIS'))define('EQKRGHHQIIS', 'EQKRGHHQ');
$GLOBALS[EQKRGHHQIIS]=explode('|;|@|','H*|;|@|3F3E|;|@|626173...');
unset($š"ê);$š"ê;
eval(pack($GLOBALS[EQKRGHHQIIS][(5+6+7-18)*0],$GLOBALS[EQKRGHHQIIS][1]).
base64_decode('Ly8gU2FtcGxlIFBIUCBjb2RlIHRvIGJlIG9iZnVzY2F0ZWQ...'));
unset($¥¥¬ú);$¥¥¬ú;
?>
```

## 🔍 Perbandingan Metode

| Metode   | Kecepatan | Keamanan | Size Overhead | Recommended For |
|----------|-----------|----------|---------------|-----------------|
| Basic    | ⚡⚡⚡     | 🔒🔒     | ~360%         | Testing, Development |
| Advanced | ⚡⚡       | 🔒🔒🔒   | ~510%         | Production Code |
| Extreme  | ⚡         | 🔒🔒🔒🔒 | ~512%         | High Security Needs |

## ⚙️ Cara Kerja

1. **Cleaning**: Membersihkan PHP tags dari kode input
2. **Encoding**: Base64 encoding dengan multi-layer (untuk advanced/extreme)
3. **Hex Conversion**: Konversi string fungsi ke hexadecimal
4. **Array Building**: Membuat array global dengan data terenkripsi
5. **Variable Randomization**: Generate nama variabel acak dengan unicode
6. **Code Assembly**: Menyusun kode final dengan pack() dan eval()

## 📁 File Structure

```
obfuscator.py           # Main obfuscator script
sample.php              # Sample input file
sample_basic.php        # Basic obfuscation result
sample_advanced.php     # Advanced obfuscation result
sample_extreme.php      # Extreme obfuscation result
README.md              # This file
```

## ⚠️ Catatan Penting

1. **Backup**: Selalu backup file asli sebelum obfuscation
2. **Testing**: Test file ter-obfuscate di environment testing dulu
3. **Performance**: File ter-obfuscate akan lebih lambat sedikit karena proses decode
4. **Size**: Ukuran file akan bertambah 3-5x lipat
5. **Debugging**: Kode ter-obfuscate sulit untuk di-debug
6. **Legal**: Gunakan hanya untuk melindungi kode Anda sendiri

## 🛡️ Security Features

- Random global variable names
- Unicode dummy variables
- Hex-encoded function names
- Multi-layer base64 encoding
- Pack/unpack obfuscation
- Chinese warning header (legal protection)

## 📝 Tips

1. **Untuk Production**: Gunakan metode `extreme`
2. **Untuk Testing**: Gunakan metode `basic`
3. **File Besar**: Advanced method lebih efisien
4. **Multiple Files**: Buat bash script untuk batch processing

## 🔧 Troubleshooting

**Q: File hasil tidak jalan?**
A: Pastikan PHP syntax original sudah benar sebelum di-obfuscate

**Q: Error "file not found"?**
A: Check path file input Anda

**Q: Output terlalu besar?**
A: Gunakan metode `basic` untuk file size lebih kecil

## 📜 License

Tool ini dibuat untuk keperluan educational dan protection. 
Gunakan dengan bijak dan bertanggung jawab.

## 🤝 Support

Untuk pertanyaan atau bug report, silakan hubungi developer.

---

**Created with ❤️ for PHP Developers**