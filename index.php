<?php
$zipFolder = __DIR__ . "/";
$message = "";

// Dossier des traductions
$langFolder = __DIR__ . "/lang";
$availableLangs = array_map(function($f){ return pathinfo($f, PATHINFO_FILENAME); }, glob("$langFolder/*.php"));

// --- Détection automatique de la langue ---
$lang = 'fr'; // langue par défaut
if(isset($_GET['lang']) && in_array($_GET['lang'], $availableLangs)){
    $lang = $_GET['lang'];
} elseif(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
    $browserLangs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    foreach($browserLangs as $bl){
        $bl = substr($bl, 0, 2);
        if(in_array($bl, $availableLangs)){
            $lang = $bl;
            break;
        }
    }
}

// Charger le fichier de traduction
$langFile = "$langFolder/$lang.php";
if(file_exists($langFile)){
    $t = include $langFile;
} else {
    $t = include "$langFolder/fr.php";
    $lang = 'fr';
}

// --- Actions ZIP ---
if(isset($_POST['delete'])){
    $file = basename($_POST['delete']);
    if(file_exists($zipFolder.$file)){
        unlink($zipFolder.$file);
        $message = "🗑️ ".$t['zip_deleted'].$file;
    }
}
if(isset($_POST['rename'])){
    $old = basename($_POST['old_name']);
    $new = basename($_POST['new_name']);
    if(file_exists($zipFolder.$old) && $new){
        rename($zipFolder.$old, $zipFolder.$new);
        $message = "✏️ ".$t['zip_renamed'].$new;
    }
}
if(isset($_POST['create'])){
    $zip = new ZipArchive();
    $zipFile = $zipFolder."mon_site_complet.zip";
    if($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE){
        $message = "❌ ".$t['file_not_found'];
    } else {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__));
        foreach($files as $file){
            if($file->isDir()) continue;
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen(__DIR__)+1);
            $zip->addFile($filePath, $relativePath);
        }
        $zip->close();
        $message = "✅ ".$t['zip_created']."mon_site_complet.zip";
    }
}
if(isset($_GET['download'])){
    $file = basename($_GET['download']);
    $filePath = $zipFolder.$file;
    if(file_exists($filePath)){
        header('Content-Description: File Transfer');
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
        header('Expires:0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize($filePath));
        readfile($filePath);
        unlink($filePath);
        exit;
    } else {
        $message = "⚠️ ".$t['file_not_found'];
    }
}

$existingZips = glob($zipFolder."*.zip");
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8">
<title><?php echo $t['title']; ?></title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
body { font-family:'Segoe UI', sans-serif; margin:0; padding:0; background:#f4f6f8; }
header { background:#34495e; color:#ecf0f1; padding:20px; text-align:center; }
header a { color:#ecf0f1; text-decoration:underline; }
h1 { margin:0; font-size:2em; }
.container { max-width:1100px; margin:20px auto; padding:20px; background:#fff; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.1);}
.message { padding:12px; background:#dff0d8; border:1px solid #3c763d; margin-bottom:20px; border-radius:6px; font-weight:bold;}

button, a.download {
    display:flex;
    align-items:center;
    justify-content:center;
    gap:5px;
    padding:10px 12px;
    margin:2px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    text-decoration:none;
    color:#fff;
    transition:0.2s;
    min-width:100px;
    height:38px;
    font-size:0.95em;
}

button.create { background:#2980b9; }
button.create:hover { background:#1c5980; }
button.delete { background:#e74c3c; }
button.delete:hover { background:#c0392b; }
button.rename { background:#f39c12; }
button.rename:hover { background:#d68910; }
a.download { background:#27ae60; }
a.download:hover { background:#1e8449; }

.actions { display:flex; flex-wrap:wrap; gap:5px; margin-top:5px; }
.actions form, .actions a { flex:1 1 auto; }

table { width:100%; border-collapse: collapse; margin-top:15px; }
th, td { border:1px solid #ccc; padding:10px; text-align:left; }
th { background:#ecf0f1; }
input[type="text"] { padding:6px; border-radius:5px; border:1px solid #ccc; width:120px; }
form.inline { display:inline; }

@media (max-width:768px){
    table, thead, tbody, th, td, tr { display:block; }
    th { display:none; }
    td { display:flex; justify-content:space-between; padding:10px; border:none; border-bottom:1px solid #ccc; }
    td::before { content: attr(data-label); font-weight:bold; }
    .actions { flex-direction:column; }
    .actions form, .actions a { flex: 1 1 100%; }
}

svg { width:16px; height:16px; fill:#fff; }
</style>
<script>
function confirmDelete(fileName) {
    return confirm("<?php echo $t['confirm_delete']; ?>" + fileName + "?");
}
function notifyDownload(fileName) {
    alert("📥 <?php echo $t['download']; ?> " + fileName + "!");
}
</script>
</head>
<body>
<header>
<h1><?php echo $t['title']; ?></h1>
<p><?php echo $t['created_by']; ?> <strong>Abiye Enzo</strong> | GitHub : <a href="https://github.com/abiyeenzo" target="_blank">abiyeenzo</a></p>
<form method="get" style="margin-top:10px;">
<select name="lang" onchange="this.form.submit()">
<?php foreach($availableLangs as $l): ?>
<option value="<?php echo $l; ?>" <?php if($l==$lang) echo 'selected'; ?>><?php echo strtoupper($l); ?></option>
<?php endforeach; ?>
</select>
</form>
</header>
<div class="container">
<?php if($message): ?><div class="message"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
<h2><?php echo $t['create_zip']; ?></h2>
<form method="post">
<button type="submit" name="create" class="create"><i class="fa fa-file-zipper"></i> <?php echo $t['create_zip']; ?></button>
</form>
<h2><?php echo $t['existing_zips']; ?></h2>
<?php if(empty($existingZips)): ?>
<p><?php echo $t['no_zips']; ?></p>
<?php else: ?>
<table>
<tr><th><?php echo $t['name']; ?></th><th><?php echo $t['size']; ?></th><th><?php echo $t['actions']; ?></th></tr>
<?php foreach($existingZips as $zip): 
$size = filesize($zip);
$name = basename($zip);
?>
<tr>
<td data-label="<?php echo $t['name']; ?>"><?php echo htmlspecialchars($name); ?></td>
<td data-label="<?php echo $t['size']; ?>"><?php echo round($size/1024,2); ?> KB</td>
<td data-label="<?php echo $t['actions']; ?>" class="actions">
<form method="post" class="inline" onsubmit="return confirmDelete('<?php echo $name; ?>')">
<button type="submit" name="delete" value="<?php echo htmlspecialchars($name); ?>" class="delete"><i class="fa fa-trash"></i> <?php echo $t['delete']; ?></button>
</form>
<a href="?download=<?php echo urlencode($name); ?>&lang=<?php echo $lang; ?>" class="download" onclick="notifyDownload('<?php echo $name; ?>')"><i class="fa fa-download"></i> <?php echo $t['download']; ?></a>
<form method="post" class="inline">
<input type="hidden" name="old_name" value="<?php echo htmlspecialchars($name); ?>">
<input type="text" name="new_name" placeholder="<?php echo $t['new_name']; ?>">
<button type="submit" name="rename" class="rename"><i class="fa fa-pen"></i> <?php echo $t['rename']; ?></button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</div>
</body>
</html>
