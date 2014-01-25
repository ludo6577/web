<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="WebForm1.aspx.cs" Inherits="Acceuil.WebForm1" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
        <title>Ludovic Feltz</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="CV de Ludovic Feltz, Experiences, Compétences, Loisirs, Contact" />
    <meta name="author" content="Ludovic Feltz" />
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png" />

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <style id="holderjs-style" type="text/css"></style>
    <script type="text/javascript" src="js/tracking.js"></script>
</head>
<body>
    <div>   
        <div class="col-md-6">
            <div class="contact-form margin-bottom">
                <form id="contact" action="" method="post" runat="server">
                    <p>
                        Vous pouvez me localiser directement grâce à Google Map.<br />
                        En activant la localisation vous acceder à l'itinéraire depuis votre emplacement.
                    </p>
                    <p>
                        Vous pouvez aussi me contacter en remplissant le formulaire ci-dessous:
                    </p>
                    <div id="alertContact" class="alert alert-success" runat="server">lol</div>
                    <asp:TextBox type="text" id="name" name="name" value="" placeholder="your name*" required="required" data-val="true" data-placement="bottom" runat="server"/>
                    <asp:TextBox type="email" id="email" name="email" value="" placeholder="email address*" required="required" data-rule-email="true" data-val="true" data-placement="bottom" runat="server"/>
                    <asp:TextBox type="text" id="subject" name="subject" value="" placeholder="please provide the subject" runat="server"/>
                    <asp:TextBox type="text" id="textarea" name="message" placeholder="your message here*" required="required" data-val="true" data-placement="bottom" runat="server" />
                    <asp:Button type="submit" id="submit" name="button" value="Submit" class="btn btn-primary btn-lg"  runat="server" Text="Submit"  OnClick="submit_Click" />
                    <asp:TextBox type="hidden" name="msg-submitted" id="msgSubmitted" value="true" runat="server"/>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- MAP CANVAS -->
                    <div id="map-canvas"></div>

                    <button id="details-button" class="btn btn-primary btn-xs btn-block" data-toggle="modal" data-target="#myModal">
                        Voir les détails</button>
                    <!-- DIRECTION MODAL -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Itinéraire</h4>
                                </div>
                                <div class="modal-body">
                                    <!-- DIRECTION PANEL -->
                                    <div id="directionsPanel"></div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </div>
            </div>
        </div>
    </div>


    <!--------------------------------------------
              JAVASCRIPT CORE (end of html)
              ResolveURL probleme?:     <script type="text/javascript"  src='<%# ResolveUrl ("~/Js/jquery-1.2.3.min.js") %>'></script> 
    ----------------------------------------------->
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/holder.js"></script>
    <script type="text/javascript" src="js/googleMap.js"></script>
    <script type="text/javascript" src="js/smoothScroll.js"></script>
</body>
</html>
