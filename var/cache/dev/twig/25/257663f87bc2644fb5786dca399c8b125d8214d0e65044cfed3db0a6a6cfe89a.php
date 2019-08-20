<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* partenaire/index.html.twig */
class __TwigTemplate_69d94611188503bb1843ff5c86fafe4477d5478fb93539edf4db9055800d6c19 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "partenaire/index.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "partenaire/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "partenaire/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "Contrat de Prestation";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 5
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        echo "<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background-color: rgb(236, 241, 237); padding: 2px 6px; }
</style>

<div class=\"example-wrapper\">
    <p>
                                <div style=\"text-align: center;text-decoration: underline;\">
                                      <h1>Contrat de Prestation:</h1>
                                </div>
    </p>
<p>
La société _________________, Société , dont le siège social est
________________ ____, enregistrée au Registre du Commerce et des Sociétés sous le numéro
____________, représentée par Mr(Mme). ________________________ ,

ci-après dénommée « le Prestataire de services » ou « le Prestataire »,

d'autre part,
il a été convenu ce qui suit :
</p> 
<p>
<span style=\"text-decoration: underline\">Preambule</span>:
</p>
<p>
[Rappeler ici, en quelques lignes, les raisons qui motivent l'accord intervenu. Ceci peut être utile ultérieurement pour
l'interprétation du contrat.]
Ceci exposé,Il a été convenu ce qui suit :
</p>
<p>
<span style=\"text-decoration: underline\">Article 1</span>: Objet
</p>
<p>
Le présent contrat est un contrat de prestation de service ayant pour objet la mission définie au cahier des charges
annexé au présent contrat et en faisant partie intégrante.
</p>
<p>
En contrepartie de la réalisation des prestations définies à l'Article premier ci-dessus, le client versera au
prestataire la somme forfaitaire de _______________ FCFA, ventilée de la manière suivante:
</p>
<p>
20% à la signature des présentes ;
</p>
<p>
30% au (n) jour suivant la signature des présentes ;
</p>
<p>
50% constituant le solde, à la réception de la tâche.
</p>
<p>
Les sommes prévues ci-dessus seront déposées au caissier, dans les huit jours de la réception de la facture, droits et
taxes en sus.
</p>
<p>
<span style=\"text-decoration: underline\">Article 2</span>: Nature des obligations
</p>
<p>
Pour l'accomplissement des diligences et prestations prévues à l'Article premier ci-dessus, le Prestataire s'engage à
donner ses meilleurs soins, conformément aux règles de l'art. La présente obligation, n'est, de convention expresse, que
pure obligation de moyens.
</p>
<p>
La responsabilité du Prestataire n'est pas engagée dans la mesure où le préjudice que subirait le Client n'est pas causé
par une faute intentionnelle ou lourde des employés du Prestataire.
</p>
<p>
<span style=\"text-decoration: underline\">Article 3</span>: Assurance qualité
</p>
<p>
Le prestataire de services s'engage à maintenir un programme d'assurance qualité pour les services désignés ci-après
conformément aux règles d'assurance qualité.
</p>
<p>
<span style=\"text-decoration: underline\">Article 4</span>: Obligation de confidentialité
</p>
<p>
Le prestataire considèrera comme strictement confidentiel, et s'interdit de divulguer, toute information, document,
donnée ou concept, dont il pourra avoir connaissance à l'occasion du présent contrat. Pour l'application de la présente
clause, le prestataire répond de ses salariés comme de lui-même. Le prestataire, toutefois, ne saurait être tenu pour
responsable d'aucune divulgation si les éléments divulgués étaient dans le domaine public à la date de la divulgation,
ou s'il en avait déjà connaissance antérieurement à la date de signature du présent contrat, ou s'il les obtenait de
tiers par des moyens légitimes.
</p>
<p>
<span style=\"text-decoration: underline\">Article 5</span>: Propriété des résultats
</p>
<p>
De convention expresse, les résultats de l'étude seront en la pleine maîtrise du Client, à compter du paiement intégral
de la prestation et le Client pourra en disposer comme il l'entend.
</p>
<p>
Le Prestataire, pour sa part, s'interdit de faire état des résultats dont il s'agit et de les utiliser de quelque
manière, sauf à obtenir préalablement l'autorisation écrite du client.
</p>
<p>
<span style=\"text-decoration: underline\">Article 6</span>: Résiliation - Sanction
</p>
<p>
Tout manquement de l'une ou l'autre des parties aux obligations qu'elle a en charge, aux termes des articles (...),
(...), ci-dessus, entraînera, si bon semble au créancier de l'obligation inexécutée, la résiliation de plein droit au
présent contrat, quinze jours après mise en demeure d'exécuter par lettre recommandée avec accusé de réception demeurée
sans effet, sans préjudice de tous dommages et intérêts.
</p>
<p> 
<span style=\"text-decoration: underline\">Article 7</span>: Clause de hardship
</p>
<p>
Les parties reconnaissent que le présent accord ne constitue pas une base équitable et raisonnable de leur coopération.
</p>
<p>
Dans le cas où les données sur lesquelles est basé cet accord sont modifiées dans des proportions telles que l'une ou
l'autre des parties rencontre des difficultés sérieuses et imprévisibles, elles se consulteront mutuellement et devront
faire preuve de compréhension mutuelle en vue de faire les ajustements qui apparaîtraient nécessaires à la suite de
circonstances qui n'étaient pas raisonnablement prévisibles à la date de conclusion du présent accord et ce, afin que
renaissent les conditions d'un accord équitable.
</p>
<p>
La partie qui considère que les conditions énoncées au paragraphe ci-dessus sont remplies en avisera l'autre partie par
lettre recommandée avec accusé de réception, en précisant la date et la nature du ou des événements à l'origine du
changement allégué par elle en chiffrant le montant du préjudice financier actuel ou à venir et en faisant une
proposition de dédommagement pour remédier à ce changement. Toute signification adressée plus de douze (12) jours après
la survenance de l'événement par la partie à l'origine de la signification n'aura aucun effet.
</p>
<p>
<span style=\"text-decoration: underline\">Article 8:</span> Force majeure
</p>
<p>
On entend par force majeure des événements de guerre déclarés ou non déclarés, de grève générale de travail, de maladies
épidémiques, de mise en quarantaine, d'incendie, de crues exceptionnelles, d'accidents ou d'autres événements
indépendants de la volonté des deux parties. Aucune des deux parties ne sera tenue responsable du retard constaté en
raison des événements de force majeure.
</p>
<p>
En cas de force majeure, constatée par l'une des parties, celle-ci doit en informer l'autre partie par écrit dans les
meilleurs délais par écrit, télex. L'autre partie disposera de dix jours pour la constater.
</p>
<p>
Les délais prévus pour la livraison seront automatiquement décalés en fonction de la durée de la force majeure.
</p>
<p>
<span style=\"text-decoration: underline\">Article 9</span>: Loi applicable. Texte original
</p>
<p>
Le contrat est régi par la loi du pays où le fabricant a son siège social. Le texte du
présent contrat fait foi comme texte original.
</p>
<p>
<span style=\"text-decoration: underline\">Article 10</span>: Compétence
</p>
<p>
Toutes contestations qui découlent du présent contrat ou qui s'y rapportent seront tranchées définitivement suivant le
règlement de Conciliation et d'Arbitrage de la Chambre de Commerce Internationale sans aucun recours aux tribunaux
ordinaires par un ou plusieurs arbitres nommés conformément à ce règlement et dont la sentence a un caractère
obligatoire. Le tribunal arbitral sera juge de sa propre compétence et de la validité de la convention d'arbitrage.
</p>
<p>
Fait le _________ à ____________________ en 6 (six) exemplaires.
</p>
<p>
<span style=\"text-decoration: underline\">Le Prestataire</span>:

___________________________</p>
<p> <span style=\"text-decoration: underline\">Le Client</span>: ___________________________
</p>
</div>   
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "partenaire/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Contrat de Prestation{% endblock %}

{% block body %}
<style>
    .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
    .example-wrapper code { background-color: rgb(236, 241, 237); padding: 2px 6px; }
</style>

<div class=\"example-wrapper\">
    <p>
                                <div style=\"text-align: center;text-decoration: underline;\">
                                      <h1>Contrat de Prestation:</h1>
                                </div>
    </p>
<p>
La société _________________, Société , dont le siège social est
________________ ____, enregistrée au Registre du Commerce et des Sociétés sous le numéro
____________, représentée par Mr(Mme). ________________________ ,

ci-après dénommée « le Prestataire de services » ou « le Prestataire »,

d'autre part,
il a été convenu ce qui suit :
</p> 
<p>
<span style=\"text-decoration: underline\">Preambule</span>:
</p>
<p>
[Rappeler ici, en quelques lignes, les raisons qui motivent l'accord intervenu. Ceci peut être utile ultérieurement pour
l'interprétation du contrat.]
Ceci exposé,Il a été convenu ce qui suit :
</p>
<p>
<span style=\"text-decoration: underline\">Article 1</span>: Objet
</p>
<p>
Le présent contrat est un contrat de prestation de service ayant pour objet la mission définie au cahier des charges
annexé au présent contrat et en faisant partie intégrante.
</p>
<p>
En contrepartie de la réalisation des prestations définies à l'Article premier ci-dessus, le client versera au
prestataire la somme forfaitaire de _______________ FCFA, ventilée de la manière suivante:
</p>
<p>
20% à la signature des présentes ;
</p>
<p>
30% au (n) jour suivant la signature des présentes ;
</p>
<p>
50% constituant le solde, à la réception de la tâche.
</p>
<p>
Les sommes prévues ci-dessus seront déposées au caissier, dans les huit jours de la réception de la facture, droits et
taxes en sus.
</p>
<p>
<span style=\"text-decoration: underline\">Article 2</span>: Nature des obligations
</p>
<p>
Pour l'accomplissement des diligences et prestations prévues à l'Article premier ci-dessus, le Prestataire s'engage à
donner ses meilleurs soins, conformément aux règles de l'art. La présente obligation, n'est, de convention expresse, que
pure obligation de moyens.
</p>
<p>
La responsabilité du Prestataire n'est pas engagée dans la mesure où le préjudice que subirait le Client n'est pas causé
par une faute intentionnelle ou lourde des employés du Prestataire.
</p>
<p>
<span style=\"text-decoration: underline\">Article 3</span>: Assurance qualité
</p>
<p>
Le prestataire de services s'engage à maintenir un programme d'assurance qualité pour les services désignés ci-après
conformément aux règles d'assurance qualité.
</p>
<p>
<span style=\"text-decoration: underline\">Article 4</span>: Obligation de confidentialité
</p>
<p>
Le prestataire considèrera comme strictement confidentiel, et s'interdit de divulguer, toute information, document,
donnée ou concept, dont il pourra avoir connaissance à l'occasion du présent contrat. Pour l'application de la présente
clause, le prestataire répond de ses salariés comme de lui-même. Le prestataire, toutefois, ne saurait être tenu pour
responsable d'aucune divulgation si les éléments divulgués étaient dans le domaine public à la date de la divulgation,
ou s'il en avait déjà connaissance antérieurement à la date de signature du présent contrat, ou s'il les obtenait de
tiers par des moyens légitimes.
</p>
<p>
<span style=\"text-decoration: underline\">Article 5</span>: Propriété des résultats
</p>
<p>
De convention expresse, les résultats de l'étude seront en la pleine maîtrise du Client, à compter du paiement intégral
de la prestation et le Client pourra en disposer comme il l'entend.
</p>
<p>
Le Prestataire, pour sa part, s'interdit de faire état des résultats dont il s'agit et de les utiliser de quelque
manière, sauf à obtenir préalablement l'autorisation écrite du client.
</p>
<p>
<span style=\"text-decoration: underline\">Article 6</span>: Résiliation - Sanction
</p>
<p>
Tout manquement de l'une ou l'autre des parties aux obligations qu'elle a en charge, aux termes des articles (...),
(...), ci-dessus, entraînera, si bon semble au créancier de l'obligation inexécutée, la résiliation de plein droit au
présent contrat, quinze jours après mise en demeure d'exécuter par lettre recommandée avec accusé de réception demeurée
sans effet, sans préjudice de tous dommages et intérêts.
</p>
<p> 
<span style=\"text-decoration: underline\">Article 7</span>: Clause de hardship
</p>
<p>
Les parties reconnaissent que le présent accord ne constitue pas une base équitable et raisonnable de leur coopération.
</p>
<p>
Dans le cas où les données sur lesquelles est basé cet accord sont modifiées dans des proportions telles que l'une ou
l'autre des parties rencontre des difficultés sérieuses et imprévisibles, elles se consulteront mutuellement et devront
faire preuve de compréhension mutuelle en vue de faire les ajustements qui apparaîtraient nécessaires à la suite de
circonstances qui n'étaient pas raisonnablement prévisibles à la date de conclusion du présent accord et ce, afin que
renaissent les conditions d'un accord équitable.
</p>
<p>
La partie qui considère que les conditions énoncées au paragraphe ci-dessus sont remplies en avisera l'autre partie par
lettre recommandée avec accusé de réception, en précisant la date et la nature du ou des événements à l'origine du
changement allégué par elle en chiffrant le montant du préjudice financier actuel ou à venir et en faisant une
proposition de dédommagement pour remédier à ce changement. Toute signification adressée plus de douze (12) jours après
la survenance de l'événement par la partie à l'origine de la signification n'aura aucun effet.
</p>
<p>
<span style=\"text-decoration: underline\">Article 8:</span> Force majeure
</p>
<p>
On entend par force majeure des événements de guerre déclarés ou non déclarés, de grève générale de travail, de maladies
épidémiques, de mise en quarantaine, d'incendie, de crues exceptionnelles, d'accidents ou d'autres événements
indépendants de la volonté des deux parties. Aucune des deux parties ne sera tenue responsable du retard constaté en
raison des événements de force majeure.
</p>
<p>
En cas de force majeure, constatée par l'une des parties, celle-ci doit en informer l'autre partie par écrit dans les
meilleurs délais par écrit, télex. L'autre partie disposera de dix jours pour la constater.
</p>
<p>
Les délais prévus pour la livraison seront automatiquement décalés en fonction de la durée de la force majeure.
</p>
<p>
<span style=\"text-decoration: underline\">Article 9</span>: Loi applicable. Texte original
</p>
<p>
Le contrat est régi par la loi du pays où le fabricant a son siège social. Le texte du
présent contrat fait foi comme texte original.
</p>
<p>
<span style=\"text-decoration: underline\">Article 10</span>: Compétence
</p>
<p>
Toutes contestations qui découlent du présent contrat ou qui s'y rapportent seront tranchées définitivement suivant le
règlement de Conciliation et d'Arbitrage de la Chambre de Commerce Internationale sans aucun recours aux tribunaux
ordinaires par un ou plusieurs arbitres nommés conformément à ce règlement et dont la sentence a un caractère
obligatoire. Le tribunal arbitral sera juge de sa propre compétence et de la validité de la convention d'arbitrage.
</p>
<p>
Fait le _________ à ____________________ en 6 (six) exemplaires.
</p>
<p>
<span style=\"text-decoration: underline\">Le Prestataire</span>:

___________________________</p>
<p> <span style=\"text-decoration: underline\">Le Client</span>: ___________________________
</p>
</div>   
{% endblock %}
", "partenaire/index.html.twig", "/home/juniorlaye/APIprojet/templates/partenaire/index.html.twig");
    }
}
