<?php
// From
//  ------------------------------------------------------------------------ 	//
//                XOOPS - PHP Content Management System    				        //
//                    Copyright (c) 2004 XOOPS.org                       	    //
//                       <http://www.xoops.org/>                                //
//                   										                    //
//                  Authors :									                //
//						- solo (www.wolfpackclan.com)         	                //
//						- christian (www.edom.org)		 	                    //
//						- herve (www.herve-thouzard.com)   		                //
//						- Marcan (www.smartfactory.ca)   		                //
//                  Edito 2.4								                    //
//  ------------------------------------------------------------------------ 	//
 
// Modifié par Niluge_Kiwi
// v 0.232 2007/10/12 23:04:12
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//

include_once( '../../../mainfile.php');
include_once( '../../../include/cp_header.php');

$op = '';

foreach ( $_POST as $k => $v )
{
    ${$k} = $v;
}

foreach ( $_GET as $k => $v )
{
    ${$k} = $v;
}

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];

function utilities()
{
    global $xoopsConfig, $modify, $xoopsModuleConfig, $xoopsModule, $XOOPS_URL;
    global $xoopsConfig, $modify, $xoopsModuleConfig, $xoopsModule, $XOOPS_URL;

    $sform = new XoopsThemeForm( _AM_ACHAT_CLONE, "op", xoops_getenv( 'PHP_SELF' ) );
    $sform -> setExtra( 'enctype="multipart/form-data"' );

    $sform -> addElement( new XoopsFormText( _AM_ACHAT_CLONENAME, 'clone', 16, 16, '' ), true );

    $button_tray = new XoopsFormElementTray( '', '' );
    $hidden = new XoopsFormHidden( 'op', 'clonemodule' );
    $button_tray -> addElement( $hidden );
    $butt_create = new XoopsFormButton( '', '', _AM_ACHAT_SUBMIT, 'submit' );
    $butt_create->setExtra('onclick="this.form.elements.op.value=\'clonemodule\'"');
    $button_tray->addElement( $butt_create );
    $butt_clear = new XoopsFormButton( '', '', _AM_ACHAT_CLEAR, 'reset' );
    $button_tray->addElement( $butt_clear );
    /*		$butt_cancel = new XoopsFormButton( '', '', _AM_ACHAT_CANCEL, 'button' );
     $butt_cancel->setExtra('onclick="history.go(-1)"');
     $button_tray->addElement( $butt_cancel );
     */
    $sform -> addElement( $button_tray );
    $sform -> display();
    unset( $hidden );
}

// Cloning functions
// recursive clonning script
function cloneFileFolder($path)
{
    global $patKeys;
    global $patValues;
    global $safeKeys;
    global $safeValues;

    $newPath = str_replace($patKeys[0], $patValues[0], $path);
    chmod(XOOPS_ROOT_PATH.'/modules', 0777);
    if (is_dir($path))
    {
        // Create new dir
        mkdir($newPath);

        // check all files in dir, and process it
        if ($handle = opendir($path))
        {
            while ($file = readdir($handle))
            {
                if ($file != '.' && $file != '..')
                {
                    cloneFileFolder("$path/$file");
                }
            }
            closedir($handle);
        }
    }
    else
    {
        if(preg_match('/(.jpg|.gif|.png|.zip)$/i', $path))
        {
            copy($path, $newPath);
        }
        else
        {
            // file, read it
            $content = file_get_contents($path);
            $content = str_replace($safeKeys, $safeValues, $content); // Save 'Editor' values
            $content = str_replace($patKeys, $patValues, $content);   // Rename Clone values
            $content = str_replace($safeValues, $safeKeys, $content);  // Restore 'Editor' values
            file_put_contents($newPath, $content);
        }
    }
    chmod(XOOPS_ROOT_PATH.'/modules', 0444);
}

// Check wether the cloning function is available
// work around for PHP < 5.0.x
if(!function_exists('file_put_contents')) {
    function file_put_contents($filename, $data, $file_append = false) {
        $fp = fopen($filename, (!$file_append ? 'w+' : 'a+'));
        if(!$fp) {
            trigger_error('file_put_contents cannot write in file.', E_USER_ERROR);
            return;
        }
        fputs($fp, $data);
        fclose($fp);
    }
}




/* -- Available operations -- */
switch ( $op )
{
    case "clonemodule":

        if ( isset( $_GET['clone'] ) ) { $clone = $_GET['clone']; }  else { $clone =''; }
        if ( isset( $_POST['clone'] ) ) { $clone = $_POST['clone']; }

        // Define Cloning parameters : check clone name
        $clone = trim($clone);
        $clone_orig = $clone;
        if ( function_exists('mb_convert_encoding') ) { $clone = mb_convert_encoding($clone, "", "auto"); }
        //      $clone = eregi_replace("[[:digit:]]","", $clone);
        $clone = str_replace('-', 'xyz', $clone);
        $clone = eregi_replace("[[:punct:]]","", $clone);
        $clone = str_replace('xyz', '-', $clone);
        $clone = ereg_replace(' ', '_', $clone);

        // Check wether the cloned module exists or not
        if ( $clone && is_dir(XOOPS_ROOT_PATH.'/modules/'.$clone)) {
            redirect_header( "utilities.php", 2, _AM_ACHAT_MODULEXISTS );
        }

        // Define clone naming parameteres
        $module = $xoopsModule->dirname();

        if ( $clone ) {
            $CLONE  = strtoupper(eregi_replace("-","_", $clone));
            // Ajouts et modif
            $clone = eregi_replace("-","_", $clone);
            $clone_bas  = strtolower(eregi_replace("-","_", $clone));
            // Fin ajouts et modif
            $Clone  = ucfirst($clone_orig);
            $MODULE = strtoupper($module);
            $Module = ucfirst($module);
            // Ajout
            $module_bas = strtolower($module);
            // Fin Ajout

            $patterns = array(
            // first one must be module directory name
            $module  => $clone,
            // Ajout
            $module_bas  => $clone_bas,
            // Fin Ajout
            $MODULE  => $CLONE,
            $Module => $Clone,
            );
            $patKeys = array_keys($patterns);
            $patValues = array_values($patterns);

            // Clone everything but 'Editor' - usefull for edito only
            $safepat = array(
            // Prevent unwilling change for wysiwyg functions
      'editor'  => 'e*d*i*t*o*r',
      'EDITOR'  => 'E*D*I*T*O*R',
      'Editor'  => 'E*d*i*t*o*r',
            );

            $safeKeys = array_keys($safepat);
            $safeValues = array_values($safepat);

            // Create clone
            $module_dir = XOOPS_ROOT_PATH.'/modules';
            $fileperm = fileperms($module_dir);
            if ( chmod($module_dir, 0777) ) {
                cloneFileFolder('../../'.$module);
            } else {
       	        redirect_header( "utilities.php", 1, _AM_ACHAT_CHMOD_TROUBLE );
                exit();
            }
            chmod(XOOPS_ROOT_PATH.'/modules', $fileperm);
             
            redirect_header( "../../system/admin.php?fct=modulesadmin&op=install&module=".$clone, 1, _AM_ACHAT_CLONED );
            exit();

        } else {
            redirect_header( "utilities.php", 1, _AM_ACHAT_NOTCLONED );
            exit();
        }
        break;


    case "utilities":
    default:
        include_once './admin_header.php';
        xoops_cp_header();
        aChat_adminmenu(_MI_ACHAT_UTILITIES, 3);
        utilities();
        include_once './admin_footer.php';
        break;

}

?>
