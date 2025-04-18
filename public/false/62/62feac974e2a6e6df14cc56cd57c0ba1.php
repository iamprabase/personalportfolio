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

/* auth/register.twig */
class __TwigTemplate_3f32d99d6d6e7bb2d00bbdd1eada5edd extends Template
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
            'banner_title' => [$this, 'block_banner_title'],
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
        $this->parent = $this->loadTemplate("frontend/layout.twig", "auth/register.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("register"), "html", null, true);
        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_banner_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("register"), "html", null, true);
        yield " ";
        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 8
        yield "<div class=\"container-fluid mb-4\">
    <div class=\"container\">
        <div class=\"col-12 text-center contact_margin_svnit \">
            <div class=\"text-center fh5co_heading py-2\">";
        // line 11
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("register"), "html", null, true);
        yield "</div>
        </div>
        <div class=\"row\">        
            <div class=\"col-12 text-center\">
                <form id=\"fh5co_contact_form\" class=\"row\" action=\"/register\" method=\"post\"  enctype=\"multipart/form-data\">
                    

                    <input type=\"hidden\" name=\"";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["csrf"] ?? null), "token_name_key", [], "any", false, false, false, 18), "html", null, true);
        yield "\" value=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["csrf"] ?? null), "token_name", [], "any", false, false, false, 18), "html", null, true);
        yield "\">
                    <input type=\"hidden\" name=\"";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["csrf"] ?? null), "token_value_key", [], "any", false, false, false, 19), "html", null, true);
        yield "\" value=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["csrf"] ?? null), "token_value", [], "any", false, false, false, 19), "html", null, true);
        yield "\">
                    
                    <div class=\"col-12 py-3\">
                        <input name=\"full_name\" id=\"full_name\" required type=\"text\" class=\"form-control fh5co_contact_text_box\" placeholder=\"";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("full_name"), "html", null, true);
        yield "\">
                    </div>
                    <div class=\"col-6 py-3\">
                        <input name=\"username\" id=\"username\" required type=\"text\" class=\"form-control fh5co_contact_text_box\" placeholder=\"";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("username"), "html", null, true);
        yield "\">
                    </div>
                    <div class=\"col-6 py-3\">
                        <input type=\"email\" name=\"email\" id=\"email\" required class=\"form-control fh5co_contact_text_box\" placeholder=\"";
        // line 28
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("email"), "html", null, true);
        yield "\">
                    </div>
                    <div class=\"col-6 py-3\">
                        <input name=\"city\" id=\"city\" type=\"text\" class=\"form-control fh5co_contact_text_box\" placeholder=\"";
        // line 31
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("city"), "html", null, true);
        yield "\">
                    </div>
                    <div class=\"col-6 py-3\">
                        <input name=\"country\" id=\"country\" type=\"text\" class=\"form-control fh5co_contact_text_box\" placeholder=\"";
        // line 34
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("country"), "html", null, true);
        yield "\">
                    </div>
                    <div class=\"col-6 py-3\">
                        <input  type=\"password\" name=\"password\" id=\"password\" required class=\"form-control fh5co_contact_text_box\" placeholder=\"";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("password"), "html", null, true);
        yield "\">
                    </div>
                    <div class=\"col-6 py-3\">
                        <input type=\"password\" name=\"password_confirm\" id=\"password_confirm\" required class=\"form-control fh5co_contact_text_box\" placeholder=\"";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("password_confirm"), "html", null, true);
        yield "\">
                    </div>
                    <div class=\"col-6 py-3\">
                      <label for=\"profile_picture\" class=\"form-label d-block text-left font-weight-bold\">";
        // line 43
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("profile_picture"), "html", null, true);
        yield "</label>
                      <input type=\"file\" class=\"form-control fh5co_contact_text_box\" name=\"profile_picture\" id=\"profile_picture\" accept=\"image/*\">
                    </div>
                    <div class=\"col-12 py-3 text-center\">
                    
                     <button type=\"submit\" class=\"btn contact_btn\">";
        // line 48
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->env->getFunction('trans')->getCallable()("register"), "html", null, true);
        yield "</button> 
                    </div>
                    
                    
                </form>
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
        return "auth/register.twig";
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
        return array (  163 => 48,  155 => 43,  149 => 40,  143 => 37,  137 => 34,  131 => 31,  125 => 28,  119 => 25,  113 => 22,  105 => 19,  99 => 18,  89 => 11,  84 => 8,  77 => 7,  64 => 5,  53 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "auth/register.twig", "/shared/httpd/jessicajacobson/htdocs/templates/auth/register.twig");
    }
}
