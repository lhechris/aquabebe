<?php
//Liste des types mimes
$MIMEARRAY=array(
    "aac"=> array("fichier audio AAC", "audio/aac"),
    "abw"=> array("document AbiWord", "application/x-abiword"),
    "arc"=> array("archive (contenant plusieurs fichiers)", "application/octet-stream"),
    "avi"=> array("AVI : Audio Video Interleave", "video/x-msvideo"),
    "azw"=> array("format pour eBook Amazon Kindle", "application/vnd.amazon.ebook"),
    "bin"=> array("n'importe quelle donnée binaire", "application/octet-stream"),
    "bz"=> array("archive BZip", "application/x-bzip"),
    "bz2"=> array("archive BZip2", "application/x-bzip2"),
    "csh"=> array("script C-Shell", "application/x-csh"),
    "css"=> array("fichier Cascading Style Sheets (CSS)", "text/css"),
    "csv"=> array("fichier Comma-separated values (CSV)", "text/csv"),
    "doc"=> array("Microsoft Word", "application/msword"),
    "docx"=> array("Microsoft Word (OpenXML)", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"),
    "eot"=> array("police MS Embedded OpenType", "application/vnd.ms-fontobject"),
    "epub"=> array("fichier Electronic publication (EPUB)", "application/epub+zip"),
    "gif"=> array("fichier Graphics Interchange Format (GIF)", "image/gif"),
    "htm"=> array("fichier HyperText Markup Language (HTML)", "text/html"),
    "html"=> array("fichier HyperText Markup Language (HTML)", "text/html"),
    "ico"=> array("icône", "image/x-icon"),
    "ics"=> array("élément iCalendar", "text/calendar"),
    "jar"=> array("archive Java (JAR)", "application/java-archive"),
    "jpeg"=> array("image JPEG", "image/jpeg"),
    "jpg"=> array("image JPEG", "image/jpeg"),
    "js"=> array("JavaScript (ECMAScript)", "application/javascript"),
    "json"=> array("donnée au format JSON", "application/json"),
    "mid"=> array("fichier audio Musical Instrument Digital Interface (MIDI)", "audio/midi"),
    "midi"=> array("fichier audio Musical Instrument Digital Interface (MIDI)", "audio/midi"),
    "mpeg"=> array("vidéo MPEG", "video/mpeg"),
    "mpkg"=> array("paquet Apple Installer", "application/vnd.apple.installer+xml"),
    "odp"=> array("présentation OpenDocument", "application/vnd.oasis.opendocument.presentation"),
    "ods"=> array("feuille de calcul OpenDocument", "application/vnd.oasis.opendocument.spreadsheet"),
    "odt"=> array("document texte OpenDocument", "application/vnd.oasis.opendocument.text"),
    "oga"=> array("fichier audio OGG", "audio/ogg"),
    "ogv"=> array("fichier vidéo OGG", "video/ogg"),
    "ogx"=> array("OGG", "application/ogg"),
    "otf"=> array("police OpenType", "font/otf"),
    "png"=> array("fichier Portable Network Graphics", "image/png"),
    "pdf"=> array("Adobe Portable Document Format (PDF)", "application/pdf"),
    "ppt"=> array("présentation Microsoft PowerPoint", "application/vnd.ms-powerpoint"),
    "pptx"=> array("présentation Microsoft PowerPoint (OpenXML)", "application/vnd.openxmlformats-officedocument.presentationml.presentation"),
    "rar"=> array("archive RAR", "application/x-rar-compressed"),
    "rtf"=> array("Rich Text Format (RTF)", "application/rtf"),
    "sh"=> array("script shell", "application/x-sh"),
    "svg"=> array("fichier Scalable Vector Graphics (SVG)", "image/svg+xml"),
    "swf"=> array("fichier Small web format (SWF) ou Adobe Flash", "application/x-shockwave-flash"),
    "tar"=> array("fichier d'archive Tape Archive (TAR)", "application/x-tar"),
    "tif"=> array("image au format Tagged Image File Format (TIFF)", "image/tiff"),
    "tiff"=> array("image au format Tagged Image File Format (TIFF)", "image/tiff"),
    "ts"=> array("fichier Typescript", "application/typescript"),
    "ttf"=> array("police TrueType", "font/ttf"),
    "vsd"=> array("Microsoft Visio", "application/vnd.visio"),
    "wav"=> array("Waveform Audio Format", "audio/x-wav"),
    "weba"=> array("fichier audio WEBM", "audio/webm"),
    "webm"=> array("fichier vidéo WEBM", "video/webm"),
    "webp"=> array("image WEBP", "image/webp"),
    "woff"=> array("police Web Open Font Format (WOFF)", "font/woff"),
    "woff2"=> array("police Web Open Font Format (WOFF)", "font/woff2"),
    "xhtml"=> array("XHTML", "application/xhtml+xml"),
    "xls"=> array("Microsoft Excel", "application/vnd.ms-excel"),
    "xlsx"=> array("Microsoft Excel (OpenXML)", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"),
    "xml"=> array("XML", "application/xml"),
    "xul"=> array("XUL", "application/vnd.mozilla.xul+xml"),
    "zip"=> array("archive ZIP", "application/zip"),
    "3gp"=> array("conteneur audio/vidéo 3GPP", "video/3gpp"),
    "3g2"=> array("conteneur audio/vidéo 3GPP2", "video/3gpp2"),
    "7z"=> array("archive 7-zip", "application/x-7z-compressed"),
    
);

function getMimeType($ext) {
    global $MIMEARRAY;

    if (array_key_exists($ext,$MIMEARRAY)) {
        return $MIMEARRAY[$ext][1];
    } else {
      return 'text/plain';
    }
  }


?>