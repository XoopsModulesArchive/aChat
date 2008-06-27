<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

// Modifié par Niluge_Kiwi
// v 0.2 2006/08/29 23:05:37
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
/**
 * Class to facilitate navigation in a multi page document/list
 *
 * @package     discuss
 */
class MyPageNavNK extends XoopsPageNav
{
    /**
     * @access  private
     */
    // Ajout
    var $_order;
    var $_extra;
    var $_perpage_arr = array(15,30,50,100,200,500,1000);

    /**
     * Constructor
     *
     * @param   int     $total_items    Total number of items
     * @param   int     $items_perpage  Number of items per page
     * @param   int     $current_start  First item on the current page
     * @param   string  $start_name     Name for "start" or "offset"
     * @param   string  $extra_arg      Additional arguments to pass in the URL
     **/
    // Modifié
    function MyPageNavNK($total_items, $items_perpage, $current_start, $order="DESC", $extra_arg="")
    {
        $this->XoopsPageNav($total_items, $items_perpage, $current_start, "start", 'perpage='.intval($items_perpage).'&amp;order='.$order.'&amp;'.$extra_arg);
        // Ajout et Modif
        $this->_order = $order;
        $this->_extra = $extra_arg;
    }

    /**
     * Set perpage array
     *
     * @param   array $perpages
     * @return  void
     **/
    function setPerpageArray($perpages)
    {
        $this->_perpage_arr = $perpages;
    }


    /**
     * Create navigation
     *
     * @param   integer $offset
     * @return  string
     **/
    function renderAuto($offset = 4)
    {
        if ( !$this->perpage ) {
            return '';
        }
        $ret = $this->renderNav($offset);
        $total_pages = ceil($this->total / $this->perpage);
        if ($ret != '' && $total_pages <= $offset ) {
            $extra_arg = $this->_extra;
            if ( $extra_arg != '' && ( substr($extra_arg, -5) != '&amp;' || substr($extra_arg, -1) != '&' ) ) {
                $extra_arg .= '&amp;';
            }
            // Modifié
            $ret .= '&nbsp;<a href="'.xoops_getenv('PHP_SELF').'?perpage='.$this->total.'&amp;order='.$this->_order.'&amp;'.$extra_arg.'start=1">'._ALL.'</a>';
        }
        if ( $this->total > 0 ) {
            $ret .= $this->renderSelectStart($total_pages);
        }
        return $ret;
    }

    /**
     * Create a navigational dropdown list
     *
     * @return  string
     **/
    function renderSelectStart($total_pages)
    {
        $extra_arg = $this->_extra;
        if ( $extra_arg != '' ) {
            $extra_arg = preg_replace('/&amp;/', '&', $extra_arg);
            if ( substr($extra_arg, -1) != '&' ) {
                $extra_arg .= '&';
            }
        }
        // Modifié
        $ret = '<script type="text/javascript">
function navigate() {
	var order = "DESC";
	var objForm = xoopsGetElementById("pagenavform");
	if (objForm.order[0].checked) {
		order = "ASC";
	}
	document.location=\''.xoops_getenv('PHP_SELF').'?perpage=\' + objForm.perpage[objForm.perpage.selectedIndex].value + \'&'.$extra_arg.'start=\' + objForm.start.options[objForm.start.options.selectedIndex].value + \'&order=\' + order;
}

function changeAffichagepagenavForm() {
	var objForm = xoopsGetElementById("pagenavform");
	var elestyle = objForm.style;
	if (elestyle.display == "" || elestyle.display == "block") {
		elestyle.display = "none";
	} else {
		elestyle.display = "block";
	}
}
</script>';
        // Ajout
        $ret .= '&nbsp;&nbsp;<a href="javascript:;" onclick="changeAffichagepagenavForm();">'. _OPTIONS .'</a>';
        $ret .= '<form name="pagenavform" action="#" style="display: none;" id="pagenavform">';
        // Ajouts
        $checked = ($this->_order == 'ASC') ? ' checked="checked"' : '';
        $ret .= '<input name="order" value="ASC"'.$checked.' type="radio" />'._MD_ACHAT_FIRST_OLD;
        $checked = ($this->_order == 'DESC') ? ' checked="checked"' : '';
        $ret .= '<input name="order" value="DESC"'.$checked.' type="radio" />'._MD_ACHAT_FIRST_RECENT;
        // Fin Ajouts
        $ret .= '&nbsp;<select name="perpage">';
        $perpages = $this->_perpage_arr;
        if (!in_array($this->perpage, $perpages)) {
            array_unshift($perpages, $this->perpage);
        }
        foreach ($perpages as $perpage) {
            $selected = ($perpage == $this->perpage) ? '" selected="selected">' : '">';
            $ret .= '<option value="'.$perpage.$selected.$perpage.' '._MD_ACHAT_MESSAGES.'</option>';
        }
        $ret .= '</select>';
        $ret .= '<select name="start" onchange="navigate();">';
        $counter = 1;
        $current_page = intval(floor(($this->current + $this->perpage) / $this->perpage));
        while ( $counter <= $total_pages ) {
            if ( $counter == $current_page ) {
                $ret .= '<option value="'.(($counter - 1) * $this->perpage).'" selected="selected">'._MD_ACHAT_FROM.' '.(($counter - 1) * $this->perpage + 1).'</option>';
            } else {
                $ret .= '<option value="'.(($counter - 1) * $this->perpage).'">'._MD_ACHAT_FROM.' '.(($counter - 1) * $this->perpage + 1).'</option>';
            }
            $counter++;
        }
        $ret .= '</select>';

        $ret .= '&nbsp;<input type="button" value="'._GO.'" onClick="navigate();" />';
        $ret .= '</form>';
        return $ret;
    }
}
?>