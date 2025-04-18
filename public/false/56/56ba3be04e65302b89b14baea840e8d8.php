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

/* frontend/layout.twig */
class __TwigTemplate_910450f4706935d004e178dd851e79ac extends Template
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
            'head' => [$this, 'block_head'],
            'header' => [$this, 'block_header'],
            'navbar' => [$this, 'block_navbar'],
            'banner_content' => [$this, 'block_banner_content'],
            'article_banner_date' => [$this, 'block_article_banner_date'],
            'banner_title' => [$this, 'block_banner_title'],
            'content' => [$this, 'block_content'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"";
        // line 2
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("pageLanguage", $context)) ? (Twig\Extension\CoreExtension::default(($context["pageLanguage"] ?? null), "fr")) : ("fr")), "html", null, true);
        yield "\" class=\"no-js\">
<head>
  <!-- Google tag (gtag.js) -->
  <script async src=\"https://www.googletagmanager.com/gtag/js?id=G-Y06QXLWQBY\"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-Y06QXLWQBY');
  </script>
  <!-- META TAGS -->
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
  <title>";
        // line 17
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
  <meta name=\"description\" content=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "meta_description", [], "any", true, true, false, 18)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "meta_description", [], "any", false, false, false, 18), "Author website CMS")) : ("Author website CMS")), "html", null, true);
        yield "\">
  <link rel=\"canonical\" href=\"";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "canonical_url", [], "any", true, true, false, 19)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "canonical_url", [], "any", false, false, false, 19), "https://www.jessicajacobson.com")) : ("https://www.jessicajacobson.com")), "html", null, true);
        yield "\">
  <!-- Open Graph Tags -->
  <meta property=\"og:title\" content=\"";
        // line 21
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "meta_title", [], "any", true, true, false, 21)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "meta_title", [], "any", false, false, false, 21), "Jessica Jacobson")) : ("Jessica Jacobson")), "html", null, true);
        yield "\">
  <meta property=\"og:description\" content=\"";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "meta_description", [], "any", true, true, false, 22)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "meta_description", [], "any", false, false, false, 22), "Author website CMS")) : ("Author website CMS")), "html", null, true);
        yield "\">
  <meta property=\"og:url\" content=\"";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "canonical_url", [], "any", true, true, false, 23)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "canonical_url", [], "any", false, false, false, 23), "https://www.jessicajacobson.com")) : ("https://www.jessicajacobson.com")), "html", null, true);
        yield "\">
  <meta name=\"reply-to\" content=\"support@jessicajacobson.com\">
  <!-- Stylesheets -->
  <link href=\"/assets/frontend/css/media_query.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"/assets/frontend/css/bootstrap.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"/assets/frontend/css/font-awesome/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"/assets/frontend/css/animate.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"https://fonts.googleapis.com/css?family=Poppins\" rel=\"stylesheet\">
  <link href=\"/assets/frontend/css/owl.carousel.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"/assets/frontend/css/owl.theme.default.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"/assets/frontend/css/style_1.css\" rel=\"stylesheet\" type=\"text/css\" />
  <script src=\"/assets/frontend/js/modernizr-3.5.0.min.js\"></script>
  ";
        // line 35
        yield from $this->unwrap()->yieldBlock('head', $context, $blocks);
        // line 36
        yield "
  <style>
  .fh5co_news_img > img {
    height: 260px;
    width: auto!important;
  }

  div.fh5co_news_img {
    height: auto!important;
  }
  </style>
</head>
<body>
  ";
        // line 49
        yield from $this->unwrap()->yieldBlock('header', $context, $blocks);
        // line 112
        yield "
  ";
        // line 113
        yield from $this->unwrap()->yieldBlock('navbar', $context, $blocks);
        // line 161
        yield "
  ";
        // line 162
        yield from $this->unwrap()->yieldBlock('banner_content', $context, $blocks);
        // line 198
        yield "
  ";
        // line 199
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 202
        yield "
  ";
        // line 203
        yield from $this->unwrap()->yieldBlock('footer', $context, $blocks);
        // line 219
        yield "
  <div class=\"gototop js-top\">
    <a href=\"#\" class=\"js-gotop\"><i class=\"fa fa-arrow-up\"></i></a>
  </div>

  <script src=\"/assets/frontend/js/jquery.min.js\"></script>
  <script src=\"/assets/frontend/js/owl.carousel.min.js\"></script>
  <script src=\"/assets/frontend/js/tether.min.js\"></script>
  <script src=\"/assets/frontend/js/bootstrap.min.js\"></script>
  <script src=\"/assets/frontend/js/jquery.waypoints.min.js\"></script>
  <script src=\"/assets/frontend/js/main.js\"></script>
</body>
</html>
";
        yield from [];
    }

    // line 17
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "meta_title", [], "any", true, true, false, 17)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "meta_title", [], "any", false, false, false, 17), "Jessica Jacobson")) : ("Jessica Jacobson")), "html", null, true);
        yield from [];
    }

    // line 35
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_head(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    // line 49
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_header(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 50
        yield "  <div class=\"container-fluid\">
    <div class=\"container\">
      <div class=\"row align-items-center\">
        <div class=\"col-12 col-md-2 fh5co_padding_menu\">
          <img src=\"/assets/frontend/default_images/logo.png\" alt=\"Jessica Jacobson Logo\" class=\"fh5co_logo_width\" />
        </div>
        <div class=\"col-12 col-md-10 text-right d-flex align-items-center justify-content-end\">

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

          ";
        // line 80
        if ( !($context["logged_in_user"] ?? null)) {
            // line 81
            yield "            <div class=\"d-inline-block text-center\">
              <!-- Login Form -->
              <form method=\"post\" action=\"";
            // line 83
            yield "/login";
            yield "\" class=\"login-form d-flex align-items-center\" enctype=\"multipart/form-data\">
                <input type=\"hidden\" name=\"";
            // line 84
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["csrf"] ?? null), "token_name_key", [], "any", false, false, false, 84), "html", null, true);
            yield "\" value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["csrf"] ?? null), "token_name", [], "any", false, false, false, 84), "html", null, true);
            yield "\">
                <input type=\"hidden\" name=\"";
            // line 85
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["csrf"] ?? null), "token_value_key", [], "any", false, false, false, 85), "html", null, true);
            yield "\" value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["csrf"] ?? null), "token_value", [], "any", false, false, false, 85), "html", null, true);
            yield "\">
                
                <input type=\"text\" class=\"form-control login-input\" name=\"username\" id=\"username\" placeholder=\"";
            // line 87
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("username"), "html", null, true);
            yield "\" required>
                <input type=\"password\" class=\"form-control login-input\" name=\"password\" id=\"password\" placeholder=\"";
            // line 88
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("password"), "html", null, true);
            yield "\" required>
                <button type=\"submit\" class=\"btn btn-login\">";
            // line 89
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("login"), "html", null, true);
            yield "</button>
              </form>
            </div>
            <!-- Register Button -->
            <a href=\"/register\" class=\"btn btn-register ml-2\">";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("register"), "html", null, true);
            yield "</a>
          ";
        } else {
            // line 95
            yield "            <a href=\"/logout\" class=\"btn btn-register ml-2\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("logout"), "html", null, true);
            yield "</a>
          ";
        }
        // line 97
        yield "         
          <div class=\"d-inline-block text-center language-selector\">
            <form action=\"/change-language\" method=\"get\">
                <select class=\"form-control fh5co_text_select_option\" name=\"lang\" onchange=\"this.form.submit()\">
                    ";
        // line 101
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["languages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["lang"]) {
            // line 102
            yield "                        <option value=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["lang"], "code", [], "any", false, false, false, 102), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["lang"], "code", [], "any", false, false, false, 102) == ($context["pageLanguage"] ?? null))) {
                yield "selected";
            }
            yield ">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["lang"], "code", [], "any", false, false, false, 102), "html", null, true);
            yield "</option>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['lang'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 104
        yield "                </select>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  ";
        yield from [];
    }

    // line 113
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_navbar(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 114
        yield "  <div class=\"container-fluid bg-faded fh5co_padd_mediya padding_786\">
    <div class=\"container padding_786\">
      <nav class=\"navbar navbar-toggleable-md navbar-light\">
        <button class=\"navbar-toggler navbar-toggler-right mt-3\" type=\"button\" data-toggle=\"collapse\"
          data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\"
          aria-label=\"Toggle navigation\"><span class=\"fa fa-bars\"></span></button>
        <a class=\"navbar-brand\" href=\"#\"><img src=\"/assets/frontend/default_images/logo.png\" alt=\"img\" class=\"mobile_logo_width\" /></a>
        <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
          <ul class=\"navbar-nav mr-auto\">
            <li class=\"nav-item active\">
              <a class=\"nav-link\" href=\"/\">";
        // line 124
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("home"), "html", null, true);
        yield " <span class=\"sr-only\">(current)</span></a>
            </li>
            <li class=\"nav-item dropdown\">
              <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"dropdownMenuButton2\" data-toggle=\"dropdown\"
                aria-haspopup=\"true\" aria-expanded=\"false\">";
        // line 128
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("jessica_jacobson"), "html", null, true);
        yield "</a>
              <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuLink_1\">
                <a class=\"dropdown-item\" href=\"#\">";
        // line 130
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("who_am_i"), "html", null, true);
        yield "</a>
                <a class=\"dropdown-item\" href=\"#\">";
        // line 131
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("my_journey"), "html", null, true);
        yield "</a>
                <a class=\"dropdown-item\" href=\"#\">";
        // line 132
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("my_hobbies"), "html", null, true);
        yield "</a>
                <a class=\"dropdown-item\" href=\"#\">";
        // line 133
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("my_favorite_books"), "html", null, true);
        yield "</a>
                <a class=\"dropdown-item\" href=\"#\">";
        // line 134
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("contact_me"), "html", null, true);
        yield "</a>
              </div>
            </li>
            <li class=\"nav-item dropdown\">
              <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"dropdownMenuButton2\" data-toggle=\"dropdown\"
                aria-haspopup=\"true\" aria-expanded=\"false\">";
        // line 139
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("heart_at_altitude"), "html", null, true);
        yield "</a>
              <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuLink_1\">
                ";
        // line 141
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["dynamicPages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
            // line 142
            yield "                    <a class=\"dropdown-item\" href=\"#\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["page"], "title", [], "any", false, false, false, 142), "html", null, true);
            yield "</a>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['page'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 144
        yield "              </div>
            </li>
            <li class=\"nav-item\">
              <a class=\"nav-link\" href=\"Contact_us.html\">";
        // line 147
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("publications"), "html", null, true);
        yield "</a>
            </li>
            <li class=\"nav-item\">
              <a class=\"nav-link\" href=\"Contact_us.html\">";
        // line 150
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("writing_workshop"), "html", null, true);
        yield "</a>
            </li>
            <li class=\"nav-item\">
              <a class=\"nav-link\" href=\"Contact_us.html\">";
        // line 153
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("media"), "html", null, true);
        yield "</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  ";
        yield from [];
    }

    // line 162
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_banner_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 163
        yield "  <div class=\"container-fluid paddding mb-5\">
    <div class=\"row mx-0\">
      <div class=\"col-12 paddding animate-box\" data-animate-effect=\"fadeIn\">
        <div class=\"fh5co_suceefh5co_height\"><img src=\"/assets/frontend/default_images/banner.jpg\" alt=\"img\" />
          <div class=\"fh5co_suceefh5co_height_position_absolute\"></div>
          <div class=\"fh5co_suceefh5co_height_position_absolute_font\">
            ";
        // line 169
        yield from $this->unwrap()->yieldBlock('article_banner_date', $context, $blocks);
        // line 172
        yield "            <div class=\"\">
              <a href=\"#\" class=\"fh5co_good_font\"> 
                ";
        // line 174
        yield from $this->unwrap()->yieldBlock('banner_title', $context, $blocks);
        // line 177
        yield "              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

            
    ";
        // line 186
        if (($context["errors"] ?? null)) {
            // line 187
            yield "      <div class=\"alert alert-danger mt-4\">
        <ul class=\"mb-0\">
          ";
            // line 189
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["errors"] ?? null));
            foreach ($context['_seq'] as $context["field"] => $context["messages"]) {
                // line 190
                yield "            ";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable($context["messages"]);
                foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                    // line 191
                    yield "              <li><strong>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::capitalize($this->env->getCharset(), $context["field"]), "html", null, true);
                    yield ":</strong> ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
                    yield "</li>
            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 193
                yield "          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['field'], $context['messages'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 194
            yield "        </ul>
      </div>
    ";
        }
        // line 197
        yield "  ";
        yield from [];
    }

    // line 169
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_article_banner_date(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 170
        yield "            
            ";
        yield from [];
    }

    // line 174
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_banner_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 175
        yield "                  Jessica Jacobson: passionnée de psychologie sociale et d'écriture
                ";
        yield from [];
    }

    // line 199
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 200
        yield "
  ";
        yield from [];
    }

    // line 203
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_footer(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 204
        yield "  <div class=\"container-fluid fh5co_footer_right_reserved\">
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-12 col-md-12 py-4 Reserved\">© Copyright 2024 Jessica Jacobson. Terms and Conditions. Design by <a
            href=\"https://freehtml5.co\" title=\"Free HTML5 Bootstrap templates\">FreeHTML5.co</a>.</div>
        ";
        // line 215
        yield "      </div>
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
        return "frontend/layout.twig";
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
        return array (  543 => 215,  536 => 204,  529 => 203,  523 => 200,  516 => 199,  510 => 175,  503 => 174,  497 => 170,  490 => 169,  485 => 197,  480 => 194,  474 => 193,  463 => 191,  458 => 190,  454 => 189,  450 => 187,  448 => 186,  437 => 177,  435 => 174,  431 => 172,  429 => 169,  421 => 163,  414 => 162,  401 => 153,  395 => 150,  389 => 147,  384 => 144,  375 => 142,  371 => 141,  366 => 139,  358 => 134,  354 => 133,  350 => 132,  346 => 131,  342 => 130,  337 => 128,  330 => 124,  318 => 114,  311 => 113,  299 => 104,  284 => 102,  280 => 101,  274 => 97,  268 => 95,  263 => 93,  256 => 89,  252 => 88,  248 => 87,  241 => 85,  235 => 84,  231 => 83,  227 => 81,  225 => 80,  193 => 50,  186 => 49,  176 => 35,  165 => 17,  147 => 219,  145 => 203,  142 => 202,  140 => 199,  137 => 198,  135 => 162,  132 => 161,  130 => 113,  127 => 112,  125 => 49,  110 => 36,  108 => 35,  93 => 23,  89 => 22,  85 => 21,  80 => 19,  76 => 18,  72 => 17,  54 => 2,  51 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "frontend/layout.twig", "/shared/httpd/jessicajacobson/htdocs/templates/frontend/layout.twig");
    }
}
