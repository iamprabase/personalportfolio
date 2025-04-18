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

/* admin/layout.twig */
class __TwigTemplate_e54aa177d51c95c257328675a497d383 extends Template
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

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\" class=\"no-js\">

<head>
  <!-- Required meta tags -->
  <meta charset=\"utf-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
  <title>";
        // line 8
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
  <link href=\"/assets/backend/css/media_query.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"/assets/backend/css/bootstrap.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"/assets/frontend/css/font-awesome/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"/assets/backend/css/animate.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"https://fonts.googleapis.com/css?family=Poppins\" rel=\"stylesheet\">
  <link href=\"/assets/backend/css/owl.carousel.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"/assets/backend/css/owl.theme.default.css\" rel=\"stylesheet\" type=\"text/css\" />
  <!-- Bootstrap CSS -->
  <link href=\"/assets/backend/css/style_1.css\" rel=\"stylesheet\" type=\"text/css\" />
  <!-- Modernizr JS -->
  <script src=\"/assets/backend/js/modernizr-3.5.0.min.js\"></script>
</head>

<body>
  <div class=\"container-fluid\">
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-12 col-md-3 fh5co_padding_menu\">
          <img src=\"/assets/frontend/default_images/logo.png\" alt=\"img\" class=\"fh5co_logo_width\" />
        </div>
        <div class=\"col-12 col-md-9 align-self-center fh5co_mediya_right\">
          <div class=\"text-center d-inline-block\">
            <a class=\"fh5co_display_table\">
              <div class=\"fh5co_verticle_middle\"><i class=\"fa fa-search\"></i></div>
            </a>
          </div>
          <div class=\"text-center d-inline-block\">
            <a class=\"fh5co_display_table\">
              <div class=\"fh5co_verticle_middle\"><i class=\"fa fa-linkedin\"></i></div>
            </a>
          </div>
          <div class=\"text-center d-inline-block\">
            <a class=\"fh5co_display_table\">
              <div class=\"fh5co_verticle_middle\"><i class=\"fa fa-google-plus\"></i></div>
            </a>
          </div>
          <div class=\"text-center d-inline-block\">
            <a href=\"https://twitter.com/fh5co\" target=\"_blank\" class=\"fh5co_display_table\">
              <div class=\"fh5co_verticle_middle\"><i class=\"fa fa-twitter\"></i></div>
            </a>
          </div>
          <div class=\"text-center d-inline-block\">
            <a href=\"https://fb.com/fh5co\" target=\"_blank\" class=\"fh5co_display_table\">
              <div class=\"fh5co_verticle_middle\"><i class=\"fa fa-facebook\"></i></div>
            </a>
          </div>
          <!--<div class=\"d-inline-block text-center\"><img src=\"images/country.png\" alt=\"img\" class=\"fh5co_country_width\"/></div>-->
          <div class=\"d-inline-block text-center dd_position_relative \">
            <select class=\"form-control fh5co_text_select_option\">
              <option>English </option>
              <option>French </option>
              <option>German </option>
              <option>Spanish </option>
            </select>
          </div>
          <div class=\"clearfix\"></div>
        </div>
      </div>
    </div>
  </div>

  <div class=\"container-fluid bg-faded fh5co_padd_mediya padding_786\">
    <div class=\"container padding_786\">
      <nav class=\"navbar navbar-toggleable-md navbar-light \">
        <button class=\"navbar-toggler navbar-toggler-right mt-3\" type=\"button\" data-toggle=\"collapse\"
          data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\"
          aria-label=\"Toggle navigation\"><span class=\"fa fa-bars\"></span></button>
        <a class=\"navbar-brand\" href=\"#\"><img src=\"images/logo.png\" alt=\"img\" class=\"mobile_logo_width\" /></a>
        <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
          <ul class=\"navbar-nav mr-auto\">
            <li class=\"nav-item active\">
              <a class=\"nav-link\" href=\"index.html\">Home <span class=\"sr-only\">(current)</span></a>
            </li>
            <li class=\"nav-item \">
              <a class=\"nav-link\" href=\"blog.html\">Blog <span class=\"sr-only\">(current)</span></a>
            </li>
            <li class=\"nav-item \">
              <a class=\"nav-link\" href=\"single.html\">Single <span class=\"sr-only\">(current)</span></a>
            </li>
            <li class=\"nav-item dropdown\">
              <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"dropdownMenuButton2\" data-toggle=\"dropdown\"
                aria-haspopup=\"true\" aria-expanded=\"false\">World <span class=\"sr-only\">(current)</span></a>
              <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuLink_1\">
                <a class=\"dropdown-item\" href=\"#\">Action in</a>
                <a class=\"dropdown-item\" href=\"#\">Another action</a>
                <a class=\"dropdown-item\" href=\"#\">Something else here</a>
              </div>
            </li>
            <li class=\"nav-item dropdown\">
              <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"dropdownMenuButton3\" data-toggle=\"dropdown\"
                aria-haspopup=\"true\" aria-expanded=\"false\">Community<span class=\"sr-only\">(current)</span></a>
              <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuLink_1\">
                <a class=\"dropdown-item\" href=\"#\">Action in</a>
                <a class=\"dropdown-item\" href=\"#\">Another action</a>
                <a class=\"dropdown-item\" href=\"#\">Something else here</a>
              </div>
            </li>
            <li class=\"nav-item \">
              <a class=\"nav-link\" href=\"Contact_us.html\">Contact <span class=\"sr-only\">(current)</span></a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>

  <div class=\"container-fluid paddding mb-5\">
    <div class=\"row mx-0\">
      <div class=\"col-12 paddding animate-box\" data-animate-effect=\"fadeIn\">
        <div class=\"fh5co_suceefh5co_height\"><img src=\"images/nick-karvounis-78711.jpg\" alt=\"img\" />
          <div class=\"fh5co_suceefh5co_height_position_absolute\"></div>
          <div class=\"fh5co_suceefh5co_height_position_absolute_font\">
            <div class=\"\"><a href=\"#\" class=\"color_fff\"> <i class=\"fa fa-clock-o\"></i>&nbsp;&nbsp;Dec 31,2017
              </a></div>
            <div class=\"\"><a href=\"single.html\" class=\"fh5co_good_font\"> After all is said and done, more is said than
                done </a></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class=\"container-fluid pb-4 pt-4\">
    <div class=\"container-fluid paddding\">
      <div class=\"row mx-0\">


        ";
        // line 137
        yield "        <div class=\"col-md-8 animate-box\" data-animate-effect=\"fadeInLeft\">
          <div class=\"container\">
            <div class=\"row\">
              <div>
                <div class=\"fh5co_heading fh5co_heading_border_bottom py-2 mb-4\">";
        // line 141
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("articles"), "html", null, true);
        yield "
                </div>
              </div>

              <div class=\"row pb-4\">
                <div class=\"col-md-5\">
                  <div class=\"fh5co_hover_news_img\">
                    <div class=\"fh5co_news_img\"><img
                        src=\"/assets/";
        // line 149
        yield ((CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "featured_image", [], "any", false, false, false, 149)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "featured_image", [], "any", false, false, false, 149), "html", null, true)) : ("/default_images/default_image.png"));
        yield "\"
                        alt=\"";
        // line 150
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "title", [], "any", false, false, false, 150), "html", null, true);
        yield "\" />
                    </div>
                    <div>

                    </div>
                  </div>
                </div>
                <div class=\"col-md-7 animate-box\">
                  <a href=\"/articles/";
        // line 158
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "slug", [], "any", false, false, false, 158), "html", null, true);
        yield "\" class=\"fh5co_magna py-2\"> ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "title", [], "any", false, false, false, 158), "html", null, true);
        yield " </a> <a
                    href=\"/articles/";
        // line 159
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "slug", [], "any", false, false, false, 159), "html", null, true);
        yield "\" class=\"fh5co_mini_time py-3\"> ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "publisher", [], "any", false, false, false, 159), "html", null, true);
        yield " - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source,         // line 160
($context["article"] ?? null), "publication_date", [], "any", false, false, false, 160), "F j, Y"), "html", null, true);
        yield "</a>
                  <div class=\"fh5co_consectetur\"> ";
        // line 161
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "content", [], "any", false, false, false, 161), "html", null, true);
        yield "
                  </div>
                  <a href=\"/articles/";
        // line 163
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "slug", [], "any", false, false, false, 163), "html", null, true);
        yield "\" class=\"read-more\">Read More</a>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div class=\"col-12 text-center pb-4 pt-4 mx-0 animate-box\" data-animate-effect=\"fadeInUp\">
                <!-- <a href=\"#\" class=\"btn_mange_pagging\"><i class=\"fa fa-long-arrow-left\"></i>&nbsp;&nbsp; Previous</a>
                  <a href=\"#\" class=\"btn_pagging\">1</a>
                  <a href=\"#\" class=\"btn_pagging\">2</a>
                  <a href=\"#\" class=\"btn_pagging\">3</a>
                  <a href=\"#\" class=\"btn_pagging\">...</a>
                  <a href=\"#\" class=\"btn_mange_pagging\">Next <i class=\"fa fa-long-arrow-right\"></i>&nbsp;&nbsp; </a> -->
                ";
        // line 175
        if ((($context["currentPage"] ?? null) > 1)) {
            // line 176
            yield "                <a href=\"?page=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($context["currentPage"] ?? null) - 1), "html", null, true);
            yield "\" class=\"btn_mange_pagging\">
                  <i class=\"fa fa-long-arrow-left\"></i>&nbsp;&nbsp; Previous
                </a>
                ";
        }
        // line 180
        yield "
                ";
        // line 181
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(range(1, ($context["totalPages"] ?? null)));
        foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
            // line 182
            yield "                <a href=\"?page=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page"], "html", null, true);
            yield "\" class=\"";
            yield ((($context["page"] == ($context["currentPage"] ?? null))) ? ("active") : (""));
            yield "\" class=\"btn_pagging\">
                  ";
            // line 183
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["page"], "html", null, true);
            yield "
                </a>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['page'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 186
        yield "
                ";
        // line 187
        if ((($context["currentPage"] ?? null) < ($context["totalPages"] ?? null))) {
            yield " <a href=\"?page=";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($context["currentPage"] ?? null) + 1), "html", null, true);
            yield "\" class=\"btn_mange_pagging\">
                  Next <i class=\"fa fa-long-arrow-right\"></i>&nbsp;&nbsp;
                  </a>
                  ";
        }
        // line 191
        yield "              </div>
            </div>
          </div>
        </div>

        <div class=\"col-md-3 animate-box\" data-animate-effect=\"fadeInRight\">
          <div class=\"container\">

            <div class=\"row\">
              <div>
                <div class=\"fh5co_heading fh5co_heading_border_bottom py-2 mb-4\">";
        // line 201
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("most_popular"), "html", null, true);
        yield "</div>
              </div>
              <div class=\"row pb-3\">
                <div class=\"col-5 align-self-center\">
                  <img src=\"/assets/";
        // line 205
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "featured_image", [], "any", false, false, false, 205), "html", null, true);
        yield "\" alt=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "title", [], "any", false, false, false, 205), "html", null, true);
        yield "\" class=\"fh5co_most_trading\" />
                </div>
                <div class=\"col-7 paddding\">
                  <div class=\"most_fh5co_treding_font\"> 
                    <a href=\"/articles/";
        // line 209
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "slug", [], "any", false, false, false, 209), "html", null, true);
        yield "\"> 
                      ";
        // line 210
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "title", [], "any", false, false, false, 210), "html", null, true);
        yield "
                    </a>
                  </div>
                  <div class=\"most_fh5co_treding_font_123\"> ";
        // line 213
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "publisher", [], "any", false, false, false, 213), "html", null, true);
        yield " - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "publication_date", [], "any", false, false, false, 213), "F j, Y"), "html", null, true);
        yield "</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div>
                <div class=\"fh5co_heading fh5co_heading_border_bottom py-2 mb-4\">";
        // line 219
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("featured_posts"), "html", null, true);
        yield "</div>
              </div>
              <div class=\"row pb-3\">
                <div class=\"col-5 align-self-center\">
                  <img src=\"/assets/";
        // line 223
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "featured_image", [], "any", false, false, false, 223), "html", null, true);
        yield "\" alt=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "title", [], "any", false, false, false, 223), "html", null, true);
        yield "\" class=\"fh5co_most_trading\"  />
                </div>
                <div class=\"col-7 paddding\">
                  <div class=\"most_fh5co_treding_font\"> <a href=\"/articles/";
        // line 226
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "slug", [], "any", false, false, false, 226), "html", null, true);
        yield "\"> 
                    ";
        // line 227
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "title", [], "any", false, false, false, 227), "html", null, true);
        yield "
                  </a></div>
                  <div class=\"most_fh5co_treding_font_123\"> ";
        // line 229
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "publisher", [], "any", false, false, false, 229), "html", null, true);
        yield " - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["article"] ?? null), "publication_date", [], "any", false, false, false, 229), "F j, Y"), "html", null, true);
        yield "</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class=\"container-fluid fh5co_footer_right_reserved\">
    <div class=\"container\">
      <div class=\"row  \">
        <div class=\"col-12 col-md-6 py-4 Reserved\"> © Copyright 2018, All rights reserved. Design by <a
            href=\"https://freehtml5.co\" title=\"Free HTML5 Bootstrap templates\">FreeHTML5.co</a>. </div>
        <div class=\"col-12 col-md-6 spdp_right py-4\">
          <a href=\"#\" class=\"footer_last_part_menu\">Home</a>
          <a href=\"Contact_us.html\" class=\"footer_last_part_menu\">About</a>
          <a href=\"Contact_us.html\" class=\"footer_last_part_menu\">Contact</a>
          <a href=\"blog.html\" class=\"footer_last_part_menu\">Latest News</a>
        </div>
      </div>
    </div>
  </div>

  <div class=\"gototop js-top\">
    <a href=\"#\" class=\"js-gotop\"><i class=\"fa fa-arrow-up\"></i></a>
  </div>

  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>
  <script src=\"/assets/backend/js/owl.carousel.min.js\"></script>
  <script src=\"https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js\"
    integrity=\"sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb\"
    crossorigin=\"anonymous\"></script>
  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js\"
    integrity=\"sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn\"
    crossorigin=\"anonymous\"></script>
  <!-- Waypoints -->
  <script src=\"/assets/backend/js/jquery.waypoints.min.js\"></script>
  <!-- Main -->
  <script src=\"/assets/backend/js/main.js\"></script>

</body>

</html>";
        yield from [];
    }

    // line 8
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "meta_title", [], "any", true, true, false, 8)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "meta_title", [], "any", false, false, false, 8), "Jessica Jacobson")) : ("Jessica Jacobson")), "html", null, true);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/layout.twig";
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
        return array (  420 => 8,  368 => 229,  363 => 227,  359 => 226,  351 => 223,  344 => 219,  333 => 213,  327 => 210,  323 => 209,  314 => 205,  307 => 201,  295 => 191,  286 => 187,  283 => 186,  274 => 183,  267 => 182,  263 => 181,  260 => 180,  252 => 176,  250 => 175,  235 => 163,  230 => 161,  226 => 160,  221 => 159,  215 => 158,  204 => 150,  200 => 149,  189 => 141,  183 => 137,  52 => 8,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/layout.twig", "/shared/httpd/jessicajacobson/htdocs/templates/admin/layout.twig");
    }
}
