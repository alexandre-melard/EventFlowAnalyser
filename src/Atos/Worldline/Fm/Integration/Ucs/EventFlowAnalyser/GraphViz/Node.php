<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz;

use Alom\Graphviz\Node as BaseNode;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\URL;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Area;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Color;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Colorscheme;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Comment;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Distortion;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fillcolor;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fixedsize;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontcolor;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontname;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontsize;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Gradientangle;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Group;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Height;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Href;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Id;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Image;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Imagescale;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Label;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labelloc;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Layer;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Levels;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Margin;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Nojustify;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Ordering;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Orientation;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Penwidth;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Peripheries;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Pin;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Pos;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Rects;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Regular;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Root;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Samplepoints;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Shape;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Shapefile;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Showboxes;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Sides;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Skew;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Sortv;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Style;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Target;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Tooltip;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Vertices;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Width;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Xlabel;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Xlp;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Z;

class Node extends BaseNode
{

    public static function create($id)
    {
        return new Node($id);
    }

    /**
    * @param URL URL
    * @return Node
    */
    public function setURL(URL $URL)
    {
        $this->attribute($URL->getName(), $URL->getValue());
        return $this;
    }

    /**
    * @param Area area
    * @return Node
    */
    public function setArea(Area $area)
    {
        $this->attribute($area->getName(), $area->getValue());
        return $this;
    }

    /**
    * @param Color color
    * @return Node
    */
    public function setColor(Color $color)
    {
        $this->attribute($color->getName(), $color->getValue());
        return $this;
    }

    /**
    * @param Colorscheme colorscheme
    * @return Node
    */
    public function setColorscheme(Colorscheme $colorscheme)
    {
        $this->attribute($colorscheme->getName(), $colorscheme->getValue());
        return $this;
    }

    /**
    * @param Comment comment
    * @return Node
    */
    public function setComment(Comment $comment)
    {
        $this->attribute($comment->getName(), $comment->getValue());
        return $this;
    }

    /**
    * @param Distortion distortion
    * @return Node
    */
    public function setDistortion(Distortion $distortion)
    {
        $this->attribute($distortion->getName(), $distortion->getValue());
        return $this;
    }

    /**
    * @param Fillcolor fillcolor
    * @return Node
    */
    public function setFillcolor(Fillcolor $fillcolor)
    {
        $this->attribute($fillcolor->getName(), $fillcolor->getValue());
        return $this;
    }

    /**
    * @param Fixedsize fixedsize
    * @return Node
    */
    public function setFixedsize(Fixedsize $fixedsize)
    {
        $this->attribute($fixedsize->getName(), $fixedsize->getValue());
        return $this;
    }

    /**
    * @param Fontcolor fontcolor
    * @return Node
    */
    public function setFontcolor(Fontcolor $fontcolor)
    {
        $this->attribute($fontcolor->getName(), $fontcolor->getValue());
        return $this;
    }

    /**
    * @param Fontname fontname
    * @return Node
    */
    public function setFontname(Fontname $fontname)
    {
        $this->attribute($fontname->getName(), $fontname->getValue());
        return $this;
    }

    /**
    * @param Fontsize fontsize
    * @return Node
    */
    public function setFontsize(Fontsize $fontsize)
    {
        $this->attribute($fontsize->getName(), $fontsize->getValue());
        return $this;
    }

    /**
    * @param Gradientangle gradientangle
    * @return Node
    */
    public function setGradientangle(Gradientangle $gradientangle)
    {
        $this->attribute($gradientangle->getName(), $gradientangle->getValue());
        return $this;
    }

    /**
    * @param Group group
    * @return Node
    */
    public function setGroup(Group $group)
    {
        $this->attribute($group->getName(), $group->getValue());
        return $this;
    }

    /**
    * @param Height height
    * @return Node
    */
    public function setHeight(Height $height)
    {
        $this->attribute($height->getName(), $height->getValue());
        return $this;
    }

    /**
    * @param Href href
    * @return Node
    */
    public function setHref(Href $href)
    {
        $this->attribute($href->getName(), $href->getValue());
        return $this;
    }

    /**
    * @param Id id
    * @return Node
    */
    public function setId(Id $id)
    {
        $this->attribute($id->getName(), $id->getValue());
        return $this;
    }

    /**
    * @param Image image
    * @return Node
    */
    public function setImage(Image $image)
    {
        $this->attribute($image->getName(), $image->getValue());
        return $this;
    }

    /**
    * @param Imagescale imagescale
    * @return Node
    */
    public function setImagescale(Imagescale $imagescale)
    {
        $this->attribute($imagescale->getName(), $imagescale->getValue());
        return $this;
    }

    /**
    * @param Label label
    * @return Node
    */
    public function setLabel(Label $label)
    {
        $this->attribute($label->getName(), $label->getValue());
        return $this;
    }

    /**
    * @param Labelloc labelloc
    * @return Node
    */
    public function setLabelloc(Labelloc $labelloc)
    {
        $this->attribute($labelloc->getName(), $labelloc->getValue());
        return $this;
    }

    /**
    * @param Layer layer
    * @return Node
    */
    public function setLayer(Layer $layer)
    {
        $this->attribute($layer->getName(), $layer->getValue());
        return $this;
    }

    /**
    * @param Levels levels
    * @return Node
    */
    public function setLevels(Levels $levels)
    {
        $this->attribute($levels->getName(), $levels->getValue());
        return $this;
    }

    /**
    * @param Margin margin
    * @return Node
    */
    public function setMargin(Margin $margin)
    {
        $this->attribute($margin->getName(), $margin->getValue());
        return $this;
    }

    /**
    * @param Nojustify nojustify
    * @return Node
    */
    public function setNojustify(Nojustify $nojustify)
    {
        $this->attribute($nojustify->getName(), $nojustify->getValue());
        return $this;
    }

    /**
    * @param Ordering ordering
    * @return Node
    */
    public function setOrdering(Ordering $ordering)
    {
        $this->attribute($ordering->getName(), $ordering->getValue());
        return $this;
    }

    /**
    * @param Orientation orientation
    * @return Node
    */
    public function setOrientation(Orientation $orientation)
    {
        $this->attribute($orientation->getName(), $orientation->getValue());
        return $this;
    }

    /**
    * @param Penwidth penwidth
    * @return Node
    */
    public function setPenwidth(Penwidth $penwidth)
    {
        $this->attribute($penwidth->getName(), $penwidth->getValue());
        return $this;
    }

    /**
    * @param Peripheries peripheries
    * @return Node
    */
    public function setPeripheries(Peripheries $peripheries)
    {
        $this->attribute($peripheries->getName(), $peripheries->getValue());
        return $this;
    }

    /**
    * @param Pin pin
    * @return Node
    */
    public function setPin(Pin $pin)
    {
        $this->attribute($pin->getName(), $pin->getValue());
        return $this;
    }

    /**
    * @param Pos pos
    * @return Node
    */
    public function setPos(Pos $pos)
    {
        $this->attribute($pos->getName(), $pos->getValue());
        return $this;
    }

    /**
    * @param Rects rects
    * @return Node
    */
    public function setRects(Rects $rects)
    {
        $this->attribute($rects->getName(), $rects->getValue());
        return $this;
    }

    /**
    * @param Regular regular
    * @return Node
    */
    public function setRegular(Regular $regular)
    {
        $this->attribute($regular->getName(), $regular->getValue());
        return $this;
    }

    /**
    * @param Root root
    * @return Node
    */
    public function setRoot(Root $root)
    {
        $this->attribute($root->getName(), $root->getValue());
        return $this;
    }

    /**
    * @param Samplepoints samplepoints
    * @return Node
    */
    public function setSamplepoints(Samplepoints $samplepoints)
    {
        $this->attribute($samplepoints->getName(), $samplepoints->getValue());
        return $this;
    }

    /**
    * @param Shape shape
    * @return Node
    */
    public function setShape(Shape $shape)
    {
        $this->attribute($shape->getName(), $shape->getValue());
        return $this;
    }

    /**
    * @param Shapefile shapefile
    * @return Node
    */
    public function setShapefile(Shapefile $shapefile)
    {
        $this->attribute($shapefile->getName(), $shapefile->getValue());
        return $this;
    }

    /**
    * @param Showboxes showboxes
    * @return Node
    */
    public function setShowboxes(Showboxes $showboxes)
    {
        $this->attribute($showboxes->getName(), $showboxes->getValue());
        return $this;
    }

    /**
    * @param Sides sides
    * @return Node
    */
    public function setSides(Sides $sides)
    {
        $this->attribute($sides->getName(), $sides->getValue());
        return $this;
    }

    /**
    * @param Skew skew
    * @return Node
    */
    public function setSkew(Skew $skew)
    {
        $this->attribute($skew->getName(), $skew->getValue());
        return $this;
    }

    /**
    * @param Sortv sortv
    * @return Node
    */
    public function setSortv(Sortv $sortv)
    {
        $this->attribute($sortv->getName(), $sortv->getValue());
        return $this;
    }

    /**
    * @param Style style
    * @return Node
    */
    public function setStyle(Style $style)
    {
        $this->attribute($style->getName(), $style->getValue());
        return $this;
    }

    /**
    * @param Target target
    * @return Node
    */
    public function setTarget(Target $target)
    {
        $this->attribute($target->getName(), $target->getValue());
        return $this;
    }

    /**
    * @param Tooltip tooltip
    * @return Node
    */
    public function setTooltip(Tooltip $tooltip)
    {
        $this->attribute($tooltip->getName(), $tooltip->getValue());
        return $this;
    }

    /**
    * @param Vertices vertices
    * @return Node
    */
    public function setVertices(Vertices $vertices)
    {
        $this->attribute($vertices->getName(), $vertices->getValue());
        return $this;
    }

    /**
    * @param Width width
    * @return Node
    */
    public function setWidth(Width $width)
    {
        $this->attribute($width->getName(), $width->getValue());
        return $this;
    }

    /**
    * @param Xlabel xlabel
    * @return Node
    */
    public function setXlabel(Xlabel $xlabel)
    {
        $this->attribute($xlabel->getName(), $xlabel->getValue());
        return $this;
    }

    /**
    * @param Xlp xlp
    * @return Node
    */
    public function setXlp(Xlp $xlp)
    {
        $this->attribute($xlp->getName(), $xlp->getValue());
        return $this;
    }

    /**
    * @param Z z
    * @return Node
    */
    public function setZ(Z $z)
    {
        $this->attribute($z->getName(), $z->getValue());
        return $this;
    }
}