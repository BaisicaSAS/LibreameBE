<?php

/* LibreameBackendBundle:Registro:registro.html.twig */
class __TwigTemplate_5630dec6159ea616cb60a437a368d7a039de8c2b6e5d1943df0b4628d4e4f6cd extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Confirmación de registro en ex4read</title>
</head>
<body>

<div style=\"width:100%;\" align=\"center\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td align=\"center\" valign=\"top\" style=\"background-color:#53636e;\" bgcolor=\"#53636e;\">
    
    <br>
    <br>
    <table width=\"583\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
      <tr>
        <td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\" style=\"background-color:#FFFFFF;\"><img src=\"data:image/jpeg;base64, &lt; ?php echo base64_encode(file_get_contents('";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("images/header.jpg"), "html", null, true);
        echo "))? &gt;\" width=\"583\" height=\"118\"></td>
      </tr>
      <tr>
        <td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\" style=\"background-color:#FFFFFF;\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr>
            <td width=\"35\" align=\"left\" valign=\"top\">&nbsp;</td>
            <td align=\"left\" valign=\"top\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td align=\"center\" valign=\"top\">
                \t<div>
\t\t\t\t\t\t<img src=\"data:image/jpeg;base64, <?php echo base64_encode(file_get_contents('";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("images/400dpiLogo.png"), "html", null, true);
        echo " ')) ?>\"  alt=\"ex4read\" width='135' height='134'/>
\t\t\t\t\t</div>
                \t<div style=\"color:#EF3340; font-family:Times New Roman, Times, serif; font-size:48px;\">
\t\t\t\t\t\tConfirmación de registro en ex4read
\t\t\t\t\t</div>
                  <div style=\"font-family: Verdana, Geneva, sans-serif; color:#898989; font-size:12px;\"></div></td>
              </tr>
              <tr>
                <td align=\"left\" valign=\"top\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#525252;\">
                
                <div style=\"color:#00B08B; font-size:19px;\">Hola ";
        // line 37
        echo twig_escape_filter($this->env, (isset($context["usuario"]) ? $context["usuario"] : null), "html", null, true);
        echo "</div>
                <div style=\"color:#00B08B; font-size:17px;\">
\t\t\t\t\t<br>Estamos casi listos para inciar en ex4read, solo confirma tu registro en la plataforma y comienza a disfrutar de nuestros servicios.<br>
\t\t\t\t\t<br><li><a href=\"";
        // line 40
        echo twig_escape_filter($this->env, (isset($context["crurl"]) ? $context["crurl"] : null), "html", null, true);
        echo "\">Confirmar mi registro.</a></li><br>
\t\t\t\t</div>
<br>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td width=\"13%\"><b><img src=\"data:image/jpeg;base64,<?php echo base64_encode(file_get_contents(''";
        // line 45
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("images/tweet.gif"), "html", null, true);
        echo "''))?>\" alt=\"\" width=\"24\" height=\"23\"> <img src=\"data:image/jpeg;base64,<?php echo base64_encode(file_get_contents(''";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("images/facebook.gif"), "html", null, true);
        echo "''))?>\" alt=\"\" width=\"24\" height=\"23\"></b></td>
    <td width=\"87%\" style=\"font-size:11px; color:#525252; font-family:Arial, Helvetica, sans-serif;\"><b>Servicio al cliente: <a href='servicio@ex4read.co'>servicio@ex4read.co</a></b></td>
  </tr>
</table></td>
              </tr>
              <tr>
                <td align=\"left\" valign=\"top\" style=\"font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#525252;\">&nbsp;</td>
              </tr>
            </table></td>
            <td width=\"35\" align=\"left\" valign=\"top\">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align=\"left\" valign=\"top\" bgcolor=\"#3d90bd\" style=\"background-color:#3d90bd;\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr>
            <td width=\"35\">&nbsp;</td>
            <td height=\"50\" valign=\"middle\" style=\"color:#FFFFFF; font-size:11px; font-family:Arial, Helvetica, sans-serif;\"><b> </b><br> </td>
            <td width=\"35\">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
  </table>
    <br>
    <br></td>
  </tr>
</table>

</div>

</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "LibreameBackendBundle:Registro:registro.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 45,  69 => 40,  63 => 37,  50 => 27,  37 => 17,  19 => 1,);
    }
}
