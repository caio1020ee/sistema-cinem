<?php for($c = 1;$c <= $lc['Colunas'] ;$c++){ ?>
   
   <div style="display: flex; flex-direction:row; justify-content: center;">
       <?php foreach($lugares as $lugar){ ?>
       
       
           <?php if($lugar['Coluna'] == $c){ ?>
       <div style="display: flex; flex-direction:column;"    >
       
       <img src="assento.png" alt="assento" style="background-color:grey; width:40px; height:40px; ">
       <?php echo htmlspecialchars($lugar['Id_lugar'])?>
       <?php }?>
       
       
       
       </div>
       <div style="width: 5px;"></div>
       <?php }?>
       <!------------------------------------------------->
       

   </div>  

   <?php }?> 