<?php  
  

  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Name</th>  
                         <th>Address</th>  
                         <th>City</th>  
       <th>Postal Code</th>
       <th>Country</th>
                    </tr>
  ';
  $size=count($result);
 
   $output .= '
    <tr>  
                         <td>1</td>  
                         <td>2</td>  
                         <td>3</td>  
       <td style="background-color: blue;">4</td>  
       <td>5</td>
                    </tr>
   ';
  
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
  

  
?>  