<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* frontend/index.twig */
class __TwigTemplate_3d15dc93cd5b5e348ae7913192f45fab extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "frontend/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("frontend/layout.twig", "frontend/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("home"), "html", null, true);
        yield " ";
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 6
        yield "<div class=\"container-fluid pb-4 pt-4\">
  <div class=\"container-fluid paddding\">
    <div class=\"row mx-0\">

      ";
        // line 11
        yield "      <div class=\"col-md-8 animate-box\" data-animate-effect=\"fadeInLeft\">
        <div class=\"container\">
            <div class=\"row\">
              <div class=\"col-md-5 fh5co_heading fh5co_heading_border_bottom py-2 mb-4\">";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("articles"), "html", null, true);
        yield "
              </div>
            </div>
          <div class=\"container-fluid paddding\">
            
            ";
        // line 19
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["articles"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["article"]) {
            yield " 
            <div class=\"row pb-4\">
              <div class=\"col-md-5\">
                <div class=\"fh5co_hover_news_img\">
                  <div class=\"fh5co_news_img\">
                    <img
                      src=\"/assets/";
            // line 25
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["article"], "featured_image", [], "any", false, false, false, 25)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "featured_image", [], "any", false, false, false, 25), "html", null, true)) : ("/default_images/default_image.png"));
            yield "\"
                      alt=\"";
            // line 26
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "title", [], "any", false, false, false, 26), "html", null, true);
            yield "\" />
                  </div>
                  <div></div>
                </div>
              </div>
              <div class=\"col-md-7 animate-box\">
                <div>
                  <a href=\"/article/";
            // line 33
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "slug", [], "any", false, false, false, 33), "html", null, true);
            yield "\" class=\"fh5co_magna py-2\"> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "title", [], "any", false, false, false, 33), "html", null, true);
            yield " </a> 
                </div>
                <div>
                  <a href=\"/article/";
            // line 36
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "slug", [], "any", false, false, false, 36), "html", null, true);
            yield "\" class=\"fh5co_mini_time py-3\"> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "publisher", [], "any", false, false, false, 36), "html", null, true);
            yield " - <i class=\"fa fa-clock-o\"></i> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source,             // line 37
$context["article"], "publication_date", [], "any", false, false, false, 37), "F j, Y"), "html", null, true);
            yield "</a>
                </div>
                <div class=\"fh5co_consectetur\"> ";
            // line 39
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((Twig\Extension\CoreExtension::slice($this->env->getCharset(), Twig\Extension\CoreExtension::striptags(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "content", [], "any", false, false, false, 39)), 0, 150) . "..."), "html", null, true);
            yield "
                </div>
                <a href=\"/article/";
            // line 41
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "slug", [], "any", false, false, false, 41), "html", null, true);
            yield "\" class=\"read-more\">Read More</a>
              </div>
            </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['article'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 45
        yield "          </div>
          <div class=\"row\">
            <div class=\"col-12 text-center pb-4 pt-4 mx-0 animate-box\" data-animate-effect=\"fadeInUp\">
              <!-- <a href=\"#\" class=\"btn_mange_pagging\"><i class=\"fa fa-long-arrow-left\"></i>&nbsp;&nbsp; Previous</a>
                <a href=\"#\" class=\"btn_pagging\">1</a>
                <a href=\"#\" class=\"btn_pagging\">2</a>
                <a href=\"#\" class=\"btn_pagging\">3</a>
                <a href=\"#\" class=\"btn_pagging\">...</a>
                <a href=\"#\" class=\"btn_mange_pagging\">Next <i class=\"fa fa-long-arrow-right\"></i>&nbsp;&nbsp; </a> -->
              ";
        // line 54
        if ((($context["currentPage"] ?? null) > 1)) {
            // line 55
            yield "              <a href=\"?page=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($context["currentPage"] ?? null) - 1), "html", null, true);
            yield "\" class=\"btn_mange_pagging\">
                <i class=\"fa fa-long-arrow-left\"></i>&nbsp;&nbsp; Previous
              </a>
              ";
        }
        // line 59
        yield "
              ";
        // line 60
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(1, ($context["totalPages"] ?? null)));
        foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
            // line 61
            yield "              <a href=\"?page=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page"], "html", null, true);
            yield "\" class=\"";
            yield ((($context["page"] == ($context["currentPage"] ?? null))) ? ("active btn_pagging") : ("btn_pagging"));
            yield "\">
                ";
            // line 62
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page"], "html", null, true);
            yield "
              </a>
              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['page'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 65
        yield "
              ";
        // line 66
        if ((($context["currentPage"] ?? null) < ($context["totalPages"] ?? null))) {
            yield " <a href=\"?page=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($context["currentPage"] ?? null) + 1), "html", null, true);
            yield "\" class=\"btn_mange_pagging\">
                Next <i class=\"fa fa-long-arrow-right\"></i>&nbsp;&nbsp;
                </a>
                ";
        }
        // line 70
        yield "            </div>
          </div>
        </div>
      </div>

      <div class=\"col-md-3 animate-box\" data-animate-effect=\"fadeInRight\">
        <div class=\"container\">

          <div class=\"row\">
            <div>
              <div class=\"fh5co_heading fh5co_heading_border_bottom py-2 mb-4\">";
        // line 80
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("most_popular"), "html", null, true);
        yield "</div>
            </div>

            ";
        // line 83
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["articles"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["article"]) {
            // line 84
            yield "            <div class=\"row pb-3\">
              <div class=\"col-5 align-self-center\">
                <img src=\"/assets/";
            // line 86
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["article"], "featured_image", [], "any", false, false, false, 86)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "featured_image", [], "any", false, false, false, 86), "html", null, true)) : ("/default_images/default_image.png"));
            yield "\" alt=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "title", [], "any", false, false, false, 86), "html", null, true);
            yield "\" class=\"fh5co_most_trading\" />
              </div>
              <div class=\"col-7 paddding\">
                <div class=\"most_fh5co_treding_font\"> 
                  <a href=\"/article/";
            // line 90
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "slug", [], "any", false, false, false, 90), "html", null, true);
            yield "\"> 
                    ";
            // line 91
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "title", [], "any", false, false, false, 91), "html", null, true);
            yield "
                  </a>
                </div>
                <div class=\"most_fh5co_treding_font_123\"> ";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "publisher", [], "any", false, false, false, 94), "html", null, true);
            yield " - <i class=\"fa fa-clock-o\"></i> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "publication_date", [], "any", false, false, false, 94), "F j, Y"), "html", null, true);
            yield "</div>
              </div>
            </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['article'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 98
        yield "          </div>

          <div class=\"row\">
            <div>
              <div class=\"fh5co_heading fh5co_heading_border_bottom py-2 mb-4\">";
        // line 102
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("featured_posts"), "html", null, true);
        yield "</div>
            </div>

            ";
        // line 105
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["articles"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["article"]) {
            // line 106
            yield "            <div class=\"row pb-3\">
              <div class=\"col-5 align-self-center\">
                <img src=\"/assets/";
            // line 108
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["article"], "featured_image", [], "any", false, false, false, 108)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "featured_image", [], "any", false, false, false, 108), "html", null, true)) : ("/default_images/default_image.png"));
            yield "\" alt=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "title", [], "any", false, false, false, 108), "html", null, true);
            yield "\" class=\"fh5co_most_trading\"  />
              </div>
              <div class=\"col-7 paddding\">
                <div class=\"most_fh5co_treding_font\"> <a href=\"/article/";
            // line 111
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "slug", [], "any", false, false, false, 111), "html", null, true);
            yield "\"> 
                  ";
            // line 112
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "title", [], "any", false, false, false, 112), "html", null, true);
            yield "
                </a></div>
                <div class=\"most_fh5co_treding_font_123\"> ";
            // line 114
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "publisher", [], "any", false, false, false, 114), "html", null, true);
            yield " - <i class=\"fa fa-clock-o\"></i> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["article"], "publication_date", [], "any", false, false, false, 114), "F j, Y"), "html", null, true);
            yield "</div>
              </div>
            </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['article'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 118
        yield "          </div>
        </div>
      </div>
    </div>
  </div>
</div>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "frontend/index.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  311 => 118,  299 => 114,  294 => 112,  290 => 111,  282 => 108,  278 => 106,  274 => 105,  268 => 102,  262 => 98,  250 => 94,  244 => 91,  240 => 90,  231 => 86,  227 => 84,  223 => 83,  217 => 80,  205 => 70,  196 => 66,  193 => 65,  184 => 62,  177 => 61,  173 => 60,  170 => 59,  162 => 55,  160 => 54,  149 => 45,  139 => 41,  134 => 39,  129 => 37,  124 => 36,  116 => 33,  106 => 26,  102 => 25,  91 => 19,  83 => 14,  78 => 11,  72 => 6,  65 => 5,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "frontend/index.twig", "/shared/httpd/jessicajacobson/htdocs/templates/frontend/index.twig");
    }
}
