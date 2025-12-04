#!/usr/bin/env python3
"""
PHP Code Obfuscator
Similar to DeckPHP style obfuscation
"""

import base64
import random
import string
import sys
from datetime import datetime

class PHPObfuscator:
    def __init__(self):
        self.separator = '|;|@|'
        self.global_var = self.generate_random_var_name()
        
    def generate_random_var_name(self):
        """Generate random variable name like AAA____A_"""
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
    
    def obfuscate_basic(self, php_code):
        """Basic obfuscation method"""
        # Clean PHP tags
        php_code = php_code.strip()
        php_code = php_code.replace('<?php', '').replace('?>', '').strip()
        
        # Encode the code
        encoded = base64.b64encode(php_code.encode('utf-8')).decode('utf-8')
        
        # Create data array with hex encoded strings
        data_array = [
            'H*',
            self.str_to_hex('3F3E'),  # ?>
            self.str_to_hex('base64_decode'),
            self.str_to_hex('eval'),
            self.str_to_hex('pack'),
            self.str_to_hex('str_rot13'),
            self.str_to_hex('gzinflate'),
            self.str_to_hex('strrev'),
            self.str_to_hex('unserialize'),
            self.str_to_hex('gzuncompress'),
        ]
        
        data_string = self.separator.join(str(x) for x in data_array)
        
        # Generate dummy variables
        dummy_var1 = self.generate_random_unicode_var()
        dummy_var2 = self.generate_random_unicode_var()
        
        # Build obfuscated code
        obfuscated = "<?php\n"
        obfuscated += "/*\n"
        obfuscated += "DECK PHP VERSION ONE\n"
        obfuscated += f" FUCK OBFUSCATE {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}\n"
        obfuscated += " RUSHERCLOUD \n"
        obfuscated += " RUSHERCLOUD CHANNEL\n"
        obfuscated += "*/\n"
        
        # Main obfuscation logic
        random_const = self.global_var[:8]
        obfuscated += f"if(!defined('{self.global_var}'))define('{self.global_var}', '{random_const}');"
        obfuscated += f"$GLOBALS[{self.global_var}]=explode('{self.separator}','{data_string}');"
        obfuscated += f"unset({dummy_var1});{dummy_var1};"
        obfuscated += f"eval(pack($GLOBALS[{self.global_var}][0],$GLOBALS[{self.global_var}][1]).base64_decode('{encoded}'));"
        obfuscated += f"unset({dummy_var2});{dummy_var2};"
        obfuscated += "\n?>"
        
        return obfuscated
    
    def obfuscate_advanced(self, php_code):
        """Advanced obfuscation with multiple layers"""
        # Clean PHP tags
        php_code = php_code.strip()
        php_code = php_code.replace('<?php', '').replace('?>', '').strip()
        
        # Multi-layer encoding
        layer1 = base64.b64encode(php_code.encode('utf-8')).decode('utf-8')
        layer2 = base64.b64encode(layer1.encode('utf-8')).decode('utf-8')
        
        # Create extended data array
        data_array = [
            'H*',
            self.str_to_hex('3F3E'),
            self.str_to_hex('base64_decode'),
            self.str_to_hex('eval'),
            self.str_to_hex('pack'),
            self.str_to_hex('str_rot13'),
            self.str_to_hex('gzinflate'),
            self.str_to_hex('strrev'),
            self.str_to_hex('curl_exec'),
            self.str_to_hex('tap'),
            self.str_to_hex('curl_init'),
            self.str_to_hex('curl_setopt_array'),
            self.str_to_hex('CURLOPT_RETURNTRANSFER'),
            self.str_to_hex('CURLOPT_FOLLOWLOCATION'),
            self.str_to_hex('CURLOPT_USERAGENT'),
            self.str_to_hex('Mozilla/5.0'),
        ]
        
        data_string = self.separator.join(str(x) for x in data_array)
        
        # Generate multiple dummy variables
        dummy_vars = [self.generate_random_unicode_var() for _ in range(5)]
        
        # Build obfuscated code
        obfuscated = "<?php\n"
        obfuscated += "/*\n"
        obfuscated += "DECK PHP VERSION ONE\n"
        obfuscated += f" FUCK OBFUSCATE {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}\n"
        obfuscated += " RUSHERCLOUD \n"
        obfuscated += " RUSHERCLOUD CHANNEL\n"
        obfuscated += "*/\n"
        
        random_const = self.global_var[:8]
        obfuscated += f"if(!defined('{self.global_var}'))define('{self.global_var}', '{random_const}');"
        obfuscated += f"$GLOBALS[{self.global_var}]=explode('{self.separator}','{data_string}');"
        obfuscated += f"unset({dummy_vars[0]});{dummy_vars[0]};"
        
        # Advanced multi-layer decoding
        obfuscated += f"eval("
        obfuscated += f"pack($GLOBALS[{self.global_var}][0],$GLOBALS[{self.global_var}][1])."
        obfuscated += f"base64_decode("
        obfuscated += f"base64_decode("
        obfuscated += f"'{layer2}'"
        obfuscated += f")));"
        
        obfuscated += f"unset({dummy_vars[1]});{dummy_vars[1]};"
        obfuscated += "\n?>"
        
        return obfuscated
    
    def obfuscate_extreme(self, php_code):
        """Extreme obfuscation like DeckPHP example"""
        # Clean PHP tags
        php_code = php_code.strip()
        php_code = php_code.replace('<?php', '').replace('?>', '').strip()
        
        # Encode
        encoded = base64.b64encode(php_code.encode('utf-8')).decode('utf-8')
        
        # Create complex data array (similar to your example)
        data_array = [
            'H*',
            '3F3E',
            self.str_to_hex('base64_decode'),
            self.str_to_hex('curl_exec'),
            self.str_to_hex('tap'),
            self.str_to_hex('curl_init'),
            self.str_to_hex('https://raw.githubusercontent.com/example/shell/main/v3.php'),
            self.str_to_hex('curl_setopt_array'),
            self.str_to_hex('CURLOPT_RETURNTRANSFER'),
            self.str_to_hex('CURLOPT_FOLLOWLOCATION'),
            self.str_to_hex('CURLOPT_USERAGENT'),
            self.str_to_hex('Mozilla/5.0'),
            self.str_to_hex('CURLOPT_SSL_VERIFYPEER'),
            self.str_to_hex('CURLOPT_SSL_VERIFYHOST'),
        ]
        
        data_string = self.separator.join(str(x) for x in data_array)
        
        # Complex variable names
        dummy_var1 = self.generate_random_unicode_var()
        dummy_var2 = self.generate_random_unicode_var()
        func_var1 = ''.join(random.choice(string.ascii_uppercase) for _ in range(7))
        func_var2 = ''.join(random.choice(string.ascii_uppercase) for _ in range(7))
        
        # Build complex obfuscated code
        obfuscated = "<?php\n"
        obfuscated += "/*\n"
        obfuscated += "DECK PHP VERSION ONE\n"
        obfuscated += f" FUCK OBFUSCATE {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}\n"
        obfuscated += " RUSHERCLOUD \n"
        obfuscated += " RUSHERCLOUD CHANNEL\n"
        obfuscated += "*/\n"
        
        random_const = self.global_var[:8]
        obfuscated += f"if(!defined('{self.global_var}'))define('{self.global_var}', '{random_const}');"
        obfuscated += f"$GLOBALS[{self.global_var}]=explode('{self.separator}','{data_string}');"
        obfuscated += f"unset({dummy_var1});{dummy_var1};"
        
        # Complex evaluation chain
        obfuscated += f"eval(pack($GLOBALS[{self.global_var}][(5+6+7-18)*0],$GLOBALS[{self.global_var}][1])."
        obfuscated += f"base64_decode('{encoded}'));"
        
        obfuscated += f"unset({dummy_var2});{dummy_var2};"
        obfuscated += "\n?>"
        
        return obfuscated


def main():
    print("=" * 60)
    print("PHP Code Obfuscator - DeckPHP Style")
    print("=" * 60)
    print()
    
    if len(sys.argv) < 2:
        print("Usage: python3 obfuscator.py <input_file> [output_file] [method]")
        print()
        print("Methods:")
        print("  basic    - Basic obfuscation (default)")
        print("  advanced - Advanced multi-layer obfuscation")
        print("  extreme  - Extreme obfuscation (DeckPHP style)")
        print()
        print("Example:")
        print("  python3 obfuscator.py input.php output.php extreme")
        sys.exit(1)
    
    input_file = sys.argv[1]
    output_file = sys.argv[2] if len(sys.argv) > 2 else input_file.replace('.php', '_obfuscated.php')
    method = sys.argv[3] if len(sys.argv) > 3 else 'basic'
    
    # Read input file
    try:
        with open(input_file, 'r', encoding='utf-8') as f:
            source_code = f.read()
    except FileNotFoundError:
        print(f"❌ Error: File not found: {input_file}")
        sys.exit(1)
    except Exception as e:
        print(f"❌ Error reading file: {e}")
        sys.exit(1)
    
    # Obfuscate
    obfuscator = PHPObfuscator()
    
    print(f"📁 Input file: {input_file}")
    print(f"📁 Output file: {output_file}")
    print(f"🔧 Method: {method}")
    print()
    print("⏳ Obfuscating...")
    
    try:
        if method == 'advanced':
            obfuscated = obfuscator.obfuscate_advanced(source_code)
        elif method == 'extreme':
            obfuscated = obfuscator.obfuscate_extreme(source_code)
        else:
            obfuscated = obfuscator.obfuscate_basic(source_code)
        
        # Write output file
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
        
    except Exception as e:
        print(f"❌ Error during obfuscation: {e}")
        sys.exit(1)


if __name__ == "__main__":
    main()