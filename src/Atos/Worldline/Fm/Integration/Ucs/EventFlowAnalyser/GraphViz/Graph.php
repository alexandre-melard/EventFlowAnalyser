<?php
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz;

use Alom\Graphviz\Digraph;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Damping;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\K;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\URL;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Aspect;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Bb;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Bgcolor;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Center;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Charset;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Clusterrank;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Colorscheme;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Comment;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Compound;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Concentrate;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Defaultdist;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Dim;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Dimen;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Diredgeconstraints;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Dpi;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Epsilon;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Esep;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontcolor;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontname;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontnames;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontpath;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Fontsize;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Forcelabels;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Gradientangle;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Href;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Id;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Imagepath;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Label;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Label_scheme;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labeljust;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Labelloc;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Landscape;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Layerlistsep;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Layers;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Layerselect;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Layersep;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Layout;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Levels;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Levelsgap;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Lheight;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Lp;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Lwidth;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Margin;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Maxiter;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Mclimit;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Mindist;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Mode;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Model;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Mosek;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Nodesep;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Nojustify;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Normalize;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Nslimit;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Nslimit1;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Ordering;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Orientation;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Outputorder;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Overlap;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Overlap_scaling;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Pack;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Packmode;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Pad;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Page;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Pagedir;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Quadtree;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Quantum;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Rankdir;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Ranksep;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Ratio;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Remincross;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Repulsiveforce;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Resolution;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Root;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Rotate;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Rotation;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Scale;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Searchsize;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Sep;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Showboxes;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Size;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Smoothing;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Sortv;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Splines;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Start;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Style;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Stylesheet;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Target;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Truecolor;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Viewport;
use Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\GraphViz\Attributes\Voro_margin;

class Graph extends Digraph
{

    public static function create($id)
    {
        return new Graph($id);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Alom\Graphviz\Graph::render()
     */
    public function render($indent = 0, $spaces = ' ')
    {
        $str = parent::render($indent, $spaces);
        $stream = tmpfile();
        $meta = stream_get_meta_data($stream);
        $filename = $meta["uri"];
        fwrite($stream, $str);
        var_dump($str);
        exec("D:\utils\GraphViz\bin\dot.exe  -Kneato -Tsvg $filename", $res, $status);
        $res = implode("\n", $res);
        return $res;
    }

    /**
    * @param Damping Damping
    * @return Graph
    */
    public function setDamping(Damping $Damping)
    {
        $this->set($Damping->getName(), $Damping->getValue());
        return $this;
    }

    /**
    * @param K K
    * @return Graph
    */
    public function setK(K $K)
    {
        $this->set($K->getName(), $K->getValue());
        return $this;
    }

    /**
    * @param URL URL
    * @return Graph
    */
    public function setURL(URL $URL)
    {
        $this->set($URL->getName(), $URL->getValue());
        return $this;
    }

    /**
    * @param Aspect aspect
    * @return Graph
    */
    public function setAspect(Aspect $aspect)
    {
        $this->set($aspect->getName(), $aspect->getValue());
        return $this;
    }

    /**
    * @param Bb bb
    * @return Graph
    */
    public function setBb(Bb $bb)
    {
        $this->set($bb->getName(), $bb->getValue());
        return $this;
    }

    /**
    * @param Bgcolor bgcolor
    * @return Graph
    */
    public function setBgcolor(Bgcolor $bgcolor)
    {
        $this->set($bgcolor->getName(), $bgcolor->getValue());
        return $this;
    }

    /**
    * @param Center center
    * @return Graph
    */
    public function setCenter(Center $center)
    {
        $this->set($center->getName(), $center->getValue());
        return $this;
    }

    /**
    * @param Charset charset
    * @return Graph
    */
    public function setCharset(Charset $charset)
    {
        $this->set($charset->getName(), $charset->getValue());
        return $this;
    }

    /**
    * @param Clusterrank clusterrank
    * @return Graph
    */
    public function setClusterrank(Clusterrank $clusterrank)
    {
        $this->set($clusterrank->getName(), $clusterrank->getValue());
        return $this;
    }

    /**
    * @param Colorscheme colorscheme
    * @return Graph
    */
    public function setColorscheme(Colorscheme $colorscheme)
    {
        $this->set($colorscheme->getName(), $colorscheme->getValue());
        return $this;
    }

    /**
    * @param Comment comment
    * @return Graph
    */
    public function setComment(Comment $comment)
    {
        $this->set($comment->getName(), $comment->getValue());
        return $this;
    }

    /**
    * @param Compound compound
    * @return Graph
    */
    public function setCompound(Compound $compound)
    {
        $this->set($compound->getName(), $compound->getValue());
        return $this;
    }

    /**
    * @param Concentrate concentrate
    * @return Graph
    */
    public function setConcentrate(Concentrate $concentrate)
    {
        $this->set($concentrate->getName(), $concentrate->getValue());
        return $this;
    }

    /**
    * @param Defaultdist defaultdist
    * @return Graph
    */
    public function setDefaultdist(Defaultdist $defaultdist)
    {
        $this->set($defaultdist->getName(), $defaultdist->getValue());
        return $this;
    }

    /**
    * @param Dim dim
    * @return Graph
    */
    public function setDim(Dim $dim)
    {
        $this->set($dim->getName(), $dim->getValue());
        return $this;
    }

    /**
    * @param Dimen dimen
    * @return Graph
    */
    public function setDimen(Dimen $dimen)
    {
        $this->set($dimen->getName(), $dimen->getValue());
        return $this;
    }

    /**
    * @param Diredgeconstraints diredgeconstraints
    * @return Graph
    */
    public function setDiredgeconstraints(Diredgeconstraints $diredgeconstraints)
    {
        $this->set($diredgeconstraints->getName(), $diredgeconstraints->getValue());
        return $this;
    }

    /**
    * @param Dpi dpi
    * @return Graph
    */
    public function setDpi(Dpi $dpi)
    {
        $this->set($dpi->getName(), $dpi->getValue());
        return $this;
    }

    /**
    * @param Epsilon epsilon
    * @return Graph
    */
    public function setEpsilon(Epsilon $epsilon)
    {
        $this->set($epsilon->getName(), $epsilon->getValue());
        return $this;
    }

    /**
    * @param Esep esep
    * @return Graph
    */
    public function setEsep(Esep $esep)
    {
        $this->set($esep->getName(), $esep->getValue());
        return $this;
    }

    /**
    * @param Fontcolor fontcolor
    * @return Graph
    */
    public function setFontcolor(Fontcolor $fontcolor)
    {
        $this->set($fontcolor->getName(), $fontcolor->getValue());
        return $this;
    }

    /**
    * @param Fontname fontname
    * @return Graph
    */
    public function setFontname(Fontname $fontname)
    {
        $this->set($fontname->getName(), $fontname->getValue());
        return $this;
    }

    /**
    * @param Fontnames fontnames
    * @return Graph
    */
    public function setFontnames(Fontnames $fontnames)
    {
        $this->set($fontnames->getName(), $fontnames->getValue());
        return $this;
    }

    /**
    * @param Fontpath fontpath
    * @return Graph
    */
    public function setFontpath(Fontpath $fontpath)
    {
        $this->set($fontpath->getName(), $fontpath->getValue());
        return $this;
    }

    /**
    * @param Fontsize fontsize
    * @return Graph
    */
    public function setFontsize(Fontsize $fontsize)
    {
        $this->set($fontsize->getName(), $fontsize->getValue());
        return $this;
    }

    /**
    * @param Forcelabels forcelabels
    * @return Graph
    */
    public function setForcelabels(Forcelabels $forcelabels)
    {
        $this->set($forcelabels->getName(), $forcelabels->getValue());
        return $this;
    }

    /**
    * @param Gradientangle gradientangle
    * @return Graph
    */
    public function setGradientangle(Gradientangle $gradientangle)
    {
        $this->set($gradientangle->getName(), $gradientangle->getValue());
        return $this;
    }

    /**
    * @param Href href
    * @return Graph
    */
    public function setHref(Href $href)
    {
        $this->set($href->getName(), $href->getValue());
        return $this;
    }

    /**
    * @param Id id
    * @return Graph
    */
    public function setId(Id $id)
    {
        $this->set($id->getName(), $id->getValue());
        return $this;
    }

    /**
    * @param Imagepath imagepath
    * @return Graph
    */
    public function setImagepath(Imagepath $imagepath)
    {
        $this->set($imagepath->getName(), $imagepath->getValue());
        return $this;
    }

    /**
    * @param Label label
    * @return Graph
    */
    public function setLabel(Label $label)
    {
        $this->set($label->getName(), $label->getValue());
        return $this;
    }

    /**
    * @param Label_scheme label_scheme
    * @return Graph
    */
    public function setLabel_scheme(Label_scheme $label_scheme)
    {
        $this->set($label_scheme->getName(), $label_scheme->getValue());
        return $this;
    }

    /**
    * @param Labeljust labeljust
    * @return Graph
    */
    public function setLabeljust(Labeljust $labeljust)
    {
        $this->set($labeljust->getName(), $labeljust->getValue());
        return $this;
    }

    /**
    * @param Labelloc labelloc
    * @return Graph
    */
    public function setLabelloc(Labelloc $labelloc)
    {
        $this->set($labelloc->getName(), $labelloc->getValue());
        return $this;
    }

    /**
    * @param Landscape landscape
    * @return Graph
    */
    public function setLandscape(Landscape $landscape)
    {
        $this->set($landscape->getName(), $landscape->getValue());
        return $this;
    }

    /**
    * @param Layerlistsep layerlistsep
    * @return Graph
    */
    public function setLayerlistsep(Layerlistsep $layerlistsep)
    {
        $this->set($layerlistsep->getName(), $layerlistsep->getValue());
        return $this;
    }

    /**
    * @param Layers layers
    * @return Graph
    */
    public function setLayers(Layers $layers)
    {
        $this->set($layers->getName(), $layers->getValue());
        return $this;
    }

    /**
    * @param Layerselect layerselect
    * @return Graph
    */
    public function setLayerselect(Layerselect $layerselect)
    {
        $this->set($layerselect->getName(), $layerselect->getValue());
        return $this;
    }

    /**
    * @param Layersep layersep
    * @return Graph
    */
    public function setLayersep(Layersep $layersep)
    {
        $this->set($layersep->getName(), $layersep->getValue());
        return $this;
    }

    /**
    * @param Layout layout
    * @return Graph
    */
    public function setLayout(Layout $layout)
    {
        $this->set($layout->getName(), $layout->getValue());
        return $this;
    }

    /**
    * @param Levels levels
    * @return Graph
    */
    public function setLevels(Levels $levels)
    {
        $this->set($levels->getName(), $levels->getValue());
        return $this;
    }

    /**
    * @param Levelsgap levelsgap
    * @return Graph
    */
    public function setLevelsgap(Levelsgap $levelsgap)
    {
        $this->set($levelsgap->getName(), $levelsgap->getValue());
        return $this;
    }

    /**
    * @param Lheight lheight
    * @return Graph
    */
    public function setLheight(Lheight $lheight)
    {
        $this->set($lheight->getName(), $lheight->getValue());
        return $this;
    }

    /**
    * @param Lp lp
    * @return Graph
    */
    public function setLp(Lp $lp)
    {
        $this->set($lp->getName(), $lp->getValue());
        return $this;
    }

    /**
    * @param Lwidth lwidth
    * @return Graph
    */
    public function setLwidth(Lwidth $lwidth)
    {
        $this->set($lwidth->getName(), $lwidth->getValue());
        return $this;
    }

    /**
    * @param Margin margin
    * @return Graph
    */
    public function setMargin(Margin $margin)
    {
        $this->set($margin->getName(), $margin->getValue());
        return $this;
    }

    /**
    * @param Maxiter maxiter
    * @return Graph
    */
    public function setMaxiter(Maxiter $maxiter)
    {
        $this->set($maxiter->getName(), $maxiter->getValue());
        return $this;
    }

    /**
    * @param Mclimit mclimit
    * @return Graph
    */
    public function setMclimit(Mclimit $mclimit)
    {
        $this->set($mclimit->getName(), $mclimit->getValue());
        return $this;
    }

    /**
    * @param Mindist mindist
    * @return Graph
    */
    public function setMindist(Mindist $mindist)
    {
        $this->set($mindist->getName(), $mindist->getValue());
        return $this;
    }

    /**
    * @param Mode mode
    * @return Graph
    */
    public function setMode(Mode $mode)
    {
        $this->set($mode->getName(), $mode->getValue());
        return $this;
    }

    /**
    * @param Model model
    * @return Graph
    */
    public function setModel(Model $model)
    {
        $this->set($model->getName(), $model->getValue());
        return $this;
    }

    /**
    * @param Mosek mosek
    * @return Graph
    */
    public function setMosek(Mosek $mosek)
    {
        $this->set($mosek->getName(), $mosek->getValue());
        return $this;
    }

    /**
    * @param Nodesep nodesep
    * @return Graph
    */
    public function setNodesep(Nodesep $nodesep)
    {
        $this->set($nodesep->getName(), $nodesep->getValue());
        return $this;
    }

    /**
    * @param Nojustify nojustify
    * @return Graph
    */
    public function setNojustify(Nojustify $nojustify)
    {
        $this->set($nojustify->getName(), $nojustify->getValue());
        return $this;
    }

    /**
    * @param Normalize normalize
    * @return Graph
    */
    public function setNormalize(Normalize $normalize)
    {
        $this->set($normalize->getName(), $normalize->getValue());
        return $this;
    }

    /**
    * @param Nslimit nslimit
    * @return Graph
    */
    public function setNslimit(Nslimit $nslimit)
    {
        $this->set($nslimit->getName(), $nslimit->getValue());
        return $this;
    }

    /**
    * @param Nslimit1 nslimit1
    * @return Graph
    */
    public function setNslimit1(Nslimit1 $nslimit1)
    {
        $this->set($nslimit1->getName(), $nslimit1->getValue());
        return $this;
    }

    /**
    * @param Ordering ordering
    * @return Graph
    */
    public function setOrdering(Ordering $ordering)
    {
        $this->set($ordering->getName(), $ordering->getValue());
        return $this;
    }

    /**
    * @param Orientation orientation
    * @return Graph
    */
    public function setOrientation(Orientation $orientation)
    {
        $this->set($orientation->getName(), $orientation->getValue());
        return $this;
    }

    /**
    * @param Outputorder outputorder
    * @return Graph
    */
    public function setOutputorder(Outputorder $outputorder)
    {
        $this->set($outputorder->getName(), $outputorder->getValue());
        return $this;
    }

    /**
    * @param Overlap overlap
    * @return Graph
    */
    public function setOverlap(Overlap $overlap)
    {
        $this->set($overlap->getName(), $overlap->getValue());
        return $this;
    }

    /**
    * @param Overlap_scaling overlap_scaling
    * @return Graph
    */
    public function setOverlap_scaling(Overlap_scaling $overlap_scaling)
    {
        $this->set($overlap_scaling->getName(), $overlap_scaling->getValue());
        return $this;
    }

    /**
    * @param Pack pack
    * @return Graph
    */
    public function setPack(Pack $pack)
    {
        $this->set($pack->getName(), $pack->getValue());
        return $this;
    }

    /**
    * @param Packmode packmode
    * @return Graph
    */
    public function setPackmode(Packmode $packmode)
    {
        $this->set($packmode->getName(), $packmode->getValue());
        return $this;
    }

    /**
    * @param Pad pad
    * @return Graph
    */
    public function setPad(Pad $pad)
    {
        $this->set($pad->getName(), $pad->getValue());
        return $this;
    }

    /**
    * @param Page page
    * @return Graph
    */
    public function setPage(Page $page)
    {
        $this->set($page->getName(), $page->getValue());
        return $this;
    }

    /**
    * @param Pagedir pagedir
    * @return Graph
    */
    public function setPagedir(Pagedir $pagedir)
    {
        $this->set($pagedir->getName(), $pagedir->getValue());
        return $this;
    }

    /**
    * @param Quadtree quadtree
    * @return Graph
    */
    public function setQuadtree(Quadtree $quadtree)
    {
        $this->set($quadtree->getName(), $quadtree->getValue());
        return $this;
    }

    /**
    * @param Quantum quantum
    * @return Graph
    */
    public function setQuantum(Quantum $quantum)
    {
        $this->set($quantum->getName(), $quantum->getValue());
        return $this;
    }

    /**
    * @param Rankdir rankdir
    * @return Graph
    */
    public function setRankdir(Rankdir $rankdir)
    {
        $this->set($rankdir->getName(), $rankdir->getValue());
        return $this;
    }

    /**
    * @param Ranksep ranksep
    * @return Graph
    */
    public function setRanksep(Ranksep $ranksep)
    {
        $this->set($ranksep->getName(), $ranksep->getValue());
        return $this;
    }

    /**
    * @param Ratio ratio
    * @return Graph
    */
    public function setRatio(Ratio $ratio)
    {
        $this->set($ratio->getName(), $ratio->getValue());
        return $this;
    }

    /**
    * @param Remincross remincross
    * @return Graph
    */
    public function setRemincross(Remincross $remincross)
    {
        $this->set($remincross->getName(), $remincross->getValue());
        return $this;
    }

    /**
    * @param Repulsiveforce repulsiveforce
    * @return Graph
    */
    public function setRepulsiveforce(Repulsiveforce $repulsiveforce)
    {
        $this->set($repulsiveforce->getName(), $repulsiveforce->getValue());
        return $this;
    }

    /**
    * @param Resolution resolution
    * @return Graph
    */
    public function setResolution(Resolution $resolution)
    {
        $this->set($resolution->getName(), $resolution->getValue());
        return $this;
    }

    /**
    * @param Root root
    * @return Graph
    */
    public function setRoot(Root $root)
    {
        $this->set($root->getName(), $root->getValue());
        return $this;
    }

    /**
    * @param Rotate rotate
    * @return Graph
    */
    public function setRotate(Rotate $rotate)
    {
        $this->set($rotate->getName(), $rotate->getValue());
        return $this;
    }

    /**
    * @param Rotation rotation
    * @return Graph
    */
    public function setRotation(Rotation $rotation)
    {
        $this->set($rotation->getName(), $rotation->getValue());
        return $this;
    }

    /**
    * @param Scale scale
    * @return Graph
    */
    public function setScale(Scale $scale)
    {
        $this->set($scale->getName(), $scale->getValue());
        return $this;
    }

    /**
    * @param Searchsize searchsize
    * @return Graph
    */
    public function setSearchsize(Searchsize $searchsize)
    {
        $this->set($searchsize->getName(), $searchsize->getValue());
        return $this;
    }

    /**
    * @param Sep sep
    * @return Graph
    */
    public function setSep(Sep $sep)
    {
        $this->set($sep->getName(), $sep->getValue());
        return $this;
    }

    /**
    * @param Showboxes showboxes
    * @return Graph
    */
    public function setShowboxes(Showboxes $showboxes)
    {
        $this->set($showboxes->getName(), $showboxes->getValue());
        return $this;
    }

    /**
    * @param Size size
    * @return Graph
    */
    public function setSize(Size $size)
    {
        $this->set($size->getName(), $size->getValue());
        return $this;
    }

    /**
    * @param Smoothing smoothing
    * @return Graph
    */
    public function setSmoothing(Smoothing $smoothing)
    {
        $this->set($smoothing->getName(), $smoothing->getValue());
        return $this;
    }

    /**
    * @param Sortv sortv
    * @return Graph
    */
    public function setSortv(Sortv $sortv)
    {
        $this->set($sortv->getName(), $sortv->getValue());
        return $this;
    }

    /**
    * @param Splines splines
    * @return Graph
    */
    public function setSplines(Splines $splines)
    {
        $this->set($splines->getName(), $splines->getValue());
        return $this;
    }

    /**
    * @param Start start
    * @return Graph
    */
    public function setStart(Start $start)
    {
        $this->set($start->getName(), $start->getValue());
        return $this;
    }

    /**
    * @param Style style
    * @return Graph
    */
    public function setStyle(Style $style)
    {
        $this->set($style->getName(), $style->getValue());
        return $this;
    }

    /**
    * @param Stylesheet stylesheet
    * @return Graph
    */
    public function setStylesheet(Stylesheet $stylesheet)
    {
        $this->set($stylesheet->getName(), $stylesheet->getValue());
        return $this;
    }

    /**
    * @param Target target
    * @return Graph
    */
    public function setTarget(Target $target)
    {
        $this->set($target->getName(), $target->getValue());
        return $this;
    }

    /**
    * @param Truecolor truecolor
    * @return Graph
    */
    public function setTruecolor(Truecolor $truecolor)
    {
        $this->set($truecolor->getName(), $truecolor->getValue());
        return $this;
    }

    /**
    * @param Viewport viewport
    * @return Graph
    */
    public function setViewport(Viewport $viewport)
    {
        $this->set($viewport->getName(), $viewport->getValue());
        return $this;
    }

    /**
    * @param Voro_margin voro_margin
    * @return Graph
    */
    public function setVoro_margin(Voro_margin $voro_margin)
    {
        $this->set($voro_margin->getName(), $voro_margin->getValue());
        return $this;
    }
}