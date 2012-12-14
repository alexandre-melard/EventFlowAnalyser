<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz;

use Alom\Graphviz\DirectedEdge;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\URL;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Arrowhead;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Arrowsize;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Arrowtail;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Color;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Colorscheme;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Comment;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Constraint;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Decorate;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Dir;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\EdgeURL;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Edgehref;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Edgetarget;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Edgetooltip;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fillcolor;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontcolor;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontname;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontsize;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\HeadURL;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Head_lp;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Headclip;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Headhref;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Headlabel;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Headport;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Headtarget;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Headtooltip;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Href;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Id;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Label;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\LabelURL;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labelangle;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labeldistance;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labelfloat;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labelfontcolor;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labelfontname;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labelfontsize;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labelhref;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labeltarget;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labeltooltip;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Layer;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Len;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Lhead;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Lp;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Ltail;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Minlen;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Nojustify;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Penwidth;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Pos;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Samehead;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Sametail;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Showboxes;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Style;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\TailURL;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Tail_lp;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Tailclip;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Tailhref;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Taillabel;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Tailport;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Tailtarget;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Tailtooltip;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Target;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Tooltip;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Weight;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Xlabel;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Xlp;

class Edge extends DirectedEdge
{

    public static function create($list)
    {
        return new Edge($list);
    }

    /**
    * @param URL URL
    * @return Edge
    */
    public function setURL(URL $URL)
    {
        $this->attribute($URL->getName(), $URL->getValue());
        return $this;
    }

    /**
    * @param Arrowhead arrowhead
    * @return Edge
    */
    public function setArrowhead(Arrowhead $arrowhead)
    {
        $this->attribute($arrowhead->getName(), $arrowhead->getValue());
        return $this;
    }

    /**
    * @param Arrowsize arrowsize
    * @return Edge
    */
    public function setArrowsize(Arrowsize $arrowsize)
    {
        $this->attribute($arrowsize->getName(), $arrowsize->getValue());
        return $this;
    }

    /**
    * @param Arrowtail arrowtail
    * @return Edge
    */
    public function setArrowtail(Arrowtail $arrowtail)
    {
        $this->attribute($arrowtail->getName(), $arrowtail->getValue());
        return $this;
    }

    /**
    * @param Color color
    * @return Edge
    */
    public function setColor(Color $color)
    {
        $this->attribute($color->getName(), $color->getValue());
        return $this;
    }

    /**
    * @param Colorscheme colorscheme
    * @return Edge
    */
    public function setColorscheme(Colorscheme $colorscheme)
    {
        $this->attribute($colorscheme->getName(), $colorscheme->getValue());
        return $this;
    }

    /**
    * @param Comment comment
    * @return Edge
    */
    public function setComment(Comment $comment)
    {
        $this->attribute($comment->getName(), $comment->getValue());
        return $this;
    }

    /**
    * @param Constraint constraint
    * @return Edge
    */
    public function setConstraint(Constraint $constraint)
    {
        $this->attribute($constraint->getName(), $constraint->getValue());
        return $this;
    }

    /**
    * @param Decorate decorate
    * @return Edge
    */
    public function setDecorate(Decorate $decorate)
    {
        $this->attribute($decorate->getName(), $decorate->getValue());
        return $this;
    }

    /**
    * @param Dir dir
    * @return Edge
    */
    public function setDir(Dir $dir)
    {
        $this->attribute($dir->getName(), $dir->getValue());
        return $this;
    }

    /**
    * @param EdgeURL edgeURL
    * @return Edge
    */
    public function setEdgeURL(EdgeURL $edgeURL)
    {
        $this->attribute($edgeURL->getName(), $edgeURL->getValue());
        return $this;
    }

    /**
    * @param Edgehref edgehref
    * @return Edge
    */
    public function setEdgehref(Edgehref $edgehref)
    {
        $this->attribute($edgehref->getName(), $edgehref->getValue());
        return $this;
    }

    /**
    * @param Edgetarget edgetarget
    * @return Edge
    */
    public function setEdgetarget(Edgetarget $edgetarget)
    {
        $this->attribute($edgetarget->getName(), $edgetarget->getValue());
        return $this;
    }

    /**
    * @param Edgetooltip edgetooltip
    * @return Edge
    */
    public function setEdgetooltip(Edgetooltip $edgetooltip)
    {
        $this->attribute($edgetooltip->getName(), $edgetooltip->getValue());
        return $this;
    }

    /**
    * @param Fillcolor fillcolor
    * @return Edge
    */
    public function setFillcolor(Fillcolor $fillcolor)
    {
        $this->attribute($fillcolor->getName(), $fillcolor->getValue());
        return $this;
    }

    /**
    * @param Fontcolor fontcolor
    * @return Edge
    */
    public function setFontcolor(Fontcolor $fontcolor)
    {
        $this->attribute($fontcolor->getName(), $fontcolor->getValue());
        return $this;
    }

    /**
    * @param Fontname fontname
    * @return Edge
    */
    public function setFontname(Fontname $fontname)
    {
        $this->attribute($fontname->getName(), $fontname->getValue());
        return $this;
    }

    /**
    * @param Fontsize fontsize
    * @return Edge
    */
    public function setFontsize(Fontsize $fontsize)
    {
        $this->attribute($fontsize->getName(), $fontsize->getValue());
        return $this;
    }

    /**
    * @param HeadURL headURL
    * @return Edge
    */
    public function setHeadURL(HeadURL $headURL)
    {
        $this->attribute($headURL->getName(), $headURL->getValue());
        return $this;
    }

    /**
    * @param Head_lp head_lp
    * @return Edge
    */
    public function setHead_lp(Head_lp $head_lp)
    {
        $this->attribute($head_lp->getName(), $head_lp->getValue());
        return $this;
    }

    /**
    * @param Headclip headclip
    * @return Edge
    */
    public function setHeadclip(Headclip $headclip)
    {
        $this->attribute($headclip->getName(), $headclip->getValue());
        return $this;
    }

    /**
    * @param Headhref headhref
    * @return Edge
    */
    public function setHeadhref(Headhref $headhref)
    {
        $this->attribute($headhref->getName(), $headhref->getValue());
        return $this;
    }

    /**
    * @param Headlabel headlabel
    * @return Edge
    */
    public function setHeadlabel(Headlabel $headlabel)
    {
        $this->attribute($headlabel->getName(), $headlabel->getValue());
        return $this;
    }

    /**
    * @param Headport headport
    * @return Edge
    */
    public function setHeadport(Headport $headport)
    {
        $this->attribute($headport->getName(), $headport->getValue());
        return $this;
    }

    /**
    * @param Headtarget headtarget
    * @return Edge
    */
    public function setHeadtarget(Headtarget $headtarget)
    {
        $this->attribute($headtarget->getName(), $headtarget->getValue());
        return $this;
    }

    /**
    * @param Headtooltip headtooltip
    * @return Edge
    */
    public function setHeadtooltip(Headtooltip $headtooltip)
    {
        $this->attribute($headtooltip->getName(), $headtooltip->getValue());
        return $this;
    }

    /**
    * @param Href href
    * @return Edge
    */
    public function setHref(Href $href)
    {
        $this->attribute($href->getName(), $href->getValue());
        return $this;
    }

    /**
    * @param Id id
    * @return Edge
    */
    public function setId(Id $id)
    {
        $this->attribute($id->getName(), $id->getValue());
        return $this;
    }

    /**
    * @param Label label
    * @return Edge
    */
    public function setLabel(Label $label)
    {
        $this->attribute($label->getName(), $label->getValue());
        return $this;
    }

    /**
    * @param LabelURL labelURL
    * @return Edge
    */
    public function setLabelURL(LabelURL $labelURL)
    {
        $this->attribute($labelURL->getName(), $labelURL->getValue());
        return $this;
    }

    /**
    * @param Labelangle labelangle
    * @return Edge
    */
    public function setLabelangle(Labelangle $labelangle)
    {
        $this->attribute($labelangle->getName(), $labelangle->getValue());
        return $this;
    }

    /**
    * @param Labeldistance labeldistance
    * @return Edge
    */
    public function setLabeldistance(Labeldistance $labeldistance)
    {
        $this->attribute($labeldistance->getName(), $labeldistance->getValue());
        return $this;
    }

    /**
    * @param Labelfloat labelfloat
    * @return Edge
    */
    public function setLabelfloat(Labelfloat $labelfloat)
    {
        $this->attribute($labelfloat->getName(), $labelfloat->getValue());
        return $this;
    }

    /**
    * @param Labelfontcolor labelfontcolor
    * @return Edge
    */
    public function setLabelfontcolor(Labelfontcolor $labelfontcolor)
    {
        $this->attribute($labelfontcolor->getName(), $labelfontcolor->getValue());
        return $this;
    }

    /**
    * @param Labelfontname labelfontname
    * @return Edge
    */
    public function setLabelfontname(Labelfontname $labelfontname)
    {
        $this->attribute($labelfontname->getName(), $labelfontname->getValue());
        return $this;
    }

    /**
    * @param Labelfontsize labelfontsize
    * @return Edge
    */
    public function setLabelfontsize(Labelfontsize $labelfontsize)
    {
        $this->attribute($labelfontsize->getName(), $labelfontsize->getValue());
        return $this;
    }

    /**
    * @param Labelhref labelhref
    * @return Edge
    */
    public function setLabelhref(Labelhref $labelhref)
    {
        $this->attribute($labelhref->getName(), $labelhref->getValue());
        return $this;
    }

    /**
    * @param Labeltarget labeltarget
    * @return Edge
    */
    public function setLabeltarget(Labeltarget $labeltarget)
    {
        $this->attribute($labeltarget->getName(), $labeltarget->getValue());
        return $this;
    }

    /**
    * @param Labeltooltip labeltooltip
    * @return Edge
    */
    public function setLabeltooltip(Labeltooltip $labeltooltip)
    {
        $this->attribute($labeltooltip->getName(), $labeltooltip->getValue());
        return $this;
    }

    /**
    * @param Layer layer
    * @return Edge
    */
    public function setLayer(Layer $layer)
    {
        $this->attribute($layer->getName(), $layer->getValue());
        return $this;
    }

    /**
    * @param Len len
    * @return Edge
    */
    public function setLen(Len $len)
    {
        $this->attribute($len->getName(), $len->getValue());
        return $this;
    }

    /**
    * @param Lhead lhead
    * @return Edge
    */
    public function setLhead(Lhead $lhead)
    {
        $this->attribute($lhead->getName(), $lhead->getValue());
        return $this;
    }

    /**
    * @param Lp lp
    * @return Edge
    */
    public function setLp(Lp $lp)
    {
        $this->attribute($lp->getName(), $lp->getValue());
        return $this;
    }

    /**
    * @param Ltail ltail
    * @return Edge
    */
    public function setLtail(Ltail $ltail)
    {
        $this->attribute($ltail->getName(), $ltail->getValue());
        return $this;
    }

    /**
    * @param Minlen minlen
    * @return Edge
    */
    public function setMinlen(Minlen $minlen)
    {
        $this->attribute($minlen->getName(), $minlen->getValue());
        return $this;
    }

    /**
    * @param Nojustify nojustify
    * @return Edge
    */
    public function setNojustify(Nojustify $nojustify)
    {
        $this->attribute($nojustify->getName(), $nojustify->getValue());
        return $this;
    }

    /**
    * @param Penwidth penwidth
    * @return Edge
    */
    public function setPenwidth(Penwidth $penwidth)
    {
        $this->attribute($penwidth->getName(), $penwidth->getValue());
        return $this;
    }

    /**
    * @param Pos pos
    * @return Edge
    */
    public function setPos(Pos $pos)
    {
        $this->attribute($pos->getName(), $pos->getValue());
        return $this;
    }

    /**
    * @param Samehead samehead
    * @return Edge
    */
    public function setSamehead(Samehead $samehead)
    {
        $this->attribute($samehead->getName(), $samehead->getValue());
        return $this;
    }

    /**
    * @param Sametail sametail
    * @return Edge
    */
    public function setSametail(Sametail $sametail)
    {
        $this->attribute($sametail->getName(), $sametail->getValue());
        return $this;
    }

    /**
    * @param Showboxes showboxes
    * @return Edge
    */
    public function setShowboxes(Showboxes $showboxes)
    {
        $this->attribute($showboxes->getName(), $showboxes->getValue());
        return $this;
    }

    /**
    * @param Style style
    * @return Edge
    */
    public function setStyle(Style $style)
    {
        $this->attribute($style->getName(), $style->getValue());
        return $this;
    }

    /**
    * @param TailURL tailURL
    * @return Edge
    */
    public function setTailURL(TailURL $tailURL)
    {
        $this->attribute($tailURL->getName(), $tailURL->getValue());
        return $this;
    }

    /**
    * @param Tail_lp tail_lp
    * @return Edge
    */
    public function setTail_lp(Tail_lp $tail_lp)
    {
        $this->attribute($tail_lp->getName(), $tail_lp->getValue());
        return $this;
    }

    /**
    * @param Tailclip tailclip
    * @return Edge
    */
    public function setTailclip(Tailclip $tailclip)
    {
        $this->attribute($tailclip->getName(), $tailclip->getValue());
        return $this;
    }

    /**
    * @param Tailhref tailhref
    * @return Edge
    */
    public function setTailhref(Tailhref $tailhref)
    {
        $this->attribute($tailhref->getName(), $tailhref->getValue());
        return $this;
    }

    /**
    * @param Taillabel taillabel
    * @return Edge
    */
    public function setTaillabel(Taillabel $taillabel)
    {
        $this->attribute($taillabel->getName(), $taillabel->getValue());
        return $this;
    }

    /**
    * @param Tailport tailport
    * @return Edge
    */
    public function setTailport(Tailport $tailport)
    {
        $this->attribute($tailport->getName(), $tailport->getValue());
        return $this;
    }

    /**
    * @param Tailtarget tailtarget
    * @return Edge
    */
    public function setTailtarget(Tailtarget $tailtarget)
    {
        $this->attribute($tailtarget->getName(), $tailtarget->getValue());
        return $this;
    }

    /**
    * @param Tailtooltip tailtooltip
    * @return Edge
    */
    public function setTailtooltip(Tailtooltip $tailtooltip)
    {
        $this->attribute($tailtooltip->getName(), $tailtooltip->getValue());
        return $this;
    }

    /**
    * @param Target target
    * @return Edge
    */
    public function setTarget(Target $target)
    {
        $this->attribute($target->getName(), $target->getValue());
        return $this;
    }

    /**
    * @param Tooltip tooltip
    * @return Edge
    */
    public function setTooltip(Tooltip $tooltip)
    {
        $this->attribute($tooltip->getName(), $tooltip->getValue());
        return $this;
    }

    /**
    * @param Weight weight
    * @return Edge
    */
    public function setWeight(Weight $weight)
    {
        $this->attribute($weight->getName(), $weight->getValue());
        return $this;
    }

    /**
    * @param Xlabel xlabel
    * @return Edge
    */
    public function setXlabel(Xlabel $xlabel)
    {
        $this->attribute($xlabel->getName(), $xlabel->getValue());
        return $this;
    }

    /**
    * @param Xlp xlp
    * @return Edge
    */
    public function setXlp(Xlp $xlp)
    {
        $this->attribute($xlp->getName(), $xlp->getValue());
        return $this;
    }
}