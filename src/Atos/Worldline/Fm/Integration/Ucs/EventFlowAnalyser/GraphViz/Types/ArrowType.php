<?php 
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Types;

/**
* <TABLE>
*     <TR><TD>"normal"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_normal.gif" />
*         <TD>"inv"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_inv.gif" /></td></td></td></td></tr>
*     <TR><TD>"dot"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_dot.gif" />
*         <TD>"invdot"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_invdot.gif" /></td></td></td></td></tr>
*     <TR><TD>"odot"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_odot.gif" />
*         <TD>"invodot"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_invodot.gif" /></td></td></td></td></tr>
*     <TR><TD>"none"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_none.gif" />
*         <TD>"tee"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_tee.gif" /></td></td></td></td></tr>
*     <TR><TD>"empty"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_empty.gif" />
*         <TD>"invempty"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_invempty.gif" /></td></td></td></td></tr>
*     <TR><TD>"diamond"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_diamond.gif" />
*         <TD>"odiamond"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_odiamond.gif" /></td></td></td></td></tr>
*     <TR><TD>"ediamond"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_ediamond.gif" />
*         <TD>"crow"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_crow.gif" /></td></td></td></td></tr>
*     <TR><TD>"box"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_box.gif" />
*         <TD>"obox"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_obox.gif" /></td></td></td></td></tr>
*     <TR><TD>"open"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_open.gif" />
*         <TD>"halfopen"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_halfopen.gif" /></td></td></td></td></tr>
*     <TR><TD>"vee"<TD><IMG SRC="http://www.graphviz.org/doc/info/a_open.gif" />
*   </td></td></tr></table>
*   <P>
*   These are the basic set of backward-compatible arrow shapes. In addition,
*   there is a grammar of <A HREF=arrow-shapes>arrow shapes</a>
*   which can be used to describe a collection of 1,544,761 arrow combinations of the 36 varations of the primitive set of 9 arrows. The basic arrows shown
*   above contain all of the primitive shapes
*   (<TT>box</tt>, <TT>crow</tt>, <TT>diamond</tt>,
*   <TT>dot</tt>, <TT>inv</tt>, <TT>none</tt>,
*   <TT>normal</tt>, <TT>tee</tt>, <TT>vee</tt>)
*   plus ones that can be derived from the grammar
*   (<TT>odot</tt>, <TT>invdot</tt>, <TT>invodot</tt>,
*   <TT>obox</tt>, <TT>odiamond</tt>)
*   plus some supported as special cases for backward-compatibility
*   (<TT>ediamond</tt>, <TT>open</tt>, <TT>halfopen</tt>,
*   <TT>empty</tt>, <TT>invempty</tt>).
*/
class ArrowType extends AbstractAttributeType
{
    const NORMAL = 'normal';
    const INV = 'inv';
    const DOT = 'dot';
    const INVDOT = 'invdot';
    const ODOT = 'odot';
    const INVODOT = 'invodot';
    const NONE = 'none';
    const TEE = 'tee';
    const AEMPTY = 'empty';
    const INVEMPTY = 'invempty';
    const DIAMOND = 'diamond';
    const ODIAMOND = 'odiamond';
    const EDIAMOND = 'ediamond';
    const CROW = 'crow';
    const BOX = 'box';
    const OBOX = 'obox';
    const OPEN = 'open';
    const HALFOPEN = 'halfopen';
    const VEE = 'vee';

    static function getPossibleValues()
    {
        return array(
                    static::NORMAL,
                    static::INV,
                    static::DOT,
                    static::INVDOT,
                    static::ODOT,
                    static::INVODOT,
                    static::NONE,
                    static::TEE,
                    static::AEMPTY,
                    static::INVEMPTY,
                    static::DIAMOND,
                    static::ODIAMOND,
                    static::EDIAMOND,
                    static::CROW,
                    static::BOX,
                    static::OBOX,
                    static::OPEN,
                    static::HALFOPEN,
                    static::VEE
                    );
    }
    
    static function getReadables()
    {
        return array(
                    static::NORMAL => 'normal',
                    static::INV => 'inv',
                    static::DOT => 'dot',
                    static::INVDOT => 'invdot',
                    static::ODOT => 'odot',
                    static::INVODOT => 'invodot',
                    static::NONE => 'none',
                    static::TEE => 'tee',
                    static::AEMPTY => 'empty',
                    static::INVEMPTY => 'invempty',
                    static::DIAMOND => 'diamond',
                    static::ODIAMOND => 'odiamond',
                    static::EDIAMOND => 'ediamond',
                    static::CROW => 'crow',
                    static::BOX => 'box',
                    static::OBOX => 'obox',
                    static::OPEN => 'open',
                    static::HALFOPEN => 'halfopen',
                    static::VEE => 'vee'
                );
    }
    
}
