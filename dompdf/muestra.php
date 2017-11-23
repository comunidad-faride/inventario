<?php
require_once("dompdf_config.inc.php");
 $precio="<u>00.00</u>"; 
 $html =
   '<html> 
   <head> 
   8859-15"> 
   <style> 
   body { font-family: arial;} 
   table {
    width: 100%;
    color:black;
    font-size:6px;
    font-family:arial
    margin-top: 2em;
    text-align: center;
   }
    
   thead {
     background-color: #eeeeee;
     
   }
    
   tbody {
     background-color: #ffffff;     
   }
    
   th,td {
     padding: 3pt;
   }           
   table.collapse {
      border-collapse: collapse;
     border-top: 1px solid black;
     border-bottom: 1px solid black;
   }
   .celda_right{
    border-right: 1px solid black;
   }
   .celda_left{
    border-left: 1px solid black;
   }         
   table.collapse th {
     border-top: 1px solid black;
    border-bottom: 1px solid black;
   }   
   </style> 
    
   </head> <pre class="brush: Sql">
    
   <body>        
   <table class="collapse"> 
   <thead> 
     <tr> 
    <th>Para Comprar una Vivienda</th>ad> 
    <th>Para construir tu Vivienda</th>ad> 
    <th>Para Ampliar, Remodelar o Mejorar</th> 
    <th>head Para Pagar la Hipoteca de tu Vivienda</th> 
     </tr> 
   </thead> 
     <tbody> 
     <tr> 
    <td class=celda_right>$ '.$precio.'<br>(Sin centavos)<br>*PRECIO DE-COMPRA VENTA</td> 
    <td class=celda_right>$ '.$precio.'<br>(Sin centavos)<br>CONSTURCIÓN</td> 
    <td class=celda_right>$ '.$precio.'<br>(Sin centavos)<br>AMPLIACIÓN REMODELACIÓN O MEJORA</td> 
    <td>$ '.$precio.'<br>(Sin centavos)<br>AMPLIACIÓN REMODELACIÓN O MEJORA</td> 
     </tr>           
     </tbody> 
     <tr> 
      <td>(Precio total pactado libremente)</td>
    <td colspan="3" class=celda_left>(Valor estimado del proyecto a sutermino estimado asu terminación)</td> 
     </tr> 
   </table>         
   </body> </html> ';
   $dompdf = new DOMPDF();
   //$dompdf->set_paper('letter','landscape');
   //$dompdf->set_paper('legal','landscape');
   $dompdf->load_html($html);
   $dompdf->render();
   $dompdf->stream("pdf".Date('Y-m-d').".pdf");
?>